<?php

namespace App\Controllers;

use App\Core\Render;

class HomeController
{
    /**
     * index
     *
     * @return Render
     */
    public function index(): Render
    {
        return Render::make("Home/index");
    }
}
