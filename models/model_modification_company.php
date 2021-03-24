<?php
function get_company($id){
    include('loginBDD.php');
    $sql = "SELECT name, activity_area, locality, email, invisible, del, description FROM company WHERE id = :id";
    $prepared = $bdd->prepare($sql);

    $prepared->execute([
        ':id' => $id
    ]);

    $result = $prepared->fetch(PDO::FETCH_OBJ);

    return($result);
}

function update_company($id,$name,$description,$activity_area,$locality,$email){
    include('loginBDD.php');
    
    if($_POST){ 
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
}
?>