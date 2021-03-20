<?php


require_once 'assets/vendors/autoload.php';
require 'models/model.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

//$template = $twig->load('index.html');



echo $twig->render('search_user.html', ['test' => testReq()]);