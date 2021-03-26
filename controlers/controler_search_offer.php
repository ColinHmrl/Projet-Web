<?php
session_start();

require_once '../assets/vendors/autoload.php';
require '../models/model_company.php';
require '../models/model_search_offer.php';
require '../assets/vendors/function/truncate.php';


$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

$functionSkills = new \Twig\TwigFunction('getSkills', function ($id) {
    return modele_search_offer::getSkills($id);
});
$twig->addFunction($functionSkills);


$twig->addFunction(new \Twig\TwigFunction('getPromo', function ($id) {
    return modele_search_offer::getPromo($id);
}));

$functionTruncate = new \Twig\TwigFunction('truncate', function ($text,$length,$r,$ifspace) {
    return Text\truncate($text,$length,$r,$ifspace);
});
$twig->addFunction($functionTruncate);


if(isset($_SESSION['user'])) {

    if(isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {
    }

    $table = [];

    if(!empty($_GET['company']))
        $table['name'] = $_GET['company'];

    if(!empty($_GET['promotion']))
        if(preg_match('/^A[1-5]$/',$_GET['promotion']))
        $table['promotion'] = $_GET['promotion'];

    if(!empty($_GET['duration']))
        if($_GET['duration'] != "All")
        $table['training_period'] = $_GET['duration'];

    if(!empty($_GET['remuneration']) && (float) $_GET['remuneration'] !=0)
        $table['remuneration_basis'] = (float) $_GET['remuneration'];

    if(!empty($_GET['location']))
        $table['locality_offer'] = $_GET['location'];

    if(!empty($_GET['nb_place']) && (int) $_GET['nb_place'] != 0)
        $table['nb_places'] = $_GET['nb_place'];
    
    if(!empty($_GET['offer_date']) && (int) $_GET['offer_date'] != 0)
        $table['offer_date'] = $_GET['offer_date'];
        
    
    echo $twig->render('search_offer.html',['tab'=>getCompanyName(),'result'=>modele_search_offer::getOffer($table),'locations' => modele_search_offer::getLocation(),'data' => $table]);


}
else {

            echo "error : veuillez vous login... (redirect dans 3s) <a href='http://monprojet.fr'>Login</a>";
}
?>