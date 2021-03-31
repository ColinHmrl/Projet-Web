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
require '../models/model_search_company.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

$twig->addFunction(new \Twig\TwigFunction('getCompany', function ($id) {
    return modele_search_company::getCompany($id);
}));

$functionSkills = new \Twig\TwigFunction('getSkills', function ($id) {
    return modele_search_company::getSkills($id);
});
$twig->addFunction($functionSkills);

$result = get_activity();
$outputActivityArea = '';
foreach ($result as $e){
    foreach ( $e as $p){
        $outputActivityArea .= '<option name='.$p.'>'.$p.'</option>';
    }
}
$result = get_skills();
$outputSkills = '';
foreach ($result as $e){
    foreach ( $e as $p){
        $outputSkills .= '<option name='.$p.'>'.$p.'</option>';
    }
}

$result = get_locality();
$outputLocality = '';
foreach ($result as $e){
    foreach ( $e as $p){
        $outputLocality .= '<option name='.$p.'>'.$p.'</option>';
    }
}




if(isset($_SESSION['user'])) {

      

    $table = [];
    
    if(!empty($_GET['companyName']))
        $table['name'] = $_GET['companyName'];
    if(!empty($_GET['activityArea']))
        $table['activity_area'] = $_GET['activityArea'];
    if(!empty($_GET['locality']))
        $table['locality'] = $_GET['locality'];
    if(!empty($_GET['skills']))
        $table['skills'] = $_GET['skills'];
    if(!empty($_GET['numberOfTrainee']))
        $table['number_of_trainee'] = $_GET['numberOfTrainee'];
        /*
    if(!empty($_GET['traineeScore']))
        $table['trainee_score'] = $_GET['traineeScore'];
    if(!empty($_GET['pilotScore']))
        $table['pilot_score'] = $_GET['pilotScore'];     */   
        
            
    if(!empty($_GET['traineeScore'])){
        $v = 0;
        switch($_GET['traineeScore']){
            default :
                $v = 4;
            break;
            case "A":
            $v = 1;
            break;
            case "B":
            $v = 2;
            break;
            case "C":
            $v = 3;
            break;
            case "D":
            $v = 4;
            break;
            $table['trainee_score'] = $v;
        } 
    }
    if(!empty($_GET['PilotScore'])){
        $v = 0;
        switch($_GET['pilotScore']){
            default :
                $v = 0;
            break;
            case "A":
            $v = 3;
            break;
            case "B":
            $v = 2;
            break;
            case "C":
            $v = 1;

            break;
            $table['pilot_score'] = $v;
        } 
    }
     
    
    echo $twig->render('search_company.html',['activity_area' => $outputActivityArea,
                                              'skills' => $outputSkills,
                                              'locality' => $outputLocality,
                                              'result'=>modele_search_company::getCompany($table)
                                              ,'arr' => $tab
                                              ]);

}


?>