<?php

namespace Requetes;

function insert_user($last_name, $first_name, $email, $password, $roles, $id_centers){
    try{
        include('loginBDD.php');

        $req = $bdd->prepare('INSERT INTO users (last_name, first_name, email, password, roles, del, id_centers) VALUES (?, ?, ?, ?, ?, false, ?);');
        
        if(!$req->execute([$last_name, $first_name, $email, $password, $roles, $id_centers]))
        print_r($bdd->errorInfo());
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

function get_user($id){

    try{
        include('loginBDD.php');

        $req = $bdd->prepare('SELECT * FROM users WHERE id = ?;');
        
        if(!$req->execute([$id]))
            print_r($bdd->errorInfo());
        
        $result = $req->fetch();
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

function update_user($id,$last_name, $first_name, $email, $password, $roles, $del, $id_centers){
    
    try{
        include('loginBDD.php');

        $req = $bdd->prepare('UPDATE users SET last_name = ?, first_name = ?, email = ?, password = ?, roles = ?, del = ?, id_centers = ? WHERE id = ?;');
        
        if(!$req->execute([$last_name, $first_name, $email, $password, $roles, $del, $id_centers,$id]))
            print_r($bdd->errorInfo());
        
        $result = $req->fetch();
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

?>