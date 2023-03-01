<?php

require_once "../vendor/autoload.php";
require_once "../App/Core/config.php";

use App\Core\App;
use App\Router\Router;

$router = new Router();
$router->get('/', ['App\Controllers\ProductController', 'index']);

$router->get("/products/all", ["App\Controllers\ProductController", "getAllProducts"]);

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
$router->get("/product/store/edit", ["App\Controllers\ProductController", 'editStoreProduct']);
$router->post("/product/store/edit", ["App\Controllers\ProductController", 'editStoreProduct']);

//prices
$router->get("/prices/all", ['App\Controllers\PriceController', 'index']);
$router->get("/prices/create", ['App\Controllers\PriceController', 'create']);
$router->post("/price/delete", ['App\Controllers\PriceController', 'delete']);



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
