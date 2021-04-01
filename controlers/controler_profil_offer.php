<?php
session_start();

require_once '../assets/vendors/autoload.php';
require '../models/model_profil_offer.php';
require '../models/model_user.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);


if(isset($_COOKIE['user'])) {

    $tab = ["cpilot" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer un compte pilote')),
        "cdelegate" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer un compte délégué')),
        "cstudent" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer un compte étudiant')),
        "ccompany" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer une entreprise')),
        "coffer" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer une offre')),
        "soffer" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher une offre')),
        "spilot" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher un compte pilote')),
        "sdelegate" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher un compte délégué')),
        "sstudent" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher un compte étudiant')),
        "scompany" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher une entreprise')),
        "cookie" => unserialize($_COOKIE['user'])->id
    ];

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
            'howManyTrainee'=>Profil::getHowManyTrainee($_GET['id'])->nbr,
            'arr' => $tab
            ]);
    }
}    
else{
    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']); 
}

?>