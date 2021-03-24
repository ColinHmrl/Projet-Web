<?php

namespace Requetes;

function insertInDB($last_name, $first_name, $email, $password, $roles, $del, $id_centers){
    try{
        include('loginBDD.php');

        $req = $bdd->prepare('INSERT INTO users (last_name, first_name, email, password, roles, del, id_centers) VALUES (?, ?, ?, ?, ?, ?, ?);');
        
        if(!$req->execute([$last_name, $first_name, $email, $password, $roles, $del, $id_centers]))
        print_r($bdd->errorInfo());
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