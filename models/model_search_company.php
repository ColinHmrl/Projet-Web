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
    static function getCompany($tab){

        include('loginBDD.php');

        $stringSQL = 'SELECT * FROM (SELECT * FROM company';


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
(SELECT company.id,COUNT(step)as number_of_trainee 
FROM offer INNER JOIN company on offer.id = company.id INNER JOIN wishlist on wishlist.id_offer = offer.id) t4
ON (t1.id = t4.id)

";

        
        echo $stringSQL;
        //echo '<br>';
        $prepared = $bdd->prepare($stringSQL);
        $prepared->execute();
        $result = $prepared->fetchAll();
        //var_dump($result);
        return $result;
    }
}







/*
function search_company(){
    $numargs = func_num_args();
    $arg_list = func_get_args();

    $name;
    $activity_area;
    $locality;
    $skills;
    $numberOfTrainee;
    $traineeScore;
    $PilotScore;


    include('loginBDD.php');

    try {
        
        $sql = "
        SELECT id,name,description,activity_area,locality,email,skills,COUNT(step)as trainee 
        FROM offer INNER JOIN company on offer.id = company.id INNER JOIN wishlist on wishlist.id = offer.id
        WHERE step = 6";
        for ($i = 0; $i < $args; $i++) {
            
        }
        if ($name!= NULL){
            $sql .= "AND name = :".$name;
        }
        if ($activity_area != NULL){
            $sql .= "AND activity_area = :".$activity_area;
        }
        if ($skills != NULL){
            $sql .= "AND skills = :".$skills;
        }
        if ($numberOfTrainee != NULL){
            $sql .= "AND trainee >= :".$numberOfTrainee;
        }
        
        if ($traineeScore != NULL){
            $sql .= "AND traineeScore >= :".$traineeScore;
        }

        if ($PilotScore != NULL){
            $sql .= "AND PilotScore >= :".$PilotScore;
        }

        
         
        


        $prepared = $bdd->prepare($sql);
        $prepared->execute([

            ':name' => $name,
            ':activity_area' => $activity_area,
            ':locality' => $locality,
            ':email' => $email,
            ':invisible' => 0,
            ':del' => 0,
            ':description' => $description,
            ':id'=> $id
        ]);
    }
    catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
*/























?>

