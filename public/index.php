<?php  

require "../vendor/autoload.php";
require "../App/Core/config.php";

use App\Core\App;
use App\Router\Router;



$router = new Router();
$router->get('/', ['App\Controllers\HomeController', 'index']);

(new App($router, ['method' => $_SERVER['REQUEST_METHOD'], 'uri'=>$_SERVER['REQUEST_URI']]))->run();

?>