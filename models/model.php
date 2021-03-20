<?php

function testReq() {

try
    {
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    
    $reqemail = $bdd->prepare('SELECT * FROM users');// WHERE email = ? AND password = ?');

    if(!$reqemail->execute())
        print_r($bdd->errorInfo());
    else {
    
        $donnees = $reqemail->fetchAll();
        $reqemail->closeCursor();
        return $donnees;
    }
    
    
    }
    catch(Exception $e)
    {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    catch(PDOException $e)
    {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }

}