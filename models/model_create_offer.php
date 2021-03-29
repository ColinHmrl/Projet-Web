<?php

function post_form($entreprise,$location,$compétence,$offertitle,$placeavaible,$promoselect,$rémunération,$description){
    include('loginBDD.php');
    
    if($_POST){ 
        // var_dump($_POST);
        try {
            //$dbh = new PDO('mysql:host=localhost;dbname=projetweb', 'root', 'root');
            $sql = "INSERT INTO offer ( locality, promotion_concerned, training_period, remuneration_basis, offer_date, nb_places, del, id_company, description) VALUES (:locality, :promotion_concerned, :training_period, :remuneration_basis, :offer_date, :id_company, :description)"; 
            $prepared = $bdd->prepare($sql);
            $prepared->execute([
               ':promotion_concerned' => $promoselect,
               ':nb_places' => $placeavaible,
               ':invisible' => 0,
               ':del' => 0,
               ':description' => $description,
               ':remuneration_basis' => $rémunération,
            ]);
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
?>