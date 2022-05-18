<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;
use App\Models\Product;

class ProductController
{

    private string $msgErrors;

    public function __construct()
    {
        $this->msgErrors = "";
        Session::init();
    }

    /**
     * index
     *
     * @return Render
     */
    public function index(): Render
    {
        return Render::make("Products/index");
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
                    $name = $_POST['name'];
                    $stockMin = (int)$_POST['stockMin'];
                    $stockActual = (int)$_POST['stockActual'];

                    $check = Product::insert($name, $stockMin, $stockActual, $recurent);

                    if ($check) {
                        Session::setMessage("Produit créé avec succès !");
                        header("Location: /");
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
     * setMsgErrors
     *
     * @param  ?string $msgError
     * @return void
     */
    private function setMsgErrors(?string $msgError): void
    {
        $this->msgErrors .= $msgError;
    }

    /**
     * getMsgErrors
     *
     * @return string
     */
    private function getMsgErrors(): string
    {
        return $this->msgErrors;
    }
}
