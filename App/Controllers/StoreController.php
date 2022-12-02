<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;
use App\Core\Helpers\Format;
use App\Models\Store;

class StoreController extends Controller
{

    /**
     * index
     *
     * @return Render
     */
    public function create(): Render
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (strlen($_POST['name']) > 0) {
                $data = ["name" => Format::cleanInput($_POST["name"])];
                if ((new Store)->create($data)) {
                    Session::init();
                    Session::setMessage("Magasin créé avec succès !");
                    header("Location: /stores/index");
                    return null;
                }

                $this->setMsgErrors("Une erreur s'est produite ! <br>");
            }

            $this->setMsgErrors("Le nom du magasin doit faire au moins 1 lettre ! <br>");
        }

        $errors = $this->getMsgErrors();
        $this->setMsgErrors(null);


        return Render::make("Stores/add", compact("errors"));
    }
}
