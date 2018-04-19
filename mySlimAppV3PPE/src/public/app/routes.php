<?php

// Creating routes
// Psr-7 Request and Response interfaces
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use classes\DAOUser;
use controllers\UserController;

$app->get('/', 'UserController:connect')->setName('home');
$app->post('/login', 'UserController:login')->setName('validLogin');
$app->get('/accueil', 'UserController:accueil')->setName('accueil');
$app->get('/listeChien', 'UserController:listeChien')->setName('listeChien');
$app->get('/menu', 'UserController:menu')->setName('menu');
$app->post('/repas', 'UserController:repas')->setName('repas');
$app->post('/enregistrementRepas', 'UserController:enregistrementRepas')->setName('enregistrementRepas');
$app->post('/relevesPoids', 'UserController:relevesPoids')->setName('relevesPoids');
$app->post('/enregistrementReleves', 'UserController:enregistrementReleves')->setName('enregistrementReleves');
$app->post('/statistiques', 'UserController:statistiques')->setName('statistiques');
$app->post('/enregistrementMarqueCroquette', 'UserController:enregistrementMarqueCroquette')->setName('enregistrementMarqueCroquette');
$app->post('/historiqueRepas', 'UserController:historiqueRepas')->setName('historiqueRepas');
$app->post('/historiqueReleves', 'UserController:historiqueReleves')->setName('historiqueReleves');
$app->post('/retourMenu', 'UserController:retourMenu')->setName('retourMenu');
$app->get('/deconnexion', 'UserController:deconnexion')->setName('deconnexion');





