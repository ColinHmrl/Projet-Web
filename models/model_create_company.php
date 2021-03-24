<?php

function post_form($name,$description,$activity_area,$locality,$email){
    include('loginBDD.php');
    
    if($_POST){ 
        // var_dump($_POST);
        try {
            //$dbh = new PDO('mysql:host=localhost;dbname=projetweb', 'root', 'root');
            $sql = "INSERT INTO company ( name, activity_area, locality, email, invisible, del, description) VALUES ( :name, :activity_area, :locality, :email, :invisible, :del, :description)"; 
            $prepared = $bdd->prepare($sql);
            $prepared->execute([
               ':name' => $name,
               ':activity_area' => $activity_area,
               ':locality' => $locality,
               ':email' => $email,
               ':invisible' => 0,
               ':del' => 0,
               ':description' => $description
            ]);
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
?>