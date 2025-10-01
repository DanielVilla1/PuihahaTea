<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('puihahatea', [
            'title' => 'PuihahaTea',
        ]);
    }

    public function services(): string
    {
        // Fetch products from the database via ProductModel.
        // If none are found (e.g., fresh DB), fall back to sample data
        // matching the previous hard-coded view list.
        $model = new ProductModel();
        $products = $model->findAll();

        if (empty($products)) {
            $products = [
                [
                    'title' => 'Mango Breeze Oolong',
                    'desc'  => 'Juicy mango with silky oolong and lemongrass.',
                    'img'   => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjLCaJ2aomuJX3xSt57LrOMSHPl0ykM-7jUA&s',
                ],
                [
                    'title' => 'Pineapple Mint Sencha',
                    'desc'  => 'Bright sencha with pineapple and garden mint.',
                    'img'   => 'https://images.unsplash.com/photo-1523906630133-f6934a1ab1ef?q=80&w=1200&auto=format&fit=crop',
                ],
                [
                    'title' => 'Passionfruit Hibiscus Cooler',
                    'desc'  => 'Tart hibiscus balanced by passionfruit sweetness.',
                    'img'   => 'https://images.unsplash.com/photo-1546177461-1a4a1e1b37b8?q=80&w=1200&auto=format&fit=crop',
                ],
                [
                    'title' => 'Coconut Lime White Tea',
                    'desc'  => 'Delicate white tea with coconut cream and lime zest.',
                    'img'   => 'https://images.unsplash.com/photo-1517685352821-92cf88aee5a5?q=80&w=1200&auto=format&fit=crop',
                ],
                [
                    'title' => 'Guava Ginger Black',
                    'desc'  => 'Bold Assam anchored with guava and warming ginger.',
                    'img'   => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?q=80&w=1200&auto=format&fit=crop',
                ],
                [
                    'title' => 'Lychee Orchid Oolong',
                    'desc'  => 'Floral oolong kissed by lychee nectar.',
                    'img'   => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?q=80&w=1200&auto=format&fit=crop',
                ],
            ];
        }

        return view('services', [
            'title'    => 'Services',
            'products' => $products,
        ]);
    }

    public function about(): string
    {
        return view('about', [
            'title' => 'About',
        ]);
    }

    public function contact(): string
    {
        return view('contact', [
            'title' => 'Contact',
        ]);
    }
}
