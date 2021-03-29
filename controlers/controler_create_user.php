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

    if(isset($_GET['id'])){
        
        $result = Requetes\get_user($_GET['id']);

        $promotions = Requetes\get_all_promo_name($_GET['id']);
        $rights = Requetes\get_all_rights_user($_GET['id']);

        echo $twig->render('cUser.html',
        [
            'id' => $_GET['id'],
            'first_name' => $result->first_name,
            'last_name' => $result->last_name,
            'email' => $result->email,
            'password' => '',
            'role' => $result->roles,
            'curent_center' => Requetes\get_name_center($result->id_centers),
            'centers' => Requetes\get_centers(),
            'current_promotion' => $promotions,
            'promotions' => Requetes\get_promotions(),
            'rights' => \Right::get_rights('delegate'),
            'current_rights' => $rights
            ]
        );

        if(isset($_POST['id'])){

            if($_POST['role'] != 'student'){
                $all_promotions = Requetes\get_promotions();
                for ($i = 0; $i < count($all_promotions) ; $i++){
                    if(isset($_POST[$all_promotions[$i]->name])){
                        array_push($promotions, $all_promotions[$i]->name);
                    }
                }
            }else{
                array_push($promotions, $_POST['promotion']);
            }

            if ($_POST['role'] == 'delegate'){
                $all_rights = \Right::get_rights('delegate');
                for ($i = 0; $i < count($all_rights); $i++){
                    if(isset($_POST[str_replace(' ','_',$all_rights[$i]->name)])){
                        array_push($rights, $all_rights[$i]);
                    }
                }
                }else{
                    $rights = \Right::get_rights($_POST['role']);;
                }

            Requetes\update_user($_POST['id'],$_POST['last_name'],$_POST['first_name'],$_POST['email'],$_POST['password'],$_POST['role'],Requetes\get_id_center($_POST['center']), $promotions, $rights);
            header('Location: ../controlers/controler_create_user.php?id='. $_POST['id']);
        }else{
        
            if(isset($_POST['last_name'])){

                if($_POST['role'] != 'student'){
                    $all_promotions = Requetes\get_promotions();
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

                $all_rights = \Right::get_rights('delegate');

                for ($i = 0; $i < count($all_rights); $i++){
                    if(isset($_POST[str_replace(' ','_',$all_rights[$i]->name)])){
                        array_push($rights, $all_rights[$i]);
                    }
                }

                }else{
                    $rights = \Right::get_rights($_POST['role']);;
                }

                Requetes\User::insert_user($_POST['last_name'],$_POST['first_name'],$_POST['email'],hash('sha256',$_POST['password']),$_POST['role'],Requetes\get_id_center($_POST['center']),$promotions, $rights);
                header('Location: ../controlers/controler_create_user.php');
                return;

            }

            else{
                echo $twig->render('cUser.html',
                [
                    'first_name' => "",
                    'last_name' => "",
                    'email' => "",
                    'password' => "",
                    'role' => "role",
                    'curent_center' => "center",
                    'centers' => Requetes\get_centers(),
                    'current_promotion' => "promotion",
                    'promotions' => Requetes\get_promotions(),
                    'rights' => \Right::get_rights('delegate'),
                    'current_rights' => 'none'
                    ]);
            }
        }
    }
?>