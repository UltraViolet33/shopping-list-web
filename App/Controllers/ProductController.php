<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;
use App\Models\Product;

class ProductController extends Controller
{

    /**
     * index
     *
     * @return Render
     */
    public function index(): Render
    {
        $productsHTML = $this->displayTableProducts();
        return Render::make("Products/index", compact('productsHTML'));
    }


    /**
     * index
     *
     * @return Render
     */
    public function create(): Render
    {
        if (!empty($_POST['createProduct'])) {

            if (!empty($_POST['name']) && !empty($_POST['stockMin']) && !empty($_POST['stockActual'])) {

                $recurent = 0;

                if (!is_numeric($_POST['stockMin'])) {
                    $this->setMsgErrors("Le stock minimale doit être un nombre ! <br>");
                }

                if (!is_numeric($_POST['stockActual'])) {
                    $this->setMsgErrors("Le stock actuel doit être un nombre ! <br>");
                }

                if (isset($_POST['recurent'])) {
                    if ($_POST['recurent'] !== "on") {
                        $this->setMsgErrors("Mauvaise valeur pour 'Produit Récurent' <br>");
                    } else {
                        $recurent = 1;
                    }
                }

                if (strlen($this->getMsgErrors()) === 0) {
                    $data = [];

                    $data["name"] = $_POST["name"];
                    $data['stock_min'] = (int)$_POST['stockMin'];
                    $data['stock_actual'] = (int)$_POST['stockActual'];
                    $data['recurent'] = $recurent;

                    if ((new Product())->create($data)) {
                        Session::init();
                        Session::setMessage("Produit créé avec succès !");
                        header("Location: /");
                        return null;
                    }
                }
            } else {
                $this->setMsgErrors("Veuillez remplir tous les champs ! <br>");
            }
        }

        $errors = $this->getMsgErrors();
        $this->setMsgErrors(null);
        return Render::make("Products/add", compact('errors'));
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

        $productModel->deleteProduct($_POST['id_product']);

        //remove product

        header("Location: /");
        return null;
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
     * displayTableProducts
     * create the html table
     * @return string
     */
    private function displayTableProducts(): string
    {
        $product = new Product();
        $products = $product->selectAll();

        $html = "";
        $confirm = "Are you sure ?";

        foreach ($products as $product) {
            $class = "";
            if ($product->stock_actual <= $product->stock_min) {
                $class = "bg-danger";
            }

            $html .= '<tr>
            <td>' . $product->name . ' </td>
            <td idProduct="' . $product->id_products . '" class="' . $class . '"><button stock="' . $product->stock_actual . '"  type="button" class="btn btn-warning" onclick="updateStock(this)" id="subStockBtn">-</button>
                ' . $product->stock_actual . '
                <button type="button" stock="' . $product->stock_actual . '" class="btn btn-primary addStockBtn" onclick="updateStock(this)" class="addStockBtn">+</button>
            </td>
            <td>' . $product->stock_min . '</td>
            <td><button type="button" class="btn btn-secondary"><a style="color:white; text-decoration:none" href="/product/update?id=' . $product->id_products . '">Editer</a></button></td>
            <td>
            <form method="POST" action="/product/delete" onsubmit="return confirm();">
            <input type="hidden" name="id_product" value="' . $product->id_products . '">
            <button type="submit" class="btn btn-danger"><a style="color:white; text-decoration:none">Supprimer</a></button>
            </form>
            </td>
            </tr>';
        }

        return $html;
    }



    public function checkPostValues()
    {
        if (!empty($_POST['name']) && !empty($_POST['stockMin']) && !empty($_POST['stockActual'])) {
            if (!is_numeric($_POST['stockMin'])) {
                $this->setMsgErrors("Le stock minimale doit être un nombre ! <br>");
                return false;
            }

            if (!is_numeric($_POST['stockActual'])) {
                $this->setMsgErrors("Le stock actuel doit être un nombre ! <br>");
                return false;
            }

            if (isset($_POST['recurent'])) {
                if ($_POST['recurent'] !== "on") {
                    $this->setMsgErrors("Mauvaise valeur pour 'Produit Récurent' <br>");
                    return false;
                }
            }

            return true;
        } else {
            $this->setMsgErrors("Veuillez remplir tous les champs ! <br>");
            return false;
        }
    }
}
