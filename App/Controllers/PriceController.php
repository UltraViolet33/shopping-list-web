<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;
use App\Models\Product;
use App\Models\Price;

class PriceController extends Controller
{

    private Price $priceModel;

    public function __construct()
    {
        $this->priceModel = new Price();
    }


    public function delete(): void
    {
        if ($this->checkPostValues(["id_price"])) {
            $this->priceModel->delete($_POST["id_price"]);
        }

        header("Location: /");
    }


    public function update(): Render
    {

        return new Render("store");
    }
}
