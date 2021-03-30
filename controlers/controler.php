<?php


require_once 'assets/vendors/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

if(isset($_GET['deco'])) {
    setcookie("user", "", time()-3600);
    echo 'Vous vous êtes déconnecté';
    header('Location: index.php'); 
}
else {



if(!empty($_COOKIE['user'])) {
    header('Location: controlers/controler_search_offer.php');
}
else {

    if(isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {

        require 'models/model_login.php';
        

        if(\Requetes\model_login::loginUser($_POST['inputEmail'],$_POST['inputPassword'])) {
            header('Location: index.php'); 
        }  
        else {
            echo $twig->render('login.html', ['errorlogin' => 'Erreur, mauvais mot de passe ou email','email' => $_POST['inputEmail']]);
        }

    }
    else {

        echo $twig->render('login.html');

    }

}

}