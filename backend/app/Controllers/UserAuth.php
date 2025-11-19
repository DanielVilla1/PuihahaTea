<?php

namespace App\Controllers;

// Import global helper functions explicitly so static analysis resolves them
use function session;
use function redirect;
use function view;
use function log_message;
use function config;
use Config\Services as Services;

use App\Models\CustomerModel;

class UserAuth extends BaseController
{
    /**
     * Send a verification email with a code.
     * Kept here (controller) per project preference, not in Config\Email.
     */
    private function sendVerificationEmail(string $toEmail, string $toName, string $code): bool
    {
        $svc = Services::email();

        // Pull defaults from config or environment; fall back to a sane dev value
        $cfg = config('Email'); // \Config\Email
        $fromEmail = $cfg->fromEmail !== '' ? $cfg->fromEmail : (getenv('email.fromEmail') ?: 'no-reply@puihahatea.local');
        $fromName  = $cfg->fromName  !== '' ? $cfg->fromName  : (getenv('email.fromName')  ?: 'PuihahaTea');

        $svc->setFrom($fromEmail, $fromName);
        $svc->setTo($toEmail);
        $svc->setSubject('Verify your email');
        $body = "Hello {$toName},\n\nHere is your six-digit verification code:\n\n{$code}\n\nPlease open the verification page on our site and enter this code to activate your account. If you did not request this, please ignore this message.";
        $svc->setMessage($body);

        try {
            $ok = (bool) $svc->send();
            if (! $ok && function_exists('log_message')) {
                $dbg = method_exists($svc, 'printDebugger') ? (string) $svc->printDebugger(['headers', 'subject', 'body']) : 'no-debugger';
                log_message('error', 'Email send returned false. Debug: {dbg}', ['dbg' => $dbg]);
            }
            return $ok;
        } catch (\Throwable $e) {
            if (function_exists('log_message')) {
                log_message('error', 'Email verification send failed: {msg}', ['msg' => $e->getMessage()]);
            }
            return false;
        }
    }
    // Show public login page
    public function login(): string|\CodeIgniter\HTTP\ResponseInterface
    {
        // If already logged in as a customer, route to home for now
        if (session()->get('customer_id')) {
            return redirect()->to('/');
        }
        return view('user/login', [
            'title' => 'Sign In — PuihahaTea',
            'success' => session()->getFlashdata('success'),
            'error'   => session()->getFlashdata('error'),
        ]);
    }

    public function doLogin()
    {
        $email = trim((string) $this->request->getPost('email'));
        $pass  = (string) $this->request->getPost('password');
        if ($email === '' || $pass === '') {
            return redirect()->to('/login')->with('error', 'Email and password are required.');
        }
        $model = new CustomerModel();
        $customer = $model->where('email', $email)->first();
        if (! $customer || empty($customer['password_hash']) || ! password_verify($pass, (string) $customer['password_hash'])) {
            return redirect()->to('/login')->with('error', 'Invalid credentials.');
        }
        if (empty($customer['verified_at'])) {
            return redirect()->to('/login')->with('error', 'Please verify your email before signing in.');
        }
        // Set session for customer
        session()->set([
            'customer_id' => (int) $customer['id'],
            'customer_name' => (string) ($customer['name'] ?? ''),
            'customer_email' => (string) ($customer['email'] ?? ''),
            'customer_status' => (string) (isset($customer['status']) && $customer['status'] !== '' ? $customer['status'] : 'regular'),
        ]);

        // Merge guest cart if present
        $guestId = (int) (session()->get('guest_customer_id') ?? 0);
        if ($guestId > 0 && $guestId !== (int) $customer['id']) {
            try {
                $cartSvc = \Config\Services::cartService();
                $cartSvc->mergeGuestCart($guestId, (int) $customer['id']);
                // Clear guest id so future operations use real customer id only
                session()->remove('guest_customer_id');
            } catch (\Throwable $e) {
                // swallow errors; cart merge failure should not block login
            }
        }
        return redirect()->to('/')->with('success', 'Signed in successfully.');
    }

    // Show registration page
    public function register(): string|\CodeIgniter\HTTP\ResponseInterface
    {
        if (session()->get('customer_id')) {
            return redirect()->to('/');
        }
        return view('user/register', [
            'title' => 'Create Account — PuihahaTea',
            'success' => session()->getFlashdata('success'),
            'error'   => session()->getFlashdata('error'),
        ]);
    }

    public function doRegister()
    {
        $name  = trim((string) $this->request->getPost('name'));
        $email = trim((string) $this->request->getPost('email'));
        $addr  = trim((string) $this->request->getPost('address'));
        $cell  = trim((string) $this->request->getPost('cellphone'));
        $pass  = (string) $this->request->getPost('password');
        $conf  = (string) $this->request->getPost('password_confirm');

        if ($name === '' || $email === '' || $pass === '' || $conf === '' || $pass !== $conf) {
            return redirect()->to('/register')->with('error', 'Please complete the form; passwords must match.');
        }
        $model = new CustomerModel();
        // Unique email check
        if ($model->where('email', $email)->first()) {
            return redirect()->to('/register')->with('error', 'Email is already registered.');
        }
        // Generate account number and 6-digit verification code
        $accountNo = 'CUST-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        try {
            $token = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } catch (\Throwable $e) {
            $token = str_pad((string) mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        }
        $now = date('Y-m-d H:i:s');

        // Insert + send email as one atomic operation; rollback on send failure
        $db = \Config\Database::connect();
        $db->transBegin();

        $ok = $model->insert([
            'account_number'    => $accountNo,
            'name'              => $name,
            'address'           => $addr !== '' ? $addr : null,
            'email'             => $email,
            'cellphone'         => $cell !== '' ? $cell : null,
            'status'            => 'regular',
            'password_hash'     => password_hash($pass, PASSWORD_BCRYPT),
            'verification_token' => $token,
            'token_sent_at'     => $now,
        ], true);

        if (! $ok) {
            $db->transRollback();
            return redirect()->to('/register')->with('error', 'Registration failed. Please try again.');
        }

        // Send verification email (code-based; no links)
        $sent = $this->sendVerificationEmail($email, $name, $token);
        if (! $sent) {
            // rollback the insert so no record is created when email cannot be sent
            $db->transRollback();
            return redirect()->to('/register')->with('error', 'We could not send your verification email. Please try again later.');
        }

        $db->transCommit();

        // After registration, guide user straight to verification page
        $masked = $email;
        $atPos = strpos($email, '@');
        if ($atPos !== false) {
            $local = substr($email, 0, $atPos);
            $domain = substr($email, $atPos);
            $maskedLocal = strlen($local) > 2 ? substr($local, 0, 1) . str_repeat('*', max(1, strlen($local) - 2)) . substr($local, -1) : str_repeat('*', strlen($local));
            $masked = $maskedLocal . $domain;
        }
        $msg = 'We sent a verification code to ' . $masked . '. Enter it below to activate your account.';
        return redirect()->to('/verify')->with('success', $msg);
    }

    // Email verification endpoint
    public function verify(string $token)
    {
        $token = trim($token);
        if ($token === '') {
            return redirect()->to('/login')->with('error', 'Invalid verification token.');
        }
        $model = new CustomerModel();
        $customer = $model->where('verification_token', $token)->first();
        if (! $customer) {
            return redirect()->to('/login')->with('error', 'Verification link is invalid or has already been used.');
        }
        $ok = $model->update((int)$customer['id'], [
            'verification_token' => null,
            'verified_at' => date('Y-m-d H:i:s'),
        ]);
        if (! $ok) {
            return redirect()->to('/login')->with('error', 'Unable to verify at the moment. Please try again.');
        }
        return redirect()->to('/login')->with('success', 'Email verified! You can now sign in.');
    }

    // Show verification form (code input)
    public function verifyForm(): string|\CodeIgniter\HTTP\ResponseInterface
    {
        if (session()->get('customer_id')) {
            return redirect()->to('/');
        }
        return view('user/verify', [
            'title' => 'Verify Email — PuihahaTea',
            'success' => session()->getFlashdata('success'),
            'error'   => session()->getFlashdata('error'),
        ]);
    }

    // Submit verification code
    public function verifySubmit()
    {
        $code = trim((string) $this->request->getPost('code'));
        if ($code === '' || !preg_match('/^\d{6}$/', $code)) {
            return redirect()->to('/verify')->with('error', 'Please enter the 6-digit code sent to your email.');
        }
        $model = new CustomerModel();
        $customer = $model->where('verification_token', $code)->first();
        if (! $customer) {
            return redirect()->to('/verify')->with('error', 'Invalid or expired verification code.');
        }
        $ok = $model->update((int) $customer['id'], [
            'verification_token' => null,
            'verified_at' => date('Y-m-d H:i:s'),
        ]);
        if (! $ok) {
            return redirect()->to('/verify')->with('error', 'Unable to verify right now. Please try again.');
        }
        return redirect()->to('/login')->with('success', 'Email verified! You can now sign in.');
    }

    // Logout customer
    public function logout()
    {
        // Clear known customer session keys
        try {
            session()->remove(['customer_id', 'customer_name', 'customer_email', 'customer_status']);
            session()->destroy();
        } catch (\Throwable $e) {
            // ignore
        }
        return redirect()->to('/')->with('success', 'Signed out.');
    }
}
