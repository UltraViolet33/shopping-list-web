<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;
use App\Models\Product;
use App\Models\Store;

class ProductController extends Controller
{
    private Product $productModel;
    private Store $storeModel;


    public function __construct()
    {
        $this->productModel = new Product();
        $this->storeModel = new Store();
    }


    public function index(): Render
    {
        return Render::make("Products/index");
    }



    public function getAllProducts()
    {
        $productsHTML = $this->displayTableProducts();
        return json_encode(["products" => $productsHTML]);
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!isset($_POST['recurent'])) {

                if ($this->validateDataForm()) {

                    $values = [
                        "name" => $_POST["name"],
                        "stock_min" => (int)$_POST["stockMin"],
                        "stock_actual" => (int) $_POST["stockActual"],
                        "recurent" => 0
                    ];

                    (new Product())->create($values);
                    header("Location: /");
                    die;
                }
            } else {
                if (isset($_POST['name']) || empty($_POST['name'])) {

                    $values = [
                        "name" => $_POST["name"],
                        "stock_min" => null,
                        "stock_actual" => null,
                        "recurent" => 1
                    ];

                    (new Product())->create($values);
                    header("Location: /");
                    die;
                }

                Session::set("error", "Please give a name to the product");
            }
        }

        return Render::make("Products/add");
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


    /**
     * updateStock
     *
     * @return string
     */
    public function updateStock(): string
    {
        $test = ['msg' => 'ok'];

        $data = file_get_contents("php://input");
        $data = json_decode($data);

        if (!is_object($data)) {
            $test = ['msg' => 'error'];
            return json_encode($test);
        }

        if (!$data->type === "updateStock" || !is_int($data->idProduct) || !is_int($data->value)) {
            $test = ['msg' => 'error'];
            return json_encode($test);
        }

        $idProduct = $data->idProduct;
        $stock = $data->value;

        $productModel = new Product();
        if (!$productModel->updateStock($idProduct, $stock)) {
        }

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
            if (!isset($_POST['recurent'])) {
                if ($this->validateDataForm()) {

                    $values = [
                        "id_product" => $idProduct,
                        "name" => $_POST["name"],
                        "stock_min" => (int)$_POST["stockMin"],
                        "stock_actual" => (int) $_POST["stockActual"],
                        "recurrent" => 0
                    ];

                    $this->productModel->update($values);
                    header("Location: /");
                    die;
                }
            } else {
                if (isset($_POST['name']) || empty($_POST['name'])) {

                    $values = [
                        "id_product" => $idProduct,
                        "name" => $_POST["name"],
                        "stock_min" => null,
                        "stock_actual" => null,
                        "recurrent" => 1
                    ];

                    $this->productModel->update($values);
                    header("Location: /");
                    die;
                }
                Session::set("error", "Please give a name to the product");
            }
        }

        $singleProduct = $this->productModel->selectOneById($idProduct);
        return Render::make("Products/edit", compact('singleProduct'));
    }


    public function addStoreToProduct(): Render
    {
        $this->checkIdUrl("/");
        $idProduct = (int)$_GET['id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $valuesToCheck = ["store", "price"];
            if ($this->checkPostValues($valuesToCheck, $_POST)) {
                $data = ["id_product" => $idProduct, "id_store" => $_POST["store"], "amount" => $_POST["price"]];
                $this->productModel->addStoreToProduct($data);
                header("Location: /product/details?id=" . $idProduct);
            }

            Session::set("error", "Veuillez remplir tout les champs !<br>");
        }

        $singleProduct = $this->productModel->selectOneById($idProduct);
        $storesLeftProduct = $this->storeModel->selectStoresLeftFromProduct($idProduct);

        return Render::make("Products/addStore", compact("singleProduct", "storesLeftProduct"));
    }


    public function editStoreProduct(): Render
    {
        if (!isset($_GET["idproduct"]) || !isset($_GET["idstore"])) {
            header("Location: /");
            die;
        }

        $product = $this->productModel->selectOneById($_GET["idproduct"]);
        $store = $this->storeModel->selectOneById($_GET["idstore"]);

        $values = ["id_store" => $store->id_store, "id_product" => $product->id_product];
        $price = $this->storeModel->selectPriceFromProductAndStore($values);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($this->checkPostValues(['price'])) {
                $values["amount"] = $_POST["price"];
                $this->storeModel->updatePrice($values);
                header("Location: /product/details?id=" . $product->id_product);
                die;
            }

            Session::set("error", "Il fault un prix !");
        }

        return Render::make("Products/editStore",  compact("product", "store", "price"));
    }



    private function displayTableProducts(): string
    {
        $product = new Product();
        $products = $product->selectAll();

        $html = "";

        foreach ($products as $product) {

            $class = "";

            $html .= '<tr>
            <td>' . $product->name . ' </td>';

            if (!$product->recurrent) {

                if ($product->stock_actual <= $product->stock_min) {
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
