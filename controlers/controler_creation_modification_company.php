<?php
session_start();

require '../models/model_user.php';
require_once '../assets/vendors/autoload.php';
require '../models/model_creation_modification_company.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);


// arriv� sur la page mofification
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
    
        $result = Company::getCompanyById($_GET['id']);
        echo $twig->render('creation_modification_company.html',[
            'id' => $result->id,
            'nameCompany' => $result->name,
            'locality' => $result->locality,
            'email' => $result->email,
            'activity_area' => $result->activity_area,
            'description' => $result->description,
            'titre'=> 'Modification Entreprise'
            ,'arr' => $tab
            ]);
}elseif(isset($_POST['name'])){
    if($_POST['id']){
        //destination post modification
        echo 'updated';
        //echo twig
        Company::updateCompany($_POST['id'],$_POST['name'],$_POST['description'],$_POST['locality'],$_POST['activity_area'],$_POST['email']); 
        header('Location: ../controlers/controler_creation_modification_company.php?id='. $_POST['id']);
        
        
        
            //destination post cr�ation


    }else{
        Company::postForm($_POST['name'],$_POST['description'],$_POST['activity_area'],$_POST['locality'],$_POST['email']);
        header('Location: ../controlers/controler_creation_modification_company.php');
    }
}else{

    //cr�ation
    echo $twig->render('creation_modification_company.html',[
    'titre'=> 'Creation Entreprise',
    'arr' => $tab
    ]);
}   

    

}
else {
    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']);
}
?>