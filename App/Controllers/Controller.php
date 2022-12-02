<?php

namespace App\Controllers;

use App\Core\Render;

abstract class Controller
{

    protected string $msgErrors;

    abstract protected function update(): Render;


    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->msgErrors = "";
    }


    /**
     * setMsgErrors
     *
     * @param  ?string $msgError
     * @return void
     */
    protected function setMsgErrors(?string $msgError): void
    {
        $this->msgErrors .= $msgError;
    }


    /**
     * getMsgErrors
     *
     * @return string
     */
    protected function getMsgErrors(): string
    {
        return $this->msgErrors;
    }
    
    /**
     * checkIdUrl
     *
     * @param string $urlRedirect
     * @return void
     */
    protected function checkIdUrl(string $urlRedirect): void
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            header("Location: $urlRedirect");
        }
    }
}
