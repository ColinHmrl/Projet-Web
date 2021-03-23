<?php

namespace Requetes;

function loginUser($user,$password) {

    try
        {
        include('loginBDD.php');
        
        $req = $bdd->prepare('SELECT * FROM users WHERE email = ? AND password = ?');// WHERE email = ? AND password = ?');
    
        if(!$req->execute([$user,hash('sha256',$password)]))
            print_r($bdd->errorInfo());
        else {
            //var_dump(hash('sha256',$password));
            if($donnees = $req->fetch()) {
                $_SESSION['user'] = $donnees;
            }
            $req->closeCursor();
            
            
        }
        
        
        }
        catch(\Exception $e)
        {
            // En cas d'erreur, on affiche un message et on arrête tout
                die('Erreur : '.$e->getMessage());
        }
        catch(\PDOException $e)
        {
            // En cas d'erreur, on affiche un message et on arrête tout
                die('Erreur : '.$e->getMessage());
        }
    
    }

