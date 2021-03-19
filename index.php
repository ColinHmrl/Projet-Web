<?php


require_once 'assets/vendors/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/vue');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

//$template = $twig->load('index.html');



echo $twig->render('index2.html', ['name' => 'Fabien']);