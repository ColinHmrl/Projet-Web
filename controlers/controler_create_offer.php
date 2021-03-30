<?php
session_start();
require_once '../assets/vendors/autoload.php';
require '../models/model_create_offer.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);


// arriv� sur la page mofification
if(isset($_GET['id'])){
    
        $result = get_company($_GET['id']);
        echo $twig->render('create_offer.html',[
            'id' => $result->id,
            'Company' => $result->name,
            'locality' => $result->locality,
            'email' => $result->email,
            'activity_area' => $result->activity_area,
            'description' => $result->description,
            'titre'=> 'Modification Entreprise'
            ]);
}elseif(isset($_POST['name'])){
    if($_POST['id']){
        //destination post modification
        echo 'updated';
        update_company($_POST['id'],$_POST['name'],$_POST['description'],$_POST['locality'],$_POST['activity_area'],$_POST['email']);        //destination post cr�ation

    }else{
        echo 'created';
        post_form($_POST['name'],$_POST['description'],$_POST['locality'],$_POST['activity_area'],$_POST['email']);
    }
}else{



    //cr�ation
    echo $twig->render('create_offer.html',[
    'Company'=> ''
    ]);
}   

?>