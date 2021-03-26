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

        echo $sql;
         
        


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
?>

