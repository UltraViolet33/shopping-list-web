<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Product;

class HomeController
{


    public function index(): Render
    {
        $product = new Product();
        $products = $product->selectAll();
        return Render::make("Home/index", compact('products'));
    }
}
