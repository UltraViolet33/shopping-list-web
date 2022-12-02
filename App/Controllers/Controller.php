<?php

namespace App\Controllers;

class Controller
{

    protected string $msgErrors;


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
}
