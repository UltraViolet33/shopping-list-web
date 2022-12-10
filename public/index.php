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

$router->post("/product/delete", ['App\Controllers\ProductController', 'delete']);
$router->get("/product/details", ["App\Controllers\ProductController", 'showDetails']);


$router->get("/product/addStore", ["App\Controllers\ProductController", 'addStoreToProduct']);
$router->post("/product/addStore", ["App\Controllers\ProductController", 'addStoreToProduct']);



// List
$router->get("/list", ["App\Controllers\ListController", "index"]);


// Stores
$router->get("/stores", ["App\Controllers\StoreController", "index"]);
$router->get("/stores/add", ["App\Controllers\StoreController", "create"]);
$router->post("/stores/add", ["App\Controllers\StoreController", "create"]);
$router->get("/stores/edit", ["App\Controllers\StoreController", "update"]);
$router->post("/stores/edit", ["App\Controllers\StoreController", "update"]);



(new App($router, ["method" => $_SERVER["REQUEST_METHOD"], "uri" => $_SERVER["REQUEST_URI"]]))->run();
