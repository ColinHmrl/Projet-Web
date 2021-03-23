<?php
session_start();

require_once '../assets/vendors/autoload.php';
require '../models/model.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);




if(isset($_SESSION['user'])) {


    if(isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {
    }
    echo $twig->render('search_offer.html');


}
else {

            echo "error : veuillez vous login... (redirect dans 3s) <a href='http://monprojet.fr'>Login</a>";
}
?>