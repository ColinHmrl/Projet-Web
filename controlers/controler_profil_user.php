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

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
    $twig = new \Twig\Environment($loader, [
        'cache' => false, //__DIR__.'/cache'
    ]);

    if(isset($_GET['id'])){
        $result = Requetes\User::get_user($_GET['id']);
        
        echo $twig->render('profil_user.html',[
            'id' => $_GET['id'],
            'first_name' => $result->first_name,
            'last_name' => $result->last_name,
            'email' => $result->email,
            'center' => Requetes\Center::get_center($_GET['id'])->name,
            'promotion' => Requetes\Promotion::get_promo($_GET['id'])->name,
            'roles' => $result->roles,
            'nbr_wishlist' => Requetes\Stats::get_nbr_in_wishlist($_GET['id'])->count,
            'nbr_student_in_charge' => Requetes\Stats::get_nbr_student_in_charge($_GET['id'])->count,
            'nbr_student_got_internship' => Requetes\Stats::get_nbr_student_got_internship($_GET['id'])->count
            ,'arr' => $tab                                     
    ]);
    }

?>