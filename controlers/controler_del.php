<?php

require '../assets/vendors/autoload.php';
require '../models/model_user.php';
//require '../assets/vendors/class/Right.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

if(isset($_COOKIE['user'])){

    if(isset($_GET['id']) AND isset($_GET['del']))  {
        if(Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Supprimer une entreprise')){
            include('../models/loginBDD.php');
            try {

                $sql = "
                UPDATE company 
                SET  del = :del  
                WHERE id = :id ";

                $prepared = $bdd->prepare($sql);
                $prepared->execute([
                ':del' => $_GET['del'],
                ':id'=> $_GET['id']
                ]);
                header('Location: controler_search_company.php');
            }
            catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        else {

            echo $twig->render('error_page.html',['error' => 'Error 403 : Access forbidden...']);

        }
    }
}  
else {

    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']);

}


?>