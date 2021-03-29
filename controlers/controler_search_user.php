<?php

require_once '../assets/vendors/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

if(!empty($_GET['user_role']))
    echo $twig->render('search_user.html',['role' => $_GET['user_role']]);
else
    echo $twig->render('search_user.html');