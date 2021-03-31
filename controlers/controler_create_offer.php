<?php
session_start();

require '../models/model_user.php';
require_once '../assets/vendors/autoload.php';
require '../models/model_create_offer.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../vues');
$twig = new \Twig\Environment($loader, [
    'cache' => false, //__DIR__.'/cache'
]);

//affichage select company
$result = Offer::getCompany();
$outputCompany = '';
foreach ($result as $e){
    foreach ( $e as $p){
        $outputCompany .= "<option name=".$p.">".Offer::get_company_by_id($p)->name."</option>";
    }
}




// arriv� sur la page mofification
if(isset($_COOKIE['user'])) {


    $tab = ["cpilot" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer un compte pilote')),
        "cdelegate" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer un compte délégué')),
        "cstudent" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer un compte étudiant')),
        "ccompany" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer une entreprise')),
        "coffer" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Créer une offre')),
        "soffer" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher une offre')),
        "spilot" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher un compte pilote')),
        "sdelegate" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher un compte délégué')),
        "sstudent" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher un compte étudiant')),
        "scompany" => (Requetes\Rights::haveRight(unserialize($_COOKIE['user'])->id,'Rechercher une entreprise')),
        "cookie" => unserialize($_COOKIE['user'])->id
    ];



    if(!empty($_GET['id'])){
        //modif
    
        $result = Offer::getOffer($_GET['id']);
        

        

        echo $twig->render('create_offer.html',[
                'locality_offer'=> $result->locality_offer,
                'training_period'=> $result->training_period,
                'remuneration_basis'=> $result->remuneration_basis,
                'offer_date'=> $result->offer_date,
                'date_post'=> $result->date_post,  //2021-03-29 11:33:17
                'title'=> $result->title,
                'nb_places' => $result->nb_places,
                'description' => $result->description,
                'Company' => "<option value=".$result->id." name=".$result->id." selected>".$result->name."</option>",
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
            Offer::updateForm($_POST['id'],$_POST['locality_offer'],$_POST['training_period'],$_POST['remuneration_basis'],$_POST['offer_date'],$_POST['title'],$_POST['nb_places'],$_POST['description'],$_POST['company_id']);        //destination post cr�ation
            
            Offer::DeleteOfferPromotion($_POST['id']);
            $i = 1;
            for ($i = 1; $i <= 5; $i++){
                if(!empty($_POST['A'.$i])){
                    echo $_POST['id'];
                    Offer::PostOfferPromotion($i,$_POST['id']);
                }
            }
            //redirection
            //header('Location: ../controlers/controler_search_offer.php');
        }else{
            echo 'created';
            Offer::postForm($_POST['locality_offer'],$_POST['training_period'],$_POST['remuneration_basis'],$_POST['offer_date'],$_POST['title'],$_POST['nb_places'],$_POST['description'],$_POST['company_id']);

            $i = 1;
            for ($i = 1; $i <= 5; $i++){
                if(!empty($_POST['A'.$i])){
                    Offer::PostOfferPromotion($i,Offer::GetLastOfferID());
                }
            }
            //redirection
            //header('Location: ../controlers/controler_search_offer.php');
            




            
        }
    }else{



        //cr�ation
        echo $twig->render('create_offer.html',[
        'Company'=> $outputCompany,
        'titre'=> 'Create Offer',
        'arr' => $tab
        ]);
    }   
}else {

    echo $twig->render('error_page.html',['error' => 'Error 403 : veuillez vous login...']);

}

?>