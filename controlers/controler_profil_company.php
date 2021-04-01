<?php
session_start();

require '../models/model_user.php';



require_once '../assets/vendors/autoload.php';
require '../models/model_company.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

$functionSkills = new \Twig\TwigFunction('getSkills', function ($id) {
    return Company::getSkills($id);
});
$twig->addFunction($functionSkills);

$twig->addFunction(new \Twig\TwigFunction('getCompany', function ($id) {
    return Company::getCompanyById($id);
}));

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
        echo $twig->render('profil_company.html',[
            'result'=>Company::getCompanyById($_GET['id']),
            'rateStudent' => Stats::rate('student',$_GET['id']),
            'ratePilot' => Stats::rate('pilot',$_GET['id']),
            'arr' => $tab
            ]);
    }
}    
else{
    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']); 
}

?>