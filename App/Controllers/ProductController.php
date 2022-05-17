<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Product;

class ProductController
{

    private string $msgErrors = "";


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
        if(!empty($_POST['createProduct']))
        {
            if(!empty($_POST['name']) && !empty($_POST['stockMin']) && !empty($_POST['stockActual']))
            {
                if(!is_numeric($_POST['stockMin']))
                {
                    $this->setMsgErrors("Le stock minimale doit être un nombre ! <br>");
                }

                if(!is_numeric($_POST['stockActual']))
                {
                    $this->setMsgErrors("Le stock actuel doit être un nombre ! <br>");
                }

                if(isset($_POST['recurent']))
                {
                    if($_POST['recurent'] !== "on")
                    {
                        $this->setMsgErrors("Mauvaise valeur pour 'Produit Récurent' <br>");
                    }
                }
               
                if(strlen($this->getMsgErrors()) === 0)
                {
        
                 
                }
   
            }
            else
            {
                $this->setMsgErrors("Veuillez remplir tous les champs ! <br>");
            }
           
            
        }

        $errors = $this->getMsgErrors();
        $this->setMsgErrors(null);

        return Render::make("Products/add", compact('errors'));
    }



    private function setMsgErrors($msgError)
    {
        $this->msgErrors .= $msgError;
    }

    private function getMsgErrors()
    {
        return $this->msgErrors;
    }
}
