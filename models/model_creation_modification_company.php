<?php
function get_company($id){
    try{
        include('loginBDD.php');
        $sql = "SELECT id, name, activity_area, locality, email, invisible, del, description FROM company WHERE id = :id";
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

function update_company($id,$name,$description,$activity_area,$locality,$email){
    include('loginBDD.php');
    
    try {

        $sql = "
        UPDATE company 
        SET name = :name, activity_area = :activity_area , locality= :locality , email = :email , invisible = :invisible , del = :del , description = :description 
        WHERE id = :id ";

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