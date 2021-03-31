<?php
session_start();

require '../models/model_user.php';

$tab = ["cpilot" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer un compte pilote')),
        "cdelegate" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer un compte délégué')),
        "cstudent" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer un compte étudiant')),
        "ccompany" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer une entreprise')),
        "coffer" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer une offre')),
        "soffer" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Rechercher une offre')),
        "spilot" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Rechercher un compte pilote')),
        "sdelegate" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Rechercher un compte délégué')),
        "sstudent" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Rechercher un compte étudiant')),
        "scompany" => (Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Rechercher une entreprise')),
        "cookie" => unserialize($_COOKIE['user'])->id
    ];

require_once '../assets/vendors/autoload.php';
require '../models/model_creation_modification_company.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);


// arriv� sur la page mofification
if(isset($_GET['id'])){
    
        $result = get_company($_GET['id']);
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
        update_company($_POST['id'],$_POST['name'],$_POST['description'],$_POST['locality'],$_POST['activity_area'],$_POST['email']); 
        header('Location: ../controlers/controler_creation_modification_company.php?id='. $_POST['id']);
        
        
        
        //destination post cr�ation


    }else{
        post_form($_POST['name'],$_POST['description'],$_POST['activity_area'],$_POST['locality'],$_POST['email']);
        header('Location: ../controlers/controler_creation_modification_company.php');
    }
}else{

    //cr�ation
    echo $twig->render('creation_modification_company.html',[
    'titre'=> 'Creation Entreprise'
    ,'tab' => $tab
    ]);
}   

?>