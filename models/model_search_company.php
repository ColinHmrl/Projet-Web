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
    static function getCompany($tab){// selection via recherche dans search company 

        include('loginBDD.php');

        $stringSQL = 'SELECT * FROM (SELECT  id as ID,name,activity_area,locality,email,invisible,del,description FROM company';


        $count = count($tab);
        

        if($count>0) {
            $stringSQL .= ' WHERE step = 6 ';
            foreach($tab as $value => $key) {
                $stringSQL .= ' AND '; 
                switch($value) {
                    default:
                        $stringSQL .= " ' ".$value." ' = '".$key."'";
                    
                    
                    break;
                    
                    case "trainee_score":
                        $stringSQL .= " ' ".$value."' <= '".$key."'";

                    break ;
                    case "number_of_trainee":
                        $stringSQL .= " ' ".$value."' <= '".$key."'";

                    break ;
                    case "pilotScore":
                        $stringSQL .=" ' ". $value."' <= '".$key."'";

                    break ;


                }
            }
        }
        $stringSQL .= ") t1 
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
(SELECT company.id as id,COUNT(step)as number_of_trainee 
FROM offer INNER JOIN company on offer.id = company.id INNER JOIN wishlist on wishlist.id_offer = offer.id) t4
ON (t1.id = t4.id)

";
        $prepared = $bdd->prepare($stringSQL);
        $prepared->execute();
        $result = $prepared->fetchAll();
        
        return $result;
    }
}









?>

