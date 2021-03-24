<?php

function getOffer(){


include('loginBDD.php');
    
    $req = $bdd->prepare('SELECT * FROM offer');// WHERE email = ? AND password = ?');

    if(!$req->execute())
        print_r($bdd->errorInfo());
    else {
        //var_dump(hash('sha256',$password));
        if($donnees = $req->fetchAll()) {
            $req->closeCursor();
            return $donnees;
        }
        echo 'erreur';
        
        
        
    }


}