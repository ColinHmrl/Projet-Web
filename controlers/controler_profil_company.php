<?php
    session_start();

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
        return Company::getCompany($id);
    }));


    if(isset($_GET['id'])){
        echo $twig->render('profil_company.html',[
                                                 'result'=>Company::get_company_by_id($_GET['id'])
                                                 ]);
    }


?>