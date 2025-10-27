<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login(): string
    {
        // If already logged in, go to admin
        if (session()->get('user_id')) {
            return redirect()->to('/admin');
        }

        return view('admin/login', [
            'title' => 'Admin Login',
        ]);
    }

    public function doLogin()
    {
        $email = trim((string) $this->request->getPost('email'));
        $pass  = (string) $this->request->getPost('password');

        $model = new UserModel();
        $user  = $model->where('email', $email)->first();

        if (! $user || ! password_verify($pass, $user['password_hash'] ?? '')) {
            return redirect()->to('/admin/login')->with('error', 'Invalid credentials.');
        }

        // Only employees may login to admin: staff, manager, or the single admin account
        if (! in_array($user['employee_type'] ?? '', ['staff', 'manager', 'admin'], true)) {
            return redirect()->to('/admin/login')->with('error', 'Access restricted to employees.');
        }

        if (($user['status'] ?? 'inactive') !== 'active') {
            return redirect()->to('/admin/login')->with('error', 'Account is not active.');
        }

        session()->set([
            'user_id'       => $user['id'],
            'user_name'     => $user['name'],
            'user_email'    => $user['email'],
            'employee_type' => $user['employee_type'],
            'isLoggedIn'    => true,
        ]);

        return redirect()->to('/admin');
    }

    // Signup disabled: employees are added by Admin only

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}
