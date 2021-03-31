<?php

function get_activity(){
    include('loginBDD.php');
    $sql = "SELECT DISTINCT activity_area FROM company";
    $prepared = $bdd->prepare($sql);
    $prepared->execute();
    $result = $prepared->fetchAll();
    return($result);
}
function get_skills(){
    include('loginBDD.php');
    $sql = "SELECT DISTINCT name FROM skills";
    $prepared = $bdd->prepare($sql);
    $prepared->execute();
    $result = $prepared->fetchAll();
    return($result);
}
function get_locality(){
    include('loginBDD.php');
    $sql = "SELECT DISTINCT locality FROM company";
    $prepared = $bdd->prepare($sql);
    $prepared->execute();
    $result = $prepared->fetchAll();
    return($result);




}
function print_var_name($var) {
    foreach($GLOBALS as $var_name => $value) {
        if ($value === $var) {
            return $var_name;
        }
    }

    return false;
}

class modele_search_company {
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
    static function getSkillsOfIdCompany($id) {
        

        include('loginBDD.php');
        $stringSQL = 'SELECT skills.name FROM offer INNER JOIN need ON need.id_offer = offer.id INNER JOIN skills ON skills.id = need.id_skills INNER JOIN company on offer.id_company = company.id WHERE company.id = ?';
        $req = $bdd->prepare($stringSQL);
        
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
    static function getCompanyForSearch($tab){// selection via recherche dans search company 

        include('loginBDD.php');

        $stringSQL = "SELECT * FROM (SELECT  id as ID,name,activity_area,locality,email,invisible,del,description FROM company ) t1 
                    LEFT JOIN 
                    (SELECT company.id as id, AVG(rating) as rateStudent
                    FROM company INNER JOIN can_rate on company.id = can_rate.id_company INNER JOIN users on can_rate.id_users = users.id 
                    WHERE roles = 'student') t2
                    ON (t1.id = t2.id)
                    LEFT JOIN 
                    (SELECT company.id as id, AVG(rating) as ratePilot
                    FROM company INNER JOIN can_rate on company.id = can_rate.id_company INNER JOIN users on can_rate.id_users = users.id 
                    WHERE roles = 'pilot') t3
                    ON (t1.id = t3.id)
                    LEFT JOIN
                    (SELECT company.id, count(wishlist.id_users) as numberOfTrainee FROM offer INNER JOIN company on offer.id = company.id INNER JOIN wishlist on wishlist.id_offer = offer.id WHERE step = 6 GROUP BY company.id) t4
                    ON (t1.id = t4.id)
                    LEFT JOIN
                    (SELECT offer.id_company as id, skills.name as skillsName FROM offer INNER JOIN need on offer.id = need.id_offer INNER JOIN skills on skills.id = need.id_skills";
                    
        foreach($tab as $value => $key) {  
            switch($value) {

                case "skillsName":
                    $stringSQL .= " WHERE skills.name = '".$key."'";

                break ;
            }
        }
                    
                   
        $stringSQL .=" GROUP BY offer.id_company) t5 ON (t1.id = t5.id)";



        $stringSQL .= ' WHERE del = 0';
        foreach($tab as $value => $key) {
            
            switch($value) {
                default:
                    $stringSQL .= ' AND '; 
                    $stringSQL .= "  ".$value."  = '".$key."'";
                    
                    
                break;
                    
                case "rateStudent":
                    $stringSQL .= ' AND '; 
                    $stringSQL .= "  ".$value." > '".$key."'";

                break ;
                case "numberOfTrainee":
                    $stringSQL .= ' AND '; 
                    $stringSQL .= "  ".$value." > '".$key."'";

                break ;
                case "ratePilot":
                    $stringSQL .= ' AND '; 
                    $stringSQL .="  ". $value." > '".$key."'";

                break ;

            }
        }
        

        $prepared = $bdd->prepare($stringSQL);
        $prepared->execute();
        $result = $prepared->fetchAll();
        //echo $stringSQL .'<br>';
        //var_dump($result);
        
            
        return $result;
    }
}

//SELECT company.id as id,COUNT(wishlist.step)as number_of_trainee FROM offer INNER JOIN company on offer.id = company.id INNER JOIN wishlist on wishlist.id_offer = offer.id







?>

