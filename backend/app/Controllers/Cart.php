<?php

namespace App\Controllers;

use App\Services\CartService;
use App\Models\ProductModel;
use function session;
use function redirect;
use function view;

class Cart extends BaseController
{
    private function resolveCustomerId(): int
    {
        $session = session();
        $cid = (int) ($session->get('customer_id') ?? 0);
        if ($cid > 0) {
            return $cid; // authenticated user
        }
        // Guest flow: persistent guest cart id only (does not authenticate user)
        $guestId = (int) ($session->get('guest_customer_id') ?? 0);
        if ($guestId <= 0) {
            $guestId = random_int(1000000000, 1999999999);
            $session->set('guest_customer_id', $guestId);
        }
        return $guestId;
    }

    public function index()
    {
        $cid = $this->resolveCustomerId();
        $svc = new CartService();
        $cart = $svc->getActiveCart($cid);
        $items = $svc->listItems($cid);
        $total = 0.0;
        foreach ($items as $it) {
            $total += ((float) $it['unit_price']) * (int) $it['quantity'];
        }
        return view('user/cart', [
            'title' => 'Your Cart',
            'cart' => $cart,
            'items' => $items,
            'total' => number_format($total, 2, '.', ''),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function add()
    {
        $cid = $this->resolveCustomerId();
        $pid = (int) $this->request->getPost('product_id');
        $qty = (int) $this->request->getPost('quantity');
        if ($pid <= 0) {
            return redirect()->back()->with('error', 'Invalid product.');
        }
        if ($qty <= 0) $qty = 1;
        $productModel = new ProductModel();
        if (! $productModel->find($pid)) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        $svc = new CartService();
        $ok = $svc->addItem($cid, $pid, $qty);
        if (! $ok) {
            return redirect()->back()->with('error', 'Could not add item.');
        }
        // Stay on originating page (e.g., services) and show flash message
        return redirect()->back()->with('success', 'Product added to cart.');
    }

    public function update(int $itemId)
    {
        $cid = $this->resolveCustomerId();
        $qty = (int) $this->request->getPost('quantity');
        if ($qty <= 0) $qty = 1;
        $svc = new CartService();
        $ok = $svc->updateQuantity($cid, $itemId, $qty);
        if (! $ok) {
            return redirect()->to('/cart')->with('error', 'Unable to update quantity.');
        }
        return redirect()->to('/cart')->with('success', 'Quantity updated.');
    }

    public function remove(int $itemId)
    {
        $cid = $this->resolveCustomerId();
        $svc = new CartService();
        $ok = $svc->removeItem($cid, $itemId);
        if (! $ok) {
            return redirect()->to('/cart')->with('error', 'Unable to remove item.');
        }
        return redirect()->to('/cart')->with('success', 'Item removed.');
    }

    public function checkout()
    {
        // Enforce authentication for checkout (guest must sign in)
        $authCid = (int) (session()->get('customer_id') ?? 0);
        if ($authCid <= 0) {
            return redirect()->to('/login')->with('error', 'Please sign in to complete checkout.');
        }
        $cid = $authCid;
        $method = (string) $this->request->getPost('method');
        // Collect method-specific fields
        $meta = [];
        if (in_array($method, ['credit', 'debit'], true)) {
            $meta['card_holder'] = (string) $this->request->getPost('card_holder');
            $meta['card_last4']  = (string) $this->request->getPost('card_last4');
        } elseif ($method === 'ebank') {
            $meta['bank_name'] = (string) $this->request->getPost('bank_name');
            $meta['bank_ref']  = (string) $this->request->getPost('bank_ref');
        }
        $svc = new CartService();
        $res = $svc->checkout($cid, $method, $meta);
        if (! $res['ok']) {
            return redirect()->to('/cart')->with('error', $res['error'] ?? 'Checkout failed.');
        }
        return redirect()->to('/cart')->with('success', 'Checkout complete. Ref: ' . ($res['reference'] ?? 'N/A'));
    }
}
