<?php

require '../assets/vendors/autoload.php';
require '../models/model_user.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

if(isset($_COOKIE['user'])){
    if(isset($_GET['id']))  {
        include('../models/loginBDD.php');
        try {

            $req = $bdd->prepare('UPDATE users SET del = true WHERE id = ?;');
            if(!$req->execute([$_GET['id']]))
                print_r($bdd->errorInfo());
            header('Location: controler_search_user.php');
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}  
else {

    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']);

}

?>