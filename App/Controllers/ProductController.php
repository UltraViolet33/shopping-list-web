<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;
use App\Models\Product;


class ProductController extends Controller
{
    private Product $productModel;


    public function __construct()
    {
        $this->productModel = new Product();
    }


    public function index(): Render
    {
        return Render::make("Products/index");
    }


    public function getAllProducts(): string
    {
        $productsHTML = $this->displayTableProducts();
        return json_encode(["products" => $productsHTML]);
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $values = $this->getValuesFormProduct();

            if (is_array($values)) {
                $this->productModel->create($values);
                header("Location: /");
                die;
            }
        }

        return Render::make("Products/add");
    }


    private function getValuesFormProduct(): array|bool
    {
        if (isset($_POST["recurent"])) {
            return $this->checkDataRecurentProductForm();
        }

        return $this->checkDataProductNotRecurentForm();
    }


    private function checkDataProductNotRecurentForm(): array|bool
    {
        if ($this->validateDataForm()) {

            return  $values = [
                "name" => $_POST["name"],
                "stock_min" => (int)$_POST["stockMin"],
                "stock_actual" => (int) $_POST["stockActual"],
                "recurrent" => 0
            ];
        }

        return false;
    }


    private function checkDataRecurentProductForm(): array|bool
    {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            Session::set("error", "Give a name to the product");
            return false;
        }

        return $values = [
            "name" => $_POST["name"],
            "stock_min" => null,
            "stock_actual" => null,
            "recurrent" => 1
        ];
    }


    private function validateDataForm(): bool
    {
        $values = ["name", "stockActual", "stockMin"];

        if (!$this->checkPostValues($values)) {
            Session::set("error", "please fill all fields");
            return false;
        }

        if ((int) $_POST['stockMin'] < 0 || (int) $_POST['stockMin'] > 100) {
            Session::set("error", "Stock Minimal must be between 1 and 99");
            return false;
        }

        if ((int) $_POST['stockActual'] < 0 || (int) $_POST['stockActual'] > 100) {
            Session::set("error", "Stock Actual must be between 1 and 99");
            return false;
        }

        return true;
    }


    public function updateStock(): string
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);

        $idProduct = $data->idProduct;
        $stock = $data->value;

        $data = ["id" => $idProduct, "stock" => $stock];
        $this->productModel->updateStock($data);

        $productsHTML = $this->displayTableProducts();
        $message = ["result" => "OK", "products" => $productsHTML];
        return json_encode($message);
    }


    public function delete(): void
    {
        if (!isset($_POST['id_product']) || !is_numeric($_POST['id_product'])) {
            header("Location: /");
            die;
        }

        $this->productModel->delete($_POST['id_product']);
        header("Location: /");
        die;
    }


    public function showDetails(): Render
    {
        $this->checkIdUrl("/");
        $singleProduct = $this->productModel->selectOneById($_GET["id"]);
        $storesProduct = $this->productModel->selectStoresAndPrice($_GET["id"]);
        return Render::make("Products/details", compact("singleProduct", "storesProduct"));
    }


    public function update(): Render
    {
        $this->checkIdUrl("/");
        $idProduct = (int)$_GET['id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $values = $this->getValuesFormProduct();

            if (is_array($values)) {
                $values["id_product"] = $idProduct;
                $this->productModel->update($values);
                header("Location: /");
                die;
            }
        }

        $singleProduct = $this->productModel->selectOneById($idProduct);
        return Render::make("Products/edit", compact('singleProduct'));
    }


    private function displayTableProducts(): string
    {
        $products = $this->productModel->selectAll();

        $html = "";

        foreach ($products as $product) {

            $class = "";

            $html .= '<tr>
            <td>' . $product->name . ' </td>';

            if (!$product->recurrent) {

                if ($product->stock_actual <= $product->stock_min && $product->stock_min > 0) {
                    $class = "bg-danger";
                }

                $html .= '<td idProduct="' . $product->id_product . '" class="' . $class . '"><button stock="' . $product->stock_actual . '"  type="button" class="btn btn-warning" onclick="updateStock(this)" id="subStockBtn">-</button>
                ' . $product->stock_actual . '
                <button type="button" stock="' . $product->stock_actual . '" class="btn btn-primary addStockBtn" onclick="updateStock(this)" class="addStockBtn">+</button>
                </td>
                <td>' . $product->stock_min . '</td>';
            } else {
                $html .= '<td>produit récurrent</td>
                <td>produit récurrent</td>';
            }

            $html .= '<td><button type="button" class="btn btn-primary"><a style="color:white; text-decoration:none" href="/product/details?id=' . $product->id_product . '">Voir details</a></button></td>
            <td><button type="button" class="btn btn-primary"><a style="color:white; text-decoration:none" href="/product/update?id=' . $product->id_product . '">Editer</a></button></td>
            <td>
                <form method="POST" action="/product/delete" onsubmit="return confirmDelete();">
                    <input type="hidden" name="id_product" value="' . $product->id_product . '">
                    <button type="submit" class="btn btn-danger"><a style="color:white; text-decoration:none">Supprimer</a></button>
                </form>
            </td>
            </tr>';
        }

        return $html;
    }
}
