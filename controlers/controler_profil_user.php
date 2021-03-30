<?php
    session_start();

    require_once '../assets/vendors/autoload.php';
    require '../models/model_user.php';

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
    $twig = new \Twig\Environment($loader, [
        'cache' => false, //__DIR__.'/cache'
    ]);

    if(isset($_GET['id'])){
        $result = Requetes\User::get_user($_GET['id']);
        var_dump($result);
         echo $twig->render('profil_user.html',[
                                                 'id' => $_GET['id'],
                                                 'first_name' => $result->first_name,
                                                 'last_name' => $result->last_name,
                                                 'email' => $result->email,
                                                 'center' => Requetes\Center::get_center($_GET['id'])->name,
                                                 'promotion' => Requetes\Promotion::get_promo($_GET['id'])->name,
                                                 'roles' => $result->roles

                                                 ]);
    }


?>