<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\AuditLogModel;
use App\Models\OrderModel;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    private function ensureLoggedIn()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        return null;
    }

    private function isAdmin(): bool
    {
        return (session()->get('employee_type') === 'admin');
    }

    private function isManager(): bool
    {
        return (session()->get('employee_type') === 'manager');
    }

    private function ensureAdmin()
    {
        if (! $this->isAdmin()) {
            return redirect()->to('/admin')->with('error', 'Not authorized.');
        }
        return null;
    }

    public function dashboard(): ResponseInterface|string
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir; // redirect to login
        }

        $userModel = new UserModel();
        $role = session()->get('employee_type') ?? '';

        $q      = trim((string) $this->request->getGet('q'));
        $status = $this->request->getGet('status');
        $type   = $this->request->getGet('type');

        // Exclude the single admin account from editable listing
        $builder = $userModel->where('employee_type !=', 'admin');
        // Managers can only view staff accounts (view-only)
        if ($role === 'manager') {
            $builder = $builder->where('employee_type', 'staff');
        }
        if ($q !== '') {
            $builder = $builder->groupStart()
                ->like('name', $q)
                ->orLike('email', $q)
                ->groupEnd();
        }
        if ($status) {
            $builder = $builder->where('status', $status);
        }
        if ($type) {
            $builder = $builder->where('employee_type', $type);
        }

        $users = $builder->orderBy('id', 'desc')->paginate(10, 'users');
        $pager = $userModel->pager;

        // Simple placeholders for employee dashboard summaries
        $dailySales    = 0;
        $pendingOrders = 0;
        $stockAlerts   = 0;

        $session = session();
        $data = [
            'title'   => 'Admin Dashboard',
            'users'   => $users,
            'pager'   => $pager,
            'filters' => ['q' => $q, 'status' => $status, 'type' => $type],
            'is_admin' => $this->isAdmin(),
            'is_manager' => $this->isManager(),
            'dailySales' => $dailySales,
            'pendingOrders' => $pendingOrders,
            'stockAlerts' => $stockAlerts,
            'success' => $session->getFlashdata('success'),
            'error'   => $session->getFlashdata('error'),
        ];

        // If AJAX pagination request, return only the users table partial
        $isAjax = (bool) $this->request->getGet('ajax') || $this->request->isAJAX();
        if ($isAjax) {
            return view('admin/partials/users_table', $data);
        }

        return view('admin/dashboard', $data);
    }

    public function products(): ResponseInterface|string
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }

        $products = [];
        $errorMsg = null;
        try {
            $model = new ProductModel();
            $products = $model->orderBy('id', 'desc')->findAll();
        } catch (\Throwable $e) {
            $errorMsg = 'Database unavailable. Showing empty list. ' . $e->getMessage();
        }

        $session = session();
        return view('admin/products', [
            'title'    => 'Manage Products',
            'products' => $products,
            'success'  => $session->getFlashdata('success'),
            'error'    => $session->getFlashdata('error') ?? $errorMsg,
        ]);
    }

    public function createProduct()
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }
        $data = $this->request->getPost(['title', 'desc', 'img', 'price', 'stock']);
        $model = new ProductModel();

        if (! $model->save([
            'title' => trim((string) ($data['title'] ?? '')),
            'desc'  => (string) ($data['desc'] ?? ''),
            'img'   => (string) ($data['img'] ?? ''),
            'price' => (string) ($data['price'] ?? '0.00'),
            'stock' => (int) ($data['stock'] ?? 0),
        ])) {
            return redirect()->to('/admin/products')->with('error', 'Failed to create product.');
        }

        // Audit log
        try {
            $log = new AuditLogModel();
            $log->insert([
                'actor_user_id' => (int) session()->get('user_id'),
                'action'        => 'create',
                'entity_type'   => 'product',
                'entity_id'     => (int) $model->getInsertID(),
                'details'       => json_encode(['title' => $data['title'] ?? '']),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }

        return redirect()->to('/admin/products')->with('success', 'Product created.');
    }

    public function updateProduct(int $id)
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }
        $data = $this->request->getPost(['title', 'desc', 'img', 'price', 'stock']);
        $model = new ProductModel();

        if (! $model->update($id, [
            'title' => trim((string) ($data['title'] ?? '')),
            'desc'  => (string) ($data['desc'] ?? ''),
            'img'   => (string) ($data['img'] ?? ''),
            'price' => (string) ($data['price'] ?? '0.00'),
            'stock' => (int) ($data['stock'] ?? 0),
        ])) {
            return redirect()->to('/admin/products')->with('error', 'Failed to update product.');
        }

        try {
            $log = new AuditLogModel();
            $log->insert([
                'actor_user_id' => (int) session()->get('user_id'),
                'action'        => 'update',
                'entity_type'   => 'product',
                'entity_id'     => (int) $id,
                'details'       => json_encode(['title' => $data['title'] ?? '']),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
        }

        return redirect()->to('/admin/products')->with('success', 'Product updated.');
    }

    public function deleteProduct(int $id)
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }
        if (! ($this->isAdmin() || $this->isManager())) {
            return redirect()->to('/admin/products')->with('error', 'Not authorized to delete products.');
        }
        $model = new ProductModel();
        $db    = db_connect();
        try {
            $ok = $model->delete($id);
            $dbError  = $db->error();
            $affected = $db->affectedRows();

            if (! $ok) {
                $msg = 'Failed to delete product.';
                $errs = method_exists($model, 'errors') ? $model->errors() : [];
                if (is_array($errs) && ! empty($errs)) {
                    $msg .= ' Validation: ' . json_encode($errs);
                }
                if (! empty($dbError['code'])) {
                    $msg .= ' DB[' . $dbError['code'] . ']: ' . $dbError['message'];
                }
                if ($affected === 0) {
                    $msg .= ' No rows affected. ID=' . $id;
                }
                return redirect()->to('/admin/products')->with('error', $msg);
            }

            if ($affected === 0) {
                return redirect()->to('/admin/products')->with('error', 'No product was deleted. Possibly not found. ID=' . $id);
            }

            try {
                $log = new AuditLogModel();
                $log->insert([
                    'actor_user_id' => (int) session()->get('user_id'),
                    'action'        => 'delete',
                    'entity_type'   => 'product',
                    'entity_id'     => (int) $id,
                    'details'       => null,
                    'created_at'    => date('Y-m-d H:i:s'),
                ]);
            } catch (\Throwable $e) {
            }

            return redirect()->to('/admin/products')->with('success', 'Product deleted. ID=' . $id);
        } catch (\Throwable $e) {
            return redirect()->to('/admin/products')->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function updateUser(int $id)
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }
        if ($a = $this->ensureAdmin()) return $a;
        $data = $this->request->getPost(['name', 'email', 'employee_type', 'status']);
        $model = new UserModel();
        // Prevent setting any user to admin via UI
        if (($data['employee_type'] ?? '') === 'admin') {
            return redirect()->to('/admin')->with('error', 'Changing role to Admin is not allowed.');
        }
        if (! $model->update($id, [
            'name'          => trim((string) ($data['name'] ?? '')),
            'email'         => trim((string) ($data['email'] ?? '')),
            'employee_type' => (string) ($data['employee_type'] ?? 'staff'),
            'status'        => (string) ($data['status'] ?? 'active'),
        ])) {
            return redirect()->to('/admin')->with('error', 'Failed to update user.');
        }
        try {
            $log = new AuditLogModel();
            $log->insert([
                'actor_user_id' => (int) session()->get('user_id'),
                'action'        => 'update',
                'entity_type'   => 'user',
                'entity_id'     => (int) $id,
                'details'       => json_encode(['email' => $data['email'] ?? '']),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
        }
        return redirect()->to('/admin')->with('success', 'User updated.');
    }

    public function deleteUser(int $id)
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }
        if ($a = $this->ensureAdmin()) return $a;
        $model = new UserModel();
        if (! $model->delete($id)) {
            return redirect()->to('/admin')->with('error', 'Failed to delete user.');
        }
        try {
            $log = new AuditLogModel();
            $log->insert([
                'actor_user_id' => (int) session()->get('user_id'),
                'action'        => 'delete',
                'entity_type'   => 'user',
                'entity_id'     => (int) $id,
                'details'       => null,
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
        }
        return redirect()->to('/admin')->with('success', 'User deleted.');
    }

    public function editUserForm(int $id): ResponseInterface|string
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }
        if ($a = $this->ensureAdmin()) return $a;

        $model = new UserModel();
        $user  = $model->find($id);
        if (! $user) {
            return \redirect()->to('/admin')->with('error', 'User not found.');
        }
        // Do not allow editing the canonical admin via UI
        if (($user['employee_type'] ?? '') === 'admin') {
            return \redirect()->to('/admin')->with('error', 'Editing admin account is not allowed.');
        }

        $session = \session();
        return \view('admin/user_edit', [
            'title'   => 'Edit Employee',
            'user'    => $user,
            'success' => $session->getFlashdata('success'),
            'error'   => $session->getFlashdata('error'),
        ]);
    }

    public function auditLogs(): ResponseInterface|string
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }
        if ($a = $this->ensureAdmin()) return $a;
        $logs = [];
        $pager = null;
        try {
            $model = new AuditLogModel();
            $logs = $model->orderBy('id', 'desc')->paginate(10, 'logs');
            $pager = $model->pager;
        } catch (\Throwable $e) {
        }
        return view('admin/audit_logs', [
            'title' => 'Audit Logs',
            'logs'  => $logs,
            'pager' => $pager,
        ]);
    }

    public function ingredients(): string|ResponseInterface
    {
        if ($r = $this->ensureLoggedIn()) return $r;
        return view('admin/ingredients', ['title' => 'Ingredients']);
    }
    public function suppliers(): string|ResponseInterface
    {
        if ($r = $this->ensureLoggedIn()) return $r;
        return view('admin/suppliers', ['title' => 'Suppliers']);
    }
    public function orders(): string|ResponseInterface
    {
        if ($r = $this->ensureLoggedIn()) return $r;
        $orders = [];
        $pager = null;
        try {
            $model = new OrderModel();
            $orders = $model->orderBy('id', 'desc')->paginate(10, 'orders');
            $pager = $model->pager;
        } catch (\Throwable $e) {
        }
        return view('admin/orders', [
            'title' => 'Orders',
            'orders' => $orders,
            'pager' => $pager,
            'is_admin' => $this->isAdmin(),
            'is_manager' => $this->isManager(),
        ]);
    }

    public function createOrder()
    {
        if ($r = $this->ensureLoggedIn()) return $r;
        $data = $this->request->getPost(['customer_name', 'items', 'total']);
        $model = new OrderModel();
        $ok = $model->insert([
            'customer_name' => trim((string) ($data['customer_name'] ?? '')),
            'items' => (string) ($data['items'] ?? ''),
            'status' => 'pending',
            'assigned_to' => (int) (session()->get('user_id') ?? 0) ?: null,
            'total' => (string) ($data['total'] ?? null),
        ], true);
        if (! $ok) {
            return redirect()->to('/admin/orders')->with('error', 'Failed to create order.');
        }
        try {
            $log = new AuditLogModel();
            $log->insert([
                'actor_user_id' => (int) session()->get('user_id'),
                'action'        => 'create',
                'entity_type'   => 'order',
                'entity_id'     => (int) $model->getInsertID(),
                'details'       => json_encode(['customer' => $data['customer_name'] ?? '']),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
        }
        return redirect()->to('/admin/orders')->with('success', 'Order created.');
    }

    public function updateOrderStatus(int $id)
    {
        if ($r = $this->ensureLoggedIn()) return $r;
        $next = (string) $this->request->getPost('status');
        $model = new OrderModel();
        $order = $model->find($id);
        if (! $order) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found.');
        }

        $allowed = ['pending', 'brewing', 'ready', 'delivered', 'cancelled'];
        if (! in_array($next, $allowed, true)) {
            return redirect()->to('/admin/orders')->with('error', 'Invalid status.');
        }

        $current = $order['status'] ?? 'pending';
        $isManager = $this->isManager() || $this->isAdmin();
        $isStaff = (! $this->isAdmin() && ! $this->isManager());

        $can = false;
        if ($isManager) {
            $can = true; // managers/admin can set any status
        } else {
            // staff can only progress forward in small steps
            $transitions = [
                'pending' => ['brewing'],
                'brewing' => ['ready'],
                'ready'   => ['delivered'],
            ];
            $can = isset($transitions[$current]) && in_array($next, $transitions[$current], true);
        }
        if (! $can) {
            return redirect()->to('/admin/orders')->with('error', 'Not authorized to set this status.');
        }

        if (! $model->update($id, [
            'status' => $next,
            'assigned_to' => (int) (session()->get('user_id') ?? 0) ?: null,
        ])) {
            return redirect()->to('/admin/orders')->with('error', 'Failed to update status.');
        }
        try {
            $log = new AuditLogModel();
            $log->insert([
                'actor_user_id' => (int) session()->get('user_id'),
                'action'        => 'update',
                'entity_type'   => 'order',
                'entity_id'     => (int) $id,
                'details'       => json_encode(['from' => $current, 'to' => $next]),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
        }

        return redirect()->to('/admin/orders')->with('success', 'Order updated.');
    }
    public function analytics(): string|ResponseInterface
    {
        if ($r = $this->ensureLoggedIn()) return $r;
        return view('admin/analytics', ['title' => 'Analytics']);
    }
    public function settings(): string|ResponseInterface
    {
        if ($r = $this->ensureLoggedIn()) return $r;
        if ($a = $this->ensureAdmin()) return $a;
        return view('admin/settings', ['title' => 'Settings']);
    }

    // Admin-only: create employee account
    public function createUserForm(): ResponseInterface|string
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }
        if ($a = $this->ensureAdmin()) return $a;
        $session = session();
        return view('admin/user_create', [
            'title'   => 'Add Employee',
            'success' => $session->getFlashdata('success'),
            'error'   => $session->getFlashdata('error'),
        ]);
    }

    public function storeUser()
    {
        if ($redir = $this->ensureLoggedIn()) {
            return $redir;
        }
        if ($a = $this->ensureAdmin()) return $a;

        $data = $this->request->getPost(['name', 'email', 'password', 'employee_type', 'status']);
        $name  = trim((string) ($data['name'] ?? ''));
        $email = trim((string) ($data['email'] ?? ''));
        $pass  = (string) ($data['password'] ?? '');
        $type  = (string) ($data['employee_type'] ?? 'staff');
        $stat  = (string) ($data['status'] ?? 'active');

        if ($name === '' || $email === '' || $pass === '') {
            return redirect()->to('/admin/users/create')->with('error', 'All fields are required.');
        }

        $model = new UserModel();
        if ($model->where('email', $email)->first()) {
            return redirect()->to('/admin/users/create')->with('error', 'Email already registered.');
        }

        $ok = $model->insert([
            'name'          => $name,
            'email'         => $email,
            'password_hash' => password_hash($pass, PASSWORD_BCRYPT),
            'employee_type' => in_array($type, ['staff', 'manager'], true) ? $type : 'staff',
            'status'        => in_array($stat, ['active', 'inactive'], true) ? $stat : 'active',
        ], true);

        if (! $ok) {
            return redirect()->to('/admin/users/create')->with('error', 'Failed to create employee.');
        }

        try {
            $log = new AuditLogModel();
            $log->insert([
                'actor_user_id' => (int) session()->get('user_id'),
                'action'        => 'create',
                'entity_type'   => 'user',
                'entity_id'     => (int) $model->getInsertID(),
                'details'       => json_encode(['email' => $email, 'type' => $type]),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
        }

        return redirect()->to('/admin')->with('success', 'Employee created successfully.');
    }

    public function feedback(): ResponseInterface|string
    {
        if ($redir = $this->ensureLoggedIn()) return $redir;
        return view('admin/feedback', ['title' => 'Customer Feedback']);
    }
}
