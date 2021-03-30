<?php

namespace Requetes;

function loginUser($user,$password) {

    try
        {
        include('loginBDD.php');
        
        $req = $bdd->prepare('SELECT id,first_name,last_name,email FROM users WHERE email = ? AND password = ?');// WHERE email = ? AND password = ?');
    
        if(!$req->execute([$user,hash('sha256',$password)]))
            print_r($bdd->errorInfo());
        else {
            //var_dump(hash('sha256',$password));
            if($donnees = $req->fetch()) {
                setcookie('user', serialize($donnees), time() + 365*24*3600, null, null, false, true);
            }
            $req->closeCursor();
            header('Location: index.php'); 
            
            
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

