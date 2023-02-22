<?php

namespace App\Controllers;

use App\Core\Render;

abstract class Controller
{

    protected string $msgErrors;

    abstract protected function update(): Render;


    public function __construct()
    {
        $this->msgErrors = "";
    }


    protected function setMsgErrors(?string $msgError): void
    {
        $this->msgErrors .= $msgError;
    }


    protected function getMsgErrors(): string
    {
        return $this->msgErrors;
    }


    protected function checkIdUrl(string $urlRedirect): void
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            header("Location: $urlRedirect");
        }
    }


    protected function checkPostValues(array $values): bool
    {
        foreach ($values as $value) {
            if (!isset($_POST[$value]) || empty($_POST[$value])) {
                return false;
            }
        }

        return true;
    }


    protected function checkFormValues(array $values, array $formValues): bool
    {
        foreach ($values as $value) {
            if (!isset($formValues[$value]) || empty($formValues[$value])) {
                return false;
            }
        }

        return true;
    }
}
