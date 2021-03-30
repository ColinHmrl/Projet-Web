<?php

function post_form($offertitle,$location,$offer_date,$training_period,$rémunération,$entreprise,$placeavaible,$promoselect,$description,){
    $date_post = date('y-m-d h:i:s');
    include('loginBDD.php');
    
    if($_POST){ 
        // var_dump($_POST);
        try {
            //$dbh = new PDO('mysql:host=localhost;dbname=projetweb', 'root', 'root');
            $sql = "INSERT INTO offer (locality_offer, training_period, remuneration_basis, offer_date, nb_places, date_post, title, description, del, id_company) VALUES ( :locality, :training_period, :remuneration_basis, :offer_date, :nb_places, :date_post, :title, :description, :del, :id_company, )"; 
            $prepared = $bdd->prepare($sql);
            $prepared->execute([
                ':locality'=> $location,
                ':training_period'=> $training_period,
                ':remuneration_basis'=> $rémunération,
                ':offer_date'=> $offer_date,
                ':title'=> $offertitle,
                ':date_post'=> $date_post,
                ':nb_places' => $placeavaible,
                ':invisible' => 0,
                ':del' => 0,
                ':description' => $description,
                

            ]);
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}


function get_company($id){
    try{
        include('loginBDD.php');
        $sql = "SELECT id, name, activity_area, locality, email, invisible, del, description FROM company";
        $prepared = $bdd->prepare($sql);

        if(!$prepared->execute([
            ':id' => $id
        ])){
            print_r($bdd->errorInfo());
        }

        $result = $prepared->fetch();
        return $result;

    }
    catch(\Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
    catch(\PDOException $e)
    {
            die('Erreur : '.$e->getMessage());
    }
}
?>