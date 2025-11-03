<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use function session;
use function redirect;
use function view;

class Account extends BaseController
{
    // Show account settings page for logged-in customer
    public function index()
    {
        $cid = (int) (session()->get('customer_id') ?? 0);
        if ($cid <= 0) {
            return redirect()->to('/login')->with('error', 'Please sign in to access your account.');
        }
        $model = new CustomerModel();
        $customer = $model->find($cid);
        if (! $customer) {
            return redirect()->to('/login')->with('error', 'Account not found. Please sign in again.');
        }
        return view('user/account', [
            'title' => 'Account Settings — PuihahaTea',
            'customer' => $customer,
            'success' => session()->getFlashdata('success'),
            'error'   => session()->getFlashdata('error'),
        ]);
    }

    // Update basic profile fields (name, address, cellphone)
    public function update()
    {
        $cid = (int) (session()->get('customer_id') ?? 0);
        if ($cid <= 0) {
            return redirect()->to('/login')->with('error', 'Please sign in to update your account.');
        }

        $name = trim((string) $this->request->getPost('name'));
        $addr = trim((string) $this->request->getPost('address'));
        $cell = trim((string) $this->request->getPost('cellphone'));

        if ($name === '') {
            return redirect()->to('/account')->with('error', 'Name is required.');
        }

        $model = new CustomerModel();
        $ok = $model->update($cid, [
            'name' => $name,
            'address' => ($addr !== '' ? $addr : null),
            'cellphone' => ($cell !== '' ? $cell : null),
        ]);

        if (! $ok) {
            return redirect()->to('/account')->with('error', 'Unable to update your profile right now.');
        }

        // Keep session display name in sync
        session()->set('customer_name', $name);

        return redirect()->to('/account')->with('success', 'Profile updated.');
    }

    // Customer self-service: change own password
    public function changePassword()
    {
        $cid = (int) (session()->get('customer_id') ?? 0);
        if ($cid <= 0) {
            return redirect()->to('/login')->with('error', 'Please sign in to update your password.');
        }

        $old = (string) $this->request->getPost('old_password');
        $new = (string) $this->request->getPost('new_password');
        $conf = (string) $this->request->getPost('confirm_password');

        if ($old === '' || $new === '' || $conf === '') {
            return redirect()->to('/account')->with('error', 'All password fields are required.');
        }
        if ($new !== $conf) {
            return redirect()->to('/account')->with('error', 'New password and confirmation do not match.');
        }
        if (strlen($new) < 8) {
            return redirect()->to('/account')->with('error', 'New password must be at least 8 characters.');
        }

        $model = new CustomerModel();
        $customer = $model->find($cid);
        if (! $customer) {
            return redirect()->to('/account')->with('error', 'Account not found. Please sign in again.');
        }
        $currentHash = (string) ($customer['password_hash'] ?? '');
        if ($currentHash === '' || ! password_verify($old, $currentHash)) {
            return redirect()->to('/account')->with('error', 'Your current password is incorrect.');
        }

        $ok = $model->update($cid, [
            'password_hash' => password_hash($new, PASSWORD_BCRYPT),
        ]);
        if (! $ok) {
            return redirect()->to('/account')->with('error', 'Unable to update password right now.');
        }
        return redirect()->to('/account')->with('success', 'Password updated successfully.');
    }
}
