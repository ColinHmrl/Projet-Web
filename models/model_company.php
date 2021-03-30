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

    static function get_company_by_id($id){
        try{
            include('loginBDD.php');
            $sql = "SELECT * FROM company WHERE id = :id";
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

    static function getSkills($id) {

        include('loginBDD.php');
        $req = $bdd->prepare('SELECT skills.name FROM offer INNER JOIN need ON need.id_offer = offer.id INNER JOIN skills ON skills.id = need.id_skills WHERE offer.id = ?');

        if(!$req->execute([$id]))
            print_r($bdd->errorInfo());
        else {
            //var_dump(hash('sha256',$password));
            if($donnees = $req->fetchAll()) {
                $req->closeCursor();
                return $donnees;
            }
            echo 'No Result';
        
        }
    

    }

}
