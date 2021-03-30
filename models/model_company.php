<?php

class Company {



    static function get_company_by_id($id){ // get one company by id 
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

    static function getSkills($id) {//get skills from an offer ID

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
class Stats{
    static function get_count_rating($id_company,$rate,$role){
    
        try{
            include('loginBDD.php');
            $sql = "SELECT count(rating) as count
                    FROM company INNER JOIN can_rate on company.id = can_rate.id_company INNER JOIN users on can_rate.id_users = users.id 
                    WHERE rating = :rate AND company.id = :id_company AND users.roles = :role";

            $prepared = $bdd->prepare($sql);

            if(!$prepared->execute([
                ':id_company' => $id_company,
                ':rate' => $rate,
                ':role' => $role
            ])){
                print_r($bdd->errorInfo());
            }
            
            $result = $prepared->fetch();
            return $result->count;

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
    static function rate($role,$id_company){

        $a= self::get_count_rating($id_company,'A',$role);
        $b= self::get_count_rating($id_company,'B',$role);
        $c= self::get_count_rating($id_company,'C',$role);
        $d= self::get_count_rating($id_company,'D',$role);

       return ($a*5+$b*4+$c*2+$d*1)/($a+$b+$c+$d);
    }
    
}
