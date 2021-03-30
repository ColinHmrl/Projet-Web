<?php

require_once '../assets/vendors/autoload.php';
require_once '../models/model_user.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);


if(!empty($_COOKIE['user'])) {

//get droit
$droitmodif = !empty($_COOKIE['user']) ? true : false;

if(!empty($_GET['user_role']))
    echo $twig->render('search_user.html',['role' => $_GET['user_role'], 'droitmodif' => $droitmodif, 'user' => unserialize($_COOKIE['user'])]);
else
    echo $twig->render('search_user.html',['droitmodif' => $droitmodif, 'user' => unserialize($_COOKIE['user'])]);


}
else {

    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']);

}