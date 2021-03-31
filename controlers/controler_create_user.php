<?php
session_start();

require_once '../assets/vendors/autoload.php';
require '../models/model_user.php';




$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);
    
$promotions = [];
$rights =[];
if(!empty($_COOKIE['user'])){


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
    
    $promotions = [];
    $rights =[];
    if(!empty($_COOKIE['user'])){

        if((Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer un compte pilote'))||(Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer un compte délégué'))||(Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer un compte étudiant'))){

            if(isset($_GET['id'])){

                
                $result = Requetes\User::getUser($_GET['id']);

                $promotions = Requetes\Promotion::getAllPromoName($_GET['id']);
                $rights = Requetes\Rights::getAllRightsUser($_GET['id']);

                echo $twig->render('cUser.html',[
                    'id' => $_GET['id'],
                    'first_name' => $result->first_name,
                    'last_name' => $result->last_name,
                    'email' => $result->email,
                    'password_ph' => "leave empty il you don'y want to change",
                    'role' => $result->roles,
                    'curent_center' => Requetes\Center::getNameCenter($result->id_centers),
                    'centers' => Requetes\Center::getCenters(),
                    'current_promotion' => $promotions,
                    'promotions' => Requetes\Promotion::getPromotions(),
                    'rights' => \Right::getRights('delegate'),
                    'current_rights' => $rights,
                    'cpilot' => Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer un compte pilote'),
                    'cdelegate'=> Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer un compte délégué'),
                    'cstudent'=> Requetes\Rights::have_right(unserialize($_COOKIE['user'])->id,'Créer un compte étudiant')
                    ,'arr' => $tab,
                    'modif' => true,
                    'id_cur' => $_GET['id']
                    ]);
                    
            }elseif(isset($_POST['last_name'])){
                if($_POST['id']){
                    if($_POST['role'] != 'student'){
                        $all_promotions = Requetes\Promotion::getPromotions();
                        for ($i = 0; $i < count($all_promotions) ; $i++){
                            if(isset($_POST[$all_promotions[$i]->name])){
                                array_push($promotions, $all_promotions[$i]->name);
                            }
                        }
                    }else{
                        array_push($promotions, $_POST['promotion']);
                    }

                    if ($_POST['role'] == 'delegate'){
                        $all_rights = \Right::getRights('delegate');
                        for ($i = 0; $i < count($all_rights); $i++){
                            if(isset($_POST[str_replace(' ','_',$all_rights[$i]->name)])){
                                array_push($rights, $all_rights[$i]);
                            }
                        }
                    }else{
                        $rights = \Right::getRights($_POST['role']);;
                    }

                    if($_POST['password'] == $_POST['sndPassword']){
                        Requetes\User::updateUser($_POST['id'],$_POST['last_name'],$_POST['first_name'],$_POST['email'],hash('sha256',$_POST['password']),$_POST['role'],Requetes\Center::getIdCenter($_POST['center']), $promotions, $rights);
                        header('Location: ../controlers/controler_create_user.php?id='. $_POST['id']);
                    }else{
                        echo "mauvais mdp";
                    }            
                }else{

                    if($_POST['role'] != 'student'){
                        $all_promotions = Requetes\Promotion::getPromotions();
                        for ($i = 0; $i < count($all_promotions) ; $i++){
                            if(isset($_POST[$all_promotions[$i]->name])){
                                array_push($promotions, $all_promotions[$i]->name);
                            }
                        }
                    }else{
                        array_push($promotions, $_POST['promotion']);
                    }
                    
                // creating the right rights table

                if ($_POST['role'] == 'delegate'){

                    $all_rights = \Right::getRights('delegate');

                for ($i = 0; $i < count($all_rights); $i++){
                    if(isset($_POST[str_replace(' ','_',$all_rights[$i]->name)])){
                        array_push($rights, $all_rights[$i]);
                    }
                }

                    }else{
                        $rights = \Right::getRights($_POST['role']);;
                    }

                    if($_POST['password'] == $_POST['sndPassword']){
                        Requetes\User::insertUser($_POST['last_name'],$_POST['first_name'],$_POST['email'],hash('sha256',$_POST['password']),$_POST['role'],Requetes\Center::getIdCenter($_POST['center']),$promotions, $rights);
                        header('Location: ../controlers/controler_create_user.php');
                    }else{
                        echo "mauvais mdp";
                    }  
                }
            }else{
                echo $twig->render('cUser.html',[
                    'first_name' => "",
                    'last_name' => "",
                    'email' => "",
                    'role' => "role",
                    'curent_center' => "center",
                    'centers' => Requetes\Center::getCenters(),
                    'current_promotion' => "promotion",
                    'promotions' => Requetes\Promotion::getPromotions(),
                    'rights' => \Right::getRights('delegate'),
                    'current_rights' => 'none',
                    'cpilot' => Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer un compte pilote'),
                    'cdelegate'=> Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer un compte délégué'),
                    'cstudent'=> Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer un compte étudiant')
                    ,'arr' => $tab
                    ]);

        }
    }else{
        echo $twig->render('error_page.html',['error' => "Error 403 : vous n'avez pas acces à cette ressource :)"]);
    }
    }else{
        echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']);
    }
}
?>