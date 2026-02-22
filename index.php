<?php

ob_start();

require __DIR__ . "/vendor/autoload.php";

use Source\Core\Session;
use CoffeeCode\Router\Router;

$session = new Session();
$router = new Router(url(), "@");

$router->namespace('Source\App\Controllers');
$router->get('/', 'Web@home');
$router->get('/sobre', 'Web@about');
$router->get('/termos', 'Web@terms');

$router->namespace('Source\App\Controllers')->group('/error');
$router->get('/{errorCode}', 'Web@error');

$router->dispatch();

if($router->error()){
    redirect("/error/{$router->error()}");
}

ob_end_flush();
