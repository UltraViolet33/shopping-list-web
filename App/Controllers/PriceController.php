<?php

namespace App\Controllers;

use App\Core\Helpers\Session;
use App\Core\Render;
use App\Models\Price;
use App\Models\Store;
use App\Models\Product;

class PriceController extends Controller
{

    private Price $priceModel;
    private Product $productModel;
    private Store $storeModel;


    public function __construct()
    {
        $this->priceModel = new Price();
        $this->productModel = new Product();
        $this->storeModel = new Store();
    }


    public function index(): Render
    {
        return Render::make("prices/index");
    }


    public function create(): Render
    {
        $this->checkIdUrl("/");
        $idProduct = (int)$_GET['id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $valuesToCheck = ["store", "price"];
            if ($this->checkPostValues($valuesToCheck, $_POST)) {
                $data = ["id_product" => $idProduct, "id_store" => $_POST["store"], "amount" => $_POST["price"]];
                $this->priceModel->create($data);
                header("Location: /product/details?id=" . $idProduct);
            }

            Session::set("error", "Veuillez remplir tout les champs !<br>");
        }

        $singleProduct = $this->productModel->selectOneById($idProduct);
        $storesLeftProduct = $this->storeModel->selectStoresLeftFromProduct($idProduct);
    
        return Render::make("prices/add", compact("singleProduct", "storesLeftProduct"));
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
