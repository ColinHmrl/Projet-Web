<?php

if(isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {

    require 'models/model_login.php';
    \Requetes\loginUser($_POST['inputEmail'],$_POST['inputPassword']);

    if(isset($_SESSION['user'])) {
        echo $twig->render('search_user.html', ['test' => ['Bienvenue '.$_SESSION['user']->first_name]]);
    }  
    else {
        echo $twig->render('login.html', ['errorlogin' => 'Erreur, mauvais mot de passe ou email']);
    }

    }

?>