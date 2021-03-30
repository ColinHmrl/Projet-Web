<?php

require_once '../assets/vendors/autoload.php';
require_once '../models/model_user.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);


//get droit
$droitmodif = isset($_COOKIE['user']) ? true : false;

if(!empty($_GET['user_role']))
    echo $twig->render('search_user.html',['role' => $_GET['user_role'], 'droitmodif' => $droitmodif]);
else
    echo $twig->render('search_user.html',['droitmodif' => $droitmodif]);