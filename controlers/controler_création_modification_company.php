<?php
session_start();
require_once '../assets/vendors/autoload.php';
require '../models/model_modification_company.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);
// arrivé sur la page 


if(isset($_GET['id'])){
        echo 'arrivé création';
    
        $result = get_company($_GET['id']);
        echo $twig->render('modification_company.html',[
            'id' => $result->id,
            'nameCompany' => $result->name,
            'locality' => $result->locality,
            'email' => $result->email,
            'activity_area' => $result->activity_area,
            'description' => $result->description
            ]);
}elseif(isset($_POST['name'])){
    if($_POST['id']){
        echo 'ouai :' .$_POST['id'];
        //destination post modification
        echo 'updated';
        update_company($_POST['id'],$_POST['name'],$_POST['description'],$_POST['locality'],$_POST['activity_area'],$_POST['email']);        //destination post création

    }else{
        echo 'created';
        post_form($_POST['name'],$_POST['description'],$_POST['locality'],$_POST['activity_area'],$_POST['email']);
    }
}else{



    //création
    echo $twig->render('modification_company.html');
}   

?>