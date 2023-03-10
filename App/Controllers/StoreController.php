<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;
use App\Models\Store;

class StoreController extends Controller
{

    private Store $storeModel;


    public function __construct()
    {
        $this->storeModel = new Store();
    }


    public function index(): Render
    {
        $allStores = $this->storeModel->selectAll();
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
        $this->checkIdUrl("/stores");

        $singleStore = $this->storeModel->selectOneById($_GET["id"]);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if ($this->checkPostValues(["name"])) {
                $data = ["name" => $_POST["name"], "id_store" => $_GET["id"]];
                $this->storeModel->update($data);
                header("Location: /stores");
                die;
            }

            Session::set("error", "Please give a name to the store");
        }

        return Render::make("Stores/edit", compact("singleStore"));
    }



    public function delete(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if ($this->checkPostValues(["id_store"])) {
                $this->storeModel->delete($_POST["id_store"]);
            }
        }

        header("Location: /stores");
    }
}
