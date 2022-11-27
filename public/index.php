<?php
require "../vendor/autoload.php";
require "../App/Core/config.php";

use App\Core\App;
use App\Router\Router;

$router = new Router();
$router->get('/', ['App\Controllers\ProductController', 'index']);

// Products
$router->get('/product/create', ['App\Controllers\ProductController', 'create']);
$router->post('/product/create', ['App\Controllers\ProductController', 'create']);
$router->get("/product/update", ['App\Controllers\ProductController', 'update']);
$router->post("/product/update", ['App\Controllers\ProductController', 'update']);
$router->post("/product/updatestock", ['App\Controllers\ProductController', 'updateStock']);


// List
$router->get("/list", ['App\Controllers\ListController', 'index']);

(new App($router, ['method' => $_SERVER['REQUEST_METHOD'], 'uri' => $_SERVER['REQUEST_URI']]))->run();
