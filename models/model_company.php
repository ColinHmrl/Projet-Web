<?php

class model_get_company {

static function getCompany(){


    include('loginBDD.php');
        
        $req = $bdd->prepare('SELECT * FROM company');// WHERE email = ? AND password = ?');
    
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



static function getCompanyName(){


    include('loginBDD.php');
        
        $req = $bdd->prepare('SELECT * FROM company');// WHERE email = ? AND password = ?');
    
        if(!$req->execute())
            print_r($bdd->errorInfo());
        else {
            //var_dump(hash('sha256',$password));
            $tab = [];

            while($donnees = $req->fetch()) {
                $tab[] = $donnees->name;
            }
            $req->closeCursor();
            return $tab;
            
        }


}

}