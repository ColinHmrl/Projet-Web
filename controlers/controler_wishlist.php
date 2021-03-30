<?php
session_start();

require_once '../assets/vendors/autoload.php';
require '../models/model_company.php';
require '../models/model_wishlist.php';
require '../models/model_search_offer.php';
require '../assets/vendors/function/truncate.php';


$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

$functionSkills = new \Twig\TwigFunction('getSkills', function ($id) {
    return model_search_offer::getSkills($id);
});
$twig->addFunction($functionSkills);


$twig->addFunction(new \Twig\TwigFunction('getPromo', function ($id) {
    return model_search_offer::getPromo($id);
}));

$twig->addFunction(new \Twig\TwigFunction('truncate', function ($text,$length,$r,$ifspace) {
    return Text\truncate($text,$length,$r,$ifspace);
}));

$twig->addFunction(new \Twig\TwigFunction('isWishlist', function ($id1,$id2) {
    return model_wishlist::isWishlist($id1,$id2);
}));

$twig->addFunction(new \Twig\TwigFunction('getStep', function ($id1,$id2) {
    return model_wishlist::getStep($id1,$id2);
}));

if(isset($_COOKIE['user'])) {

    if(!empty($_GET['remove'])) {
        model_wishlist::remove(unserialize($_COOKIE['user'])->id,$_GET['remove']);
    }

    $table['id_users'] = unserialize($_COOKIE['user'])->id;
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
        
    //var_dump(model_wishlist::getOffer($table));
    echo $twig->render('wishlist.html',['tab'=>model_get_company::getCompanyName(),'result'=>model_wishlist::getOffer($table),'locations' => model_search_offer::getLocation(),'data' => $table,'id_user' => unserialize($_COOKIE['user'])->id,'titre' => 'Wishlist']);


}
else {

    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']);
}
?>