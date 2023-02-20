<?php

namespace App\Core;

use App\Core\Helpers\Session;

class Render
{

    private string $viewPath;
    private ?array $args;


    public function __construct(string $viewPath, ?array $args = [])
    {
        $this->viewPath = $viewPath;
        $this->args = $args;
        $this->addMessageToArgs();
    }


    public function view(): string
    {
        ob_start();
        extract($this->args);
        require BASE_VIEW_PATH . 'layouts\header.php';
        require BASE_VIEW_PATH . $this->viewPath . '.php';
        require BASE_VIEW_PATH . 'layouts\footer.php';
        return ob_get_clean();
    }


    public static function make(string $viewPath, ?array $args = []): static
    {
        return new static($viewPath, $args);
    }


    public function __toString(): string
    {
        return $this->view();
    }


    private function addMessageToArgs(): void
    {
        Session::init();
        $msg = Session::getMessage();
        if ($msg) {
            $this->args['msg'] = $msg;
        }
    }
}
