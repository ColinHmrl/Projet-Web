<?php
session_start();
require_once '../assets/vendors/autoload.php';
require '../models/model_create_company.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

if(isset($_POST['name'])){
    post_form($_POST['name'],$_POST['description'],$_POST['locality'],$_POST['activity_area'],$_POST['email']);
    echo 'succeed';
    return;
    }
    else{
        echo $twig->render('create_company.html');
    }
?>
