<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Services\CartService;
use App\Models\ProductModel;

class CartDemo extends BaseCommand
{
    protected $group       = 'cart';
    protected $name        = 'cart:demo';
    protected $description = 'Demonstrate CartService operations with a simulated session.';
    protected $usage       = 'cart:demo --customer=1 [--product=ID] [--qty=QTY] [--checkout]';

    public function run(array $params)
    {
        $customerId = (int) (CLI::getOption('customer') ?? 0);
        if ($customerId <= 0) {
            CLI::error('Provide a valid --customer id');
            return;
        }

        $qty = (int) (CLI::getOption('qty') ?? 1);
        if ($qty < 1) {
            $qty = 1;
        }

        $productId = CLI::getOption('product');
        $doCheckout = CLI::getOption('checkout') !== null;

        $session = service('session');
        $session->set('customer_id', $customerId);
        $session->set('customer_name', 'Demo Customer');
        $session->set('customer_email', 'demo@example.test');
        $session->set('customer_status', 'regular');

        /** @var CartService $cartService */
        $cartService = service('cartService');
        $productModel = new ProductModel();

        if (!$productId) {
            $first = $productModel->orderBy('id', 'asc')->first();
            if (!$first) {
                CLI::write('No products found: creating a sample product...', 'yellow');
                $productId = $productModel->insert([
                    'title' => 'Sample Tea',
                    'desc' => 'Auto-generated demo product',
                    'price' => '99.50',
                    'stock' => 100,
                    'category' => 'tea'
                ]);
                CLI::write("Created sample product id: {$productId}", 'yellow');
            } else {
                $productId = $first['id'];
                CLI::write("Using first product id: {$productId}", 'yellow');
            }
        }

        CLI::write("Adding product {$productId} qty {$qty} to cart for customer {$customerId}...", 'green');
        $cartService->addItem($customerId, (int) $productId, $qty);

        $items = $cartService->listItems($customerId);
        if (empty($items)) {
            CLI::write('Cart is still empty.', 'red');
        } else {
            CLI::write('Current Cart Items:', 'cyan');
            foreach ($items as $row) {
                $sub = ((float) $row['unit_price']) * (int) $row['quantity'];
                CLI::write(sprintf(' - Item #%d product:%d qty:%d unit:%.2f subtotal:%.2f', $row['id'], $row['product_id'], $row['quantity'], $row['unit_price'], $sub));
            }
        }

        if ($doCheckout) {
            CLI::write('Performing simulated checkout (credit)...', 'blue');
            $result = $cartService->checkout($customerId, 'credit');
            if ($result['ok'] ?? false) {
                CLI::write('Checkout completed. Order ID: ' . ($result['order_id'] ?? 'n/a'), 'green');
                CLI::write('Payment reference: ' . ($result['reference'] ?? 'n/a'), 'yellow');
            } else {
                CLI::error('Checkout failed: ' . ($result['error'] ?? 'unknown'));
            }
        }

        CLI::write('Demo complete.', 'green');
    }
}
