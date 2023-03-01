<?php

namespace App\Controllers;

use App\Core\Render;

abstract class Controller
{

    abstract protected function update(): Render;

    

    protected function checkIdUrl(string $urlRedirect): void
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            header("Location: $urlRedirect");
        }
    }


    protected function checkPostValues(array $values): bool
    {
        foreach ($values as $value) {
            if (!isset($_POST[$value]) || $_POST[$value] == "") {
                return false;
            }
        }

        return true;
    }
}
