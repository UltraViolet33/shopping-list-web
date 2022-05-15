<?php

namespace App\Controllers;

use App\Core\Database\Database;
use App\Core\Render;
use App\Models\User;

class HomeController
{
    /**
     * index
     *
     * @return string
     */
    public function index(): Render
    {
        return Render::make("Home/index");
    }
}
