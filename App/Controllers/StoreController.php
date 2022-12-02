<?php

namespace App\Controllers;

use App\Core\Render;
use App\Core\Helpers\Session;

class StoreController extends Controller
{

    /**
     * index
     *
     * @return Render
     */
    public function create(): Render
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            if(strlen($_POST['name']) > 0)
            {
                //insert model
                var_dump("ok");
                die;
            }

            $this->setMsgErrors("Le nom du magasin doit faire au moins 1 lettre ! <br>");
        }

        $errors = $this->getMsgErrors();
        $this->setMsgErrors(null);


        return Render::make("Stores/add", compact("errors"));
    }
}
