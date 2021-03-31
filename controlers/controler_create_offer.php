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
require '../models/model_create_offer.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

//affichage select company
$result = Offer::get_company();
$outputCompany = '';
foreach ($result as $e){
    foreach ( $e as $p){
        $outputCompany .= "<option name=".$p.">".$p."</option>";
    }
}




// arriv� sur la page mofification
if(isset($_COOKIE['user'])) {
    if(isset($_GET['id'])){
        //modif
    
        $result = Offer::get_offer($_GET['id']);
        

        

        echo $twig->render('create_offer.html',[
                'locality_offer'=> $result->locality_offer,
                'training_period'=> $result->training_period,
                'remuneration_basis'=> $result->remuneration_basis,
                'offer_date'=> $result->offer_date,
                'date_post'=> $result->date_post,  //2021-03-29 11:33:17
                'title'=> $result->title,
                'nb_places' => $result->nb_places,
                'description' => $result->description,
                'Company' => "<option value=".$result->name." name=".$result->name." selected>".$result->name."</option>",
                'id'=>$result->id,
                'checked1'=> Offer::CheckOfferPromotionRelation(1,$result->id),
                'checked2'=> Offer::CheckOfferPromotionRelation(2,$result->id),
                'checked3'=> Offer::CheckOfferPromotionRelation(3,$result->id),
                'checked4'=> Offer::CheckOfferPromotionRelation(4,$result->id),
                'checked5'=> Offer::CheckOfferPromotionRelation(5,$result->id),
                'arr' => $tab,
                'titre'=> 'Modification Offer']);

    }elseif(isset($_POST['locality_offer'])){
        if(isset($_POST['id'])){
            //destination post modification
            echo 'updated';
            Offer::update_form($_POST['id'],$_POST['locality_offer'],$_POST['training_period'],$_POST['remuneration_basis'],$_POST['offer_date'],$_POST['title'],$_POST['nb_places'],$_POST['description']);        //destination post cr�ation
            
            Offer::DeleteOfferPromotion($_POST['id']);
            $i = 1;
            for ($i = 1; $i <= 5; $i++){
                if(!empty($_POST['A'.$i])){
                    echo $_POST['id'];
                    Offer::PostOfferPromotion($i,$_POST['id']);
                }
            }
            //redirection
            header('Location: ../controlers/controler_create_offer.php');
        }else{
            echo 'created';
            Offer::post_form($_POST['locality_offer'],$_POST['training_period'],$_POST['remuneration_basis'],$_POST['offer_date'],$_POST['title'],$_POST['nb_places'],$_POST['description'],'HamerelCorp');

            $i = 1;
            for ($i = 1; $i <= 5; $i++){
                if(!empty($_POST['A'.$i])){
                    Offer::PostOfferPromotion($i,Offer::GetLastOfferID());
                }
            }
            //redirection
            header('Location: ../controlers/controler_create_offer.php');
            




            
        }
    }else{



        //cr�ation
        echo $twig->render('create_offer.html',[
        'Company'=> $outputCompany,
        'titre'=> 'Create Offer'
        ]);
    }   
}else {

    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']);

}

?>