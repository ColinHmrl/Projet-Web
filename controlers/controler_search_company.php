<?php

session_start();
require_once '../assets/vendors/autoload.php';
require '../models/model_search_company.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);



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


echo $twig->render('search_company.html',['activity_area' => $outputActivityArea,'skills' => $outputSkills, 'locality' => $outputLocality]);

if(isset($_GET['companyName'])){

    search_company(array($_GET['companyName'],$_GET['activityArea'],$_GET['locality'],$_GET['skills'],$_GET['numberOfTrainee'],$_GET['traineeScore'],$_GET['PilotScore']));

}



    '
    <div class="row">
        <h2 class="col-12">Nom de l\'entreprise</h2>

        <div class="col-6">

            <p class="row">Localité</p>
            <p class="row">Secteur d\'activité</p>
            <div>
                <h4 class="row"> Competences :</h4>
                <p class="row">compétence 1</p>
                <p class="row">compétence 2</p>
                <p class="row">compétence 3</p>

            </div>
            <p class="row">Nombre de stagiaire deja engagé</pclass="row">
            <p class="row">Eval des stagiaires </p>
            <p class="row">Eval des tuteurs  : </p>

        </div>
        <div class="col-6">
            <h4 class="row">Description</h4>
            <p class="row">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.
            </p>
        </div>
    </div>
    '



?>