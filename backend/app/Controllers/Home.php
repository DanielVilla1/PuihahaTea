<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index(): string
    {
        $featured = [];
        try {
            $model = new ProductModel();
            $featured = $model->orderBy('id', 'desc')->findAll(3);
        } catch (\Throwable $e) {
        }

        if (empty($featured)) {
            $featured = [
                [
                    'title' => 'Mango Breeze Oolong',
                    'desc'  => 'Juicy mango with silky oolong and lemongrass.',
                    'img'   => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjLCaJ2aomuJX3xSt57LrOMSHPl0ykM-7jUA&s',
                    'price' => '120.00',
                    'stock' => 48,
                ],
                [
                    'title' => 'Pineapple Mint Sencha',
                    'desc'  => 'Bright sencha with pineapple and garden mint.',
                    'img'   => 'https://images.unsplash.com/photo-1523906630133-f6934a1ab1ef?q=80&w=1200&auto=format&fit=crop',
                    'price' => '135.00',
                    'stock' => 36,
                ],
                [
                    'title' => 'Passionfruit Hibiscus Cooler',
                    'desc'  => 'Tart hibiscus balanced by passionfruit sweetness.',
                    'img'   => 'https://images.unsplash.com/photo-1546177461-1a4a1e1b37b8?q=80&w=1200&auto=format&fit=crop',
                    'price' => '110.00',
                    'stock' => 22,
                ],
            ];
        }

        return \view('user/puihahatea', [
            'title'    => 'PuihahaTea',
            'featured' => $featured,
        ]);
    }

    public function services(): string
    {
        // Fetch products from the database via ProductModel.
        // If DB is unavailable or none are found (e.g., fresh DB),
        // fall back to sample data matching the previous hard-coded list.
        $products = [];
        try {
            $model = new ProductModel();
            $products = $model->findAll();
        } catch (\Throwable $e) {
            // Graceful fallback when DB/socket is unavailable (e.g., in dev without DB up)
            \log_message('error', 'Services: DB unavailable, using sample data. ' . $e->getMessage());
        }

        if (empty($products)) {
            $products = [
                [
                    'title' => 'Mango Breeze Oolong',
                    'desc'  => 'Juicy mango with silky oolong and lemongrass.',
                    'img'   => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjLCaJ2aomuJX3xSt57LrOMSHPl0ykM-7jUA&s',
                    'price' => '120.00',
                    'stock' => 48,
                ],
                [
                    'title' => 'Pineapple Mint Sencha',
                    'desc'  => 'Bright sencha with pineapple and garden mint.',
                    'img'   => 'https://images.unsplash.com/photo-1523906630133-f6934a1ab1ef?q=80&w=1200&auto=format&fit=crop',
                    'price' => '135.00',
                    'stock' => 36,
                ],
                [
                    'title' => 'Passionfruit Hibiscus Cooler',
                    'desc'  => 'Tart hibiscus balanced by passionfruit sweetness.',
                    'img'   => 'https://images.unsplash.com/photo-1546177461-1a4a1e1b37b8?q=80&w=1200&auto=format&fit=crop',
                    'price' => '110.00',
                    'stock' => 22,
                ],
                [
                    'title' => 'Coconut Lime White Tea',
                    'desc'  => 'Delicate white tea with coconut cream and lime zest.',
                    'img'   => 'https://images.unsplash.com/photo-1517685352821-92cf88aee5a5?q=80&w=1200&auto=format&fit=crop',
                    'price' => '150.00',
                    'stock' => 18,
                ],
                [
                    'title' => 'Guava Ginger Black',
                    'desc'  => 'Bold Assam anchored with guava and warming ginger.',
                    'img'   => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?q=80&w=1200&auto=format&fit=crop',
                    'price' => '125.00',
                    'stock' => 12,
                ],
                [
                    'title' => 'Lychee Orchid Oolong',
                    'desc'  => 'Floral oolong kissed by lychee nectar.',
                    'img'   => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?q=80&w=1200&auto=format&fit=crop',
                    'price' => '140.00',
                    'stock' => 30,
                ],
            ];
        }

        return \view('user/services', [
            'title'    => 'Services',
            'products' => $products,
        ]);
    }

    public function about(): string
    {
        return \view('user/about', [
            'title' => 'About',
        ]);
    }

    public function contact(): string
    {
        return \view('user/contact', [
            'title' => 'Contact',
        ]);
    }
}
