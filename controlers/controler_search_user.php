<?php

require_once '../assets/vendors/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

echo $twig->render('search_user.html');