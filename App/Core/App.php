<?php

namespace App\Core;

use App\Router\Router;
use Exception;

class App
{

    private Router $router;
    private array $requestURI;

    /**
     * __construct
     *
     * @param  Router $router
     * @param  array $requestURI
     * @return void
     */
    public function __construct(Router $router, array $requestURI)
    {
        $this->router = $router;
        $this->requestURI = $requestURI;
    }


    /**
     * run
     *
     * @return void
     */
    public function run(): void
    {
        try {
            echo $this->router->resolve($this->requestURI['method'], $this->requestURI['uri']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
