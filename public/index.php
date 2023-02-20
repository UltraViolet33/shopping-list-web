<?php

require_once "../vendor/autoload.php";
require_once "../App/Core/config.php";

use App\Core\App;
use App\Router\Router;

$router = new Router();
$router->get('/', ['App\Controllers\ProductController', 'index']);


// Product
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
$router->post("/list", ["App\Controllers\ListController", "index"]);
$router->get("/getList", ["App\Controllers\ListController", "getProductList"]);


// Store
$router->get("/stores", ["App\Controllers\StoreController", "index"]);
$router->get("/store/add", ["App\Controllers\StoreController", "create"]);
$router->post("/store/add", ["App\Controllers\StoreController", "create"]);
$router->get("/store/edit", ["App\Controllers\StoreController", "update"]);
$router->post("/store/edit", ["App\Controllers\StoreController", "update"]);
$router->post("/store/delete", ["App\Controllers\StoreController", "delete"]);

(new App($router, ["method" => $_SERVER["REQUEST_METHOD"], "uri" => $_SERVER["REQUEST_URI"]]))->run();
