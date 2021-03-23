<?php

namespace Requetes;


    function testReq() {

        try
            {
            include('loginBDD.php');
            
            $reqemail = $bdd->prepare('SELECT * FROM users');// WHERE email = ? AND password = ?');
        
            if(!$reqemail->execute())
                print_r($bdd->errorInfo());
            else {
            
                $donnees = $reqemail->fetchAll();
                $reqemail->closeCursor();
                return $donnees;
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



