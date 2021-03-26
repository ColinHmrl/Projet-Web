<?php
    session_start();

    require_once '../assets/vendors/autoload.php';
    require '../models/model_user.php';

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
    $twig = new \Twig\Environment($loader, [
        'cache' => false, //__DIR__.'/cache'
    ]);

    $create = true;

    if($create){
        if(isset($_POST['last_name'])){
            Requetes\insert_user($_POST['last_name'],$_POST['first_name'],$_POST['email'],$_POST['password'],$_POST['roles'],$_POST['id_centers']);
            echo 'succeed';
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
                    'curent_center' => "center"
                    ]
            );
        }
    }else{
        if(isset($_GET['id'])){
            echo "succeed get id";
            $result = Requetes\get_user($_GET['id']);
            echo $twig->render('cUser.html',
            [
                'first_name' => $result->first_name,
                'last_name' => $result->last_name,
                'email' => $result->email,
                'password' => $result->password,
                'role' => $result->role,
                'curent_center' => $result->center
                ]
            );
        }
        if(isset($_POST['name'])){
            echo 'updated';
            Requetes\update_user($_GET['id'],$_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['password'],$_POST['role'],false,$_POST['center']);
        }
    }
?>