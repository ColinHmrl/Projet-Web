<?php
session_start();

require_once '../assets/vendors/autoload.php';
require '../models/model_profil_offer.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);


if(isset($_COOKIE['user'])) {


    if(isset($_GET['id'])){
        $result = Profil::getProfilById($_GET['id']);
        echo $twig->render('profil_offer.html',[
            'title'=>$result->title,
            'name'=>$result->name,
            'locality_offer'=>$result->locality_offer,
            'offer_date'=>$result->offer_date,
            'training_period'=>$result->training_period,
            'remuneration_basis'=>$result->remuneration_basis,
            'nb_places'=>$result->nb_places,
            'description'=>$result->description,
            'howManyWishlist'=>Profil::getHowManyInWishlist($_GET['id'])->nbr,
            'howManyTrainee'=>Profil::getHowManyTrainee($_GET['id'])->nbr

            ]);
    }
}    
else{
    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']); 
}

?>