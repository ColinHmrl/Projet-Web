<?php

require_once '../assets/vendors/autoload.php';
require_once '../models/model_user.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);




if (!empty($_COOKIE['user'])) {



    $tab = [
        "cpilot" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Créer un compte pilote')),
        "cdelegate" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Créer un compte délégué')),
        "cstudent" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Créer un compte étudiant')),
        "ccompany" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Créer une entreprise')),
        "coffer" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Créer une offre')),
        "soffer" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Rechercher une offre')),
        "spilot" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Rechercher un compte pilote')),
        "sdelegate" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Rechercher un compte délégué')),
        "sstudent" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Rechercher un compte étudiant')),
        "scompany" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Rechercher une entreprise')),
        "cookie" => unserialize($_COOKIE['user'])->id
    ];


    if ((Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id, 'Rechercher une offre'))) {

        $droitmodif = !empty($_COOKIE['user']) ? true : false;

        if (!empty($_GET['user_role']))
            echo $twig->render('search_user.html', ['role' => $_GET['user_role'], 'droitmodif' => $droitmodif, 'user' => unserialize($_COOKIE['user']), 'arr' => $tab]);
        else
            echo $twig->render('search_user.html', ['droitmodif' => $droitmodif, 'user' => unserialize($_COOKIE['user']), 'tab' => $tab]);
    } else {
        echo $twig->render('error_page.html', ['error' => "Error 403 : vous n'avez pas acces à cette ressource :)"]);
    }
} else {

    echo $twig->render('error_page.html', ['error' => 'Error 403 : veuillez vous login...']);
}
