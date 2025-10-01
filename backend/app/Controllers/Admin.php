<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Admin extends BaseController
{
    public function dashboard(): string
    {
        $model = new ProductModel();
        $products = $model->orderBy('id', 'desc')->findAll();

        $session = session();
        return view('admin/dashboard', [
            'title'    => 'Admin Dashboard',
            'products' => $products,
            'success'  => $session->getFlashdata('success'),
            'error'    => $session->getFlashdata('error'),
        ]);
    }

    public function createProduct()
    {
        $data = $this->request->getPost(['title', 'desc', 'img']);
        $model = new ProductModel();

        if (! $model->save([
            'title' => trim((string) ($data['title'] ?? '')),
            'desc'  => (string) ($data['desc'] ?? ''),
            'img'   => (string) ($data['img'] ?? ''),
        ])) {
            return redirect()->to('/admin')->with('error', 'Failed to create product.');
        }

        return redirect()->to('/admin')->with('success', 'Product created.');
    }

    public function updateProduct(int $id)
    {
        $data = $this->request->getPost(['title', 'desc', 'img']);
        $model = new ProductModel();

        if (! $model->update($id, [
            'title' => trim((string) ($data['title'] ?? '')),
            'desc'  => (string) ($data['desc'] ?? ''),
            'img'   => (string) ($data['img'] ?? ''),
        ])) {
            return redirect()->to('/admin')->with('error', 'Failed to update product.');
        }

        return redirect()->to('/admin')->with('success', 'Product updated.');
    }

    public function deleteProduct(int $id)
    {
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
                return redirect()->to('/admin')->with('error', $msg);
            }

            if ($affected === 0) {
                return redirect()->to('/admin')->with('error', 'No product was deleted. Possibly not found. ID=' . $id);
            }

            return redirect()->to('/admin')->with('success', 'Product deleted. ID=' . $id);
        } catch (\Throwable $e) {
            return redirect()->to('/admin')->with('error', 'Exception: ' . $e->getMessage());
        }
    }
}
