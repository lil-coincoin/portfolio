<?php
require_once '../vendor/autoload.php';
session_start();
require_once '../core/Router.php';

//Chargement des variables d'environnements
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ .'/../');
$dotenv->load();
//Instancier notre routeur afin de rediriger notre utilisateur
$router = new Router();

//Nos Routes
$router->add('/', 'HomeController','index');
$router->add('/test', 'HomeController','test');
$router->add('/contact', 'HomeController','contact');
$router->add('/fixtures', 'FixtureController','index');
$router->add('/projet', 'HomeController','projet');
$router->add('/login', 'AuthController','connexion');
$router->add('/logout', 'AuthController','disconnect');
$router->add('/admin', 'AdminController','admin');
$router->add('/delete', 'AdminController','deleteProject');
$router->add('/edit', 'AdminController','edit');
$router->add('/update', 'AdminController','update');
$router->add('/add', 'AdminController','add');
$router->add('/404', 'ErrorController', 'error404');


//dispatch
$router->dispatch($_SERVER['REQUEST_URI']);
?>