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




if(isset($_COOKIE['user'])) {
    echo $twig->render('search_user.html', ['test' => 'Bienvenue '.unserialize($_COOKIE['user'])->first_name]);
}
else {

    if(isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {

        require 'models/model_login.php';
        \Requetes\loginUser($_POST['inputEmail'],$_POST['inputPassword']);

        if(isset($_COOKIE['user'])) {
            echo $twig->render('search_user.html', ['test' => 'Bienvenue '.unserialize($_COOKIE['user'])->first_name]);
        }  
        else {
            echo $twig->render('login.html', ['errorlogin' => 'Erreur, mauvais mot de passe ou email','email' => $_POST['inputEmail']]);
        }

    }
    else {

        echo $twig->render('login.html');

    }

}

