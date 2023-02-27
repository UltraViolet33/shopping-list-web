<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;
use App\Core\Helpers\Format;
use App\Models\Store;

class StoreController extends Controller
{

    private Store $storeModel;


    public function __construct()
    {
        $this->storeModel = new Store();
    }


    public function index()
    {
        $allStores = (new Store())->selectAll();
        return Render::make("Stores/index", compact('allStores'));
    }


    public function create(): Render
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if ($this->checkPostValues(["name"])) {
                $this->storeModel->create(["name" => $_POST["name"]]);
                header("Location: /stores");
                die;
            }

            Session::set("error", "Please give a name to the store");
        }

        return Render::make("Stores/add");
    }


    public function update(): Render
    {
        // if(!isset($_GET["id"]) || !is_numeric($_GET["id"]))
        // {
        //     header("Location: /stores");
        // }

        //select single store
        $singleStore = (new Store())->selectOneById($_GET["id"]);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (strlen($_POST["name"]) > 1) {
                $data = ["id_stores" => $singleStore->id_stores, "name" => Format::cleanInput($_POST["name"])];

                if ((new Store())->update($data)) {
                    Session::init();
                    Session::setMessage("Magasin créé avec succès !");
                    header("Location: /stores");
                    return null;
                }
            }

            $this->setMsgErrors("Veuillez remplir tous les champs ! <br>");
        }

        $errors = $this->getMsgErrors();
        $this->setMsgErrors(null);
        return Render::make("Stores/edit", compact("singleStore", "errors"));
    }


    /**
     * delete
     *
     * @return void
     */
    public function delete(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST["id_store"]) && !empty($_POST["id_store"])) {

                $id_store = $_POST["id_store"];

                $storeModel = new Store();
                $store = $storeModel->selectOneById($id_store);
                if ($store) {
                    $storeModel->delete($id_store);
                }
            }
        }

        header("Location: /stores");
    }
}
