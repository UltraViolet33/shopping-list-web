<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;
use App\Models\Product;
use App\Models\Store;

class ProductController extends Controller
{

    public function index(): Render
    {
        return Render::make("Products/index");
    }



    public function getAllProducts()
    {
        $productsHTML = $this->displayTableProducts();
        return json_encode(["products" => $productsHTML]);
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


    public function delete()
    {
        if (!isset($_POST['id_product']) || !is_numeric($_POST['id_product'])) {
            header("Location: /");
            return null;
        }

        $productModel = new Product();
        $productModel->delete($_POST['id_product']);

        header("Location: /");
        return null;
    }


    /**
     * showDetails
     *
     * @return Render
     */
    public function showDetails(): Render
    {
        $this->checkIdUrl("/");
        $singleProduct = (new Product())->selectOneById($_GET["id"]);
        $storesProduct = (new Product())->selectStoresAndPrice($_GET["id"]);
        return Render::make("Products/details", compact("singleProduct", "storesProduct"));
    }


    public function update(): Render
    {
        if (!isset($_GET['id'])) {
            return '404';
        }


        if (!empty($_POST['editProduct'])) {
            if ($this->checkPostValues()) {

                $data = [];
                $data['id_products'] = $_GET["id"];
                $data['name'] = $_POST["name"];

                $data['stock_min'] = (int)$_POST["stockMin"];
                $data['stock_actual'] = (int)$_POST["stockActual"];
                $data['recurrent'] = 0;

                if (isset($_POST['recurent'])) {
                    if ($_POST['recurent'] == "on") {
                        $data['recurrent'] = 1;
                    }
                }

                if ((new Product())->update($data)) {
                    Session::init();
                    Session::setMessage("Produit modifié avec succès !");
                    header("Location: /");
                    return null;
                }
            }

            var_dump($this->msgErrors);
        }

        $idProduct = (int)$_GET['id'];

        $productModel = new Product();
        $singleProduct = $productModel->getSingleProduct($idProduct);

        $errors = $this->getMsgErrors();
        $this->setMsgErrors(null);
        return Render::make("Products/edit", compact('singleProduct', "errors"));
    }


    /**
     * addStoreToProduct
     *
     * @return void
     */
    public function addStoreToProduct()
    {
        $this->checkIdUrl("/");
        $idProduct = (int)$_GET['id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            var_dump($_POST);
            $valuesToCheck = ["store", "price"];
            if ($this->checkFormValues($valuesToCheck, $_POST)) {

                //add the store to the product
                $data = ["id_products" => $idProduct, "id_stores" => $_POST["store"], "amount" => $_POST["price"]];

                (new Product())->addStoreToProduct($data);
                header("Location: /");
            } else {

                $this->setMsgErrors("Veuillez remplir tout les champs !<br>");
            }
        }

        $productModel = new Product();
        $singleProduct = $productModel->getSingleProduct($idProduct);

        $allStores = (new Store())->selectAll();

        $storesProduct = $productModel->getAllStoresProduct($idProduct);

        if ($storesProduct) {
            $stores = [];

            foreach ($allStores as $store) {
                $insert = true;

                foreach ($storesProduct as $storeProduct) {
                    if ($store->id_stores == $storeProduct->id_stores) {
                        $insert = false;
                    }
                }

                if ($insert) {
                    $stores[] = $store;
                }
            }

            $allStores = $stores;
        }


        $errors = $this->getMsgErrors();
        $this->setMsgErrors(null);

        return Render::make("Products/addStore", compact("singleProduct", "allStores", "errors"));
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

                $html .= '<td idProduct="' . $product->id_products . '" class="' . $class . '"><button stock="' . $product->stock_actual . '"  type="button" class="btn btn-warning" onclick="updateStock(this)" id="subStockBtn">-</button>
                ' . $product->stock_actual . '
                <button type="button" stock="' . $product->stock_actual . '" class="btn btn-primary addStockBtn" onclick="updateStock(this)" class="addStockBtn">+</button>
                </td>
                <td>' . $product->stock_min . '</td>';
            } else {
                $html .= '<td>produit récurrent</td>
                <td>produit récurrent</td>';
            }

            $html .= '<td><button type="button" class="btn btn-secondary"><a style="color:white; text-decoration:none" href="/product/details?id=' . $product->id_products . '">Voir details</a></button></td>
            <td><button type="button" class="btn btn-secondary"><a style="color:white; text-decoration:none" href="/product/update?id=' . $product->id_products . '">Editer</a></button></td>
            <td>
                <form method="POST" action="/product/delete" onsubmit="return confirmDelete();">
                    <input type="hidden" name="id_product" value="' . $product->id_products . '">
                    <button type="submit" class="btn btn-danger"><a style="color:white; text-decoration:none">Supprimer</a></button>
                </form>
            </td>
            </tr>';
        }

        return $html;
    }





    // public function checkPostValues()
    // {
    //     if (!empty($_POST['name']) && !empty($_POST['stockMin']) && !empty($_POST['stockActual'])) {
    //         if (!is_numeric($_POST['stockMin'])) {
    //             $this->setMsgErrors("Le stock minimale doit être un nombre ! <br>");
    //             return false;
    //         }

    //         if (!is_numeric($_POST['stockActual'])) {
    //             $this->setMsgErrors("Le stock actuel doit être un nombre ! <br>");
    //             return false;
    //         }

    //         if (isset($_POST['recurent'])) {
    //             if ($_POST['recurent'] !== "on") {
    //                 $this->setMsgErrors("Mauvaise valeur pour 'Produit Récurent' <br>");
    //                 return false;
    //             }
    //         }

    //         return true;
    //     } else {
    //         $this->setMsgErrors("Veuillez remplir tous les champs ! <br>");
    //         return false;
    //     }
    // }
}
