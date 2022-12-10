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
        // $products[] =   $this->displayTableProducts()[0];
        // $products[] = $this->displayTableProducts()[1];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            var_dump($_POST);
        }

        // $productModel = new Product();
        // $productsToBuy = $productModel->selectListProducts();

        // $this->calculatePriceByStores($productsToBuy);

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

        $stores =  $this->calculatePriceByStores($productsToBuy);

        $data = ["stores" => $stores, "products" => $productsToBuy];


        return json_encode($data);
    }

    private function calculatePriceByStores(array $products): array
    {
        $allStores = (new Store())->selectAll();
        foreach ($allStores as $store) {
            $store->totalPrice = 0;

            $data = [];
            $data["id_stores"] = $store->id_stores;

            foreach ($products as $product) {
                $data["id_products"] = $product->id_products;
                $price = (new Product())->selectPriceByStoreAndProduct($data);

                $numberToBuy = $product->stock_min - $product->stock_actual;

                $numberToBuy = $numberToBuy == 0 ? 1 : $numberToBuy;

            
                if ($price) {
                    $store->totalPrice += ((int)$price->amount * $numberToBuy);
                }
            }
        }

        return $allStores;
    }


    /**
     * displayTableProducts
     *
     * @return array
     */
    private function displayTableProducts(): array
    {
        $productModel = new Product();
        $productList = $productModel->selectListProducts();

        $html = "";

        foreach ($productList as $product) {
            $number = $product->stock_min - $product->stock_actual;

            if ($number === 1) {
                $number = 2;
            }

            if ($number === 0) {
                $number = 1;
            }

            $html .= '<tr>
                        <td>' . $product->name . ' </td>
                        <td>' . $number . ' </td>
                    </tr>';
        }

        $countProducts = count($productList);
        return [$html, $countProducts];
    }
}
