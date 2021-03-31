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
        return Company::get_company_by_id($id);
    }));


    if(isset($_GET['id'])){
        echo $twig->render('profil_company.html',[
                                                 'result'=>Company::get_company_by_id($_GET['id']),
                                                 'rateStudent' => Stats::rate('student',$_GET['id']),
                                                 'ratePilot' => Stats::rate('pilot',$_GET['id'])
                                                 ,'arr' => $tab
                                                 ]);
    }


?>