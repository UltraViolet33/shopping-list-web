<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Product;
use App\Models\Price;
use App\Models\Store;


class ListController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel =  new Product();
    }

    public function index(): Render
    {
        return Render::make("List/index");
    }


    public function getProductList(): string
    {
        $productsToBuy = $this->productModel->selectListProducts();
        $recurrentProducts = $this->productModel->selectAllRecurrentProducts();
        foreach ($recurrentProducts as $product) {
            $product->number_item = 1;
        }
        $products = array_merge($productsToBuy, $recurrentProducts);
        $products = $this->addStoresToProducts($products);

        return json_encode($products);
    }
    

    private function addStoresToProducts(array $products): array
    {
        $allStores = (new Store())->selectAll();

        foreach ($products as $product) {
            $data = [];
            $data["id_product"] = $product->id_product;
            $product->stores = [];

            foreach ($allStores as $store) {
                $data["id_store"] = $store->id_store;
                $price = (new Price())->selectPriceFromProductAndStore($data);
                if ($price) {
                    $product->stores[] = ["idStore" => $store->id_store, "storeName" => $store->name, "price" => $price];
                } else {
                    $product->stores[] = ["idStore" => $store->id_store, "storeName" => $store->name, "price" => false];
                }
            }
        }

        return $products;
    }
}
