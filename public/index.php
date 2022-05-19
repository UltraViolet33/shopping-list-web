<?php  

require "../vendor/autoload.php";
require "../App/Core/config.php";

use App\Core\App;
use App\Router\Router;

$router = new Router();

// Products
$router->get('/', ['App\Controllers\ProductController', 'index']);
$router->get('/product/create', ['App\Controllers\ProductController', 'create']);
$router->post('/product/create', ['App\Controllers\ProductController', 'create']);
$router->post("/product/updatestock", ['App\Controllers\ProductController', 'updateStock']);

// List
$router->get("/list", ['App\Controllers\ListController', 'index']);

(new App($router, ['method' => $_SERVER['REQUEST_METHOD'], 'uri'=>$_SERVER['REQUEST_URI']]))->run();
