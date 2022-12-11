<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Product;
use App\Models\Store;


class ListController
{

    /**
     * index
     *
     * @return Render
     */
    public function index(): Render
    {
        $productModel = new Product();
        $productsToBuy = $productModel->selectListProducts();
        $products = $this->addStoresToProducts($productsToBuy);

        return Render::make("List/index");
    }

    /**
     * getProductList
     *
     * @return string
     */
    public function getProductList(): string
    {
        $productModel = new Product();
        $productsToBuy = $productModel->selectListProducts();

        return json_encode($productsToBuy);
    }

    private function addStoresToProducts(array $products): array
    {
        $allStores = (new Store())->selectAll();

        foreach ($products as $product) {
            $data = [];
            $data["id_products"] = $product->id_products;
            $product->stores = [];

            foreach ($allStores as $store) {
                $data["id_stores"] = $store->id_stores;
                $price = (new Product())->selectPriceByStoreAndProduct($data);
                $product->stores[] = ["idStore" => $store->id_stores, "storeName" => $store->name, "price" => $price];
            }
        }

        return $products;
    }
}
