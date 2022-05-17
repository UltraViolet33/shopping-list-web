<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Product;

class HomeController
{
    /**
     * index
     *
     * @return Render
     */
    public function index(): Render
    {
        $product = new Product();
        return Render::make("Home/index");
    }
}
