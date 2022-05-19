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
$router->post("/product/updatestock", ['App\Controllers\ProductController', 'updateStock']);

(new App($router, ['method' => $_SERVER['REQUEST_METHOD'], 'uri'=>$_SERVER['REQUEST_URI']]))->run();

?>