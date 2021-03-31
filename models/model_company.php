<?php

class Company {

    static function getCompanyById($id){ // get one company by id 
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

    static function insertRate($id_users, $id_company, $note){

        include('loginBDD.php');

        $req = $bdd->prepare('DELETE FROM can_rate WHERE id_company = ? AND id_users = ?');
            
        if(!$req->execute([$id_company, $id_users]))
            print_r($bdd->errorInfo());

        $req = $bdd->prepare('INSERT INTO can_rate (id_company, id_users, rating ) VALUES (?, ?, ?)');

        if(!$req->execute([$id_company, $id_users, $note]))
            print_r($bdd->errorInfo());

        if(!$req->execute([$promo_id, $id]))
            print_r($bdd->errorInfo());
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
        if ($a+$b+$c+$d != 0 ){
            return ($a*5+$b*4+$c*2+$d*1)/($a+$b+$c+$d);
        }else {
            return 0;
        }

            

    }
    
}
