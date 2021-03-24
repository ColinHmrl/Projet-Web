<?php
session_start();
require_once '../assets/vendors/autoload.php';
require '../models/model_modification_company.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

if(isset($_GET['id'])){
    echo "succeed get id";
    $result = get_company($_GET['id']);
    echo $twig->render('modification_company.html',[
        'id' => $_GET['id'],
        'nameCompany' => $result->name,
        'locality' => $result->locality,
        'email' => $result->email,
        'activity_area' => $result->activity_area,
        'description' => $result->description
        ]);
}

if(isset($_POST['name'])){
    echo 'updated';
    update_company($_POST['id'],$_POST['name'],$_POST['description'],$_POST['locality'],$_POST['activity_area'],$_POST['email']);
}

?>