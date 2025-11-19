<?php

namespace App\Services;

use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;

class CartService
{
    public function getActiveCart(int $customerId): array
    {
        $cartModel = new CartModel();
        $cart = $cartModel->where('customer_id', $customerId)->where('status', 'active')->first();
        if (! $cart) {
            $cartModel->insert(['customer_id' => $customerId, 'status' => 'active']);
            $cartId = (int) $cartModel->getInsertID();
            $cart = $cartModel->find($cartId) ?: ['id' => $cartId, 'customer_id' => $customerId, 'status' => 'active'];
        }
        return $cart;
    }

    public function addItem(int $customerId, int $productId, int $qty = 1): bool
    {
        if ($qty < 1) $qty = 1;
        $cart = $this->getActiveCart($customerId);
        $cartItemModel = new CartItemModel();
        $productModel = new ProductModel();
        $product = $productModel->find($productId);
        if (! $product) return false;
        $unitPrice = (float) ($product['price'] ?? 0);
        // If item exists, increment quantity
        $existing = $cartItemModel->where('cart_id', $cart['id'])->where('product_id', $productId)->first();
        if ($existing) {
            $newQty = (int) $existing['quantity'] + $qty;
            return (bool) $cartItemModel->update((int) $existing['id'], ['quantity' => $newQty]);
        }
        return (bool) $cartItemModel->insert([
            'cart_id' => (int) $cart['id'],
            'product_id' => $productId,
            'quantity' => $qty,
            'unit_price' => $unitPrice,
        ], true);
    }

    public function updateQuantity(int $customerId, int $itemId, int $qty): bool
    {
        if ($qty < 1) $qty = 1;
        $cart = $this->getActiveCart($customerId);
        $cartItemModel = new CartItemModel();
        $item = $cartItemModel->find($itemId);
        if (! $item || (int) $item['cart_id'] !== (int) $cart['id']) return false;
        return (bool) $cartItemModel->update($itemId, ['quantity' => $qty]);
    }

    public function removeItem(int $customerId, int $itemId): bool
    {
        $cart = $this->getActiveCart($customerId);
        $cartItemModel = new CartItemModel();
        $item = $cartItemModel->find($itemId);
        if (! $item || (int) $item['cart_id'] !== (int) $cart['id']) return false;
        return (bool) $cartItemModel->delete($itemId);
    }

    public function listItems(int $customerId): array
    {
        $cart = $this->getActiveCart($customerId);
        $cartItemModel = new CartItemModel();
        return $cartItemModel->where('cart_id', $cart['id'])->findAll();
    }

    public function checkout(int $customerId, string $method, array $paymentMeta = []): array
    {
        if (! in_array($method, ['credit', 'debit', 'ebank'], true)) {
            return ['ok' => false, 'error' => 'Invalid payment method.'];
        }
        $cart = $this->getActiveCart($customerId);
        $items = $this->listItems($customerId);
        if (empty($items)) {
            return ['ok' => false, 'error' => 'Cart is empty.'];
        }
        // Compute total & build items text (JSON for reuse)
        $total = 0.0;
        foreach ($items as $it) {
            $total += ((float) $it['unit_price']) * (int) $it['quantity'];
        }
        $orderModel = new OrderModel();
        $customerName = '';
        $session = session();
        $customerName = (string) ($session->get('customer_name') ?? '');
        $orderOk = $orderModel->insert([
            'customer_name' => $customerName,
            'items' => json_encode($items),
            'status' => 'pending',
            'assigned_to' => null,
            'total' => number_format($total, 2, '.', ''),
        ], true);
        if (! $orderOk) {
            return ['ok' => false, 'error' => 'Unable to create order.'];
        }
        $orderId = (int) $orderModel->getInsertID();
        // Simulate payment via PaymentService
        $paymentSvc = new PaymentService();
        $auth = $paymentSvc->authorize($customerId, $method, $paymentMeta);
        if (!($auth['ok'] ?? false)) {
            return ['ok' => false, 'error' => $auth['error'] ?? 'Payment failed'];
        }
        $ref = $auth['reference'];
        $paymentModel = new PaymentModel();
        $payOk = $paymentModel->insert([
            'order_id' => $orderId,
            'method' => $method,
            'amount' => number_format($total, 2, '.', ''),
            'status' => 'simulated',
            'reference' => $ref,
        ], true);
        if (!$payOk) {
            return ['ok' => false, 'error' => 'Persist payment failed'];
        }
        // Mark cart checked out and clear items
        $cartModel = new CartModel();
        $cartModel->update((int) $cart['id'], ['status' => 'checked_out']);
        // New active cart for future use
        $this->getActiveCart($customerId);
        return ['ok' => true, 'order_id' => $orderId, 'reference' => $ref, 'payment_meta' => $auth['meta'] ?? []];
    }

    public function mergeGuestCart(int $guestId, int $customerId): bool
    {
        if ($guestId <= 0 || $customerId <= 0 || $guestId === $customerId) {
            return false;
        }
        $cartModel = new CartModel();
        $guestCart = $cartModel->where('customer_id', $guestId)->where('status', 'active')->first();
        if (! $guestCart) {
            return false; // nothing to merge
        }
        $customerCart = $this->getActiveCart($customerId);
        $guestItems = (new CartItemModel())->where('cart_id', $guestCart['id'])->findAll();
        if (empty($guestItems)) {
            // mark guest cart as merged anyway
            $cartModel->update((int) $guestCart['id'], ['status' => 'merged']);
            return true;
        }
        $cartItemModel = new CartItemModel();
        foreach ($guestItems as $item) {
            $existing = $cartItemModel->where('cart_id', $customerCart['id'])->where('product_id', $item['product_id'])->first();
            if ($existing) {
                $newQty = (int) $existing['quantity'] + (int) $item['quantity'];
                $cartItemModel->update((int) $existing['id'], ['quantity' => $newQty]);
            } else {
                $cartItemModel->insert([
                    'cart_id' => (int) $customerCart['id'],
                    'product_id' => (int) $item['product_id'],
                    'quantity' => (int) $item['quantity'],
                    'unit_price' => (float) $item['unit_price'],
                ], true);
            }
        }
        // mark guest cart checked_out/merged and remove its items
        $cartModel->update((int) $guestCart['id'], ['status' => 'merged']);
        $cartItemModel->where('cart_id', $guestCart['id'])->delete();
        return true;
    }
}
