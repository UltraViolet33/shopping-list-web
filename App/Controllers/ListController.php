<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Product;

class ListController
{

    /**
     * index
     *
     * @return Render
     */
    public function index(): Render
    {
        $products[] =   $this->displayTableProducts()[0];
        $products[] = $this->displayTableProducts()[1];
        return Render::make("List/index", compact('products'));
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
