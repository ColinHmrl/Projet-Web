<?php

namespace Requetes;

require_once "../assets/vendors/class/Right.php";

function insert_user($last_name, $first_name, $email, $password, $roles, $id_centers,$promotions,$rights){
    try{
        include('loginBDD.php');

        //insert datas in the table users

        $req = $bdd->prepare('INSERT INTO users (last_name, first_name, email, password, roles, del, id_centers) VALUES (?, ?, ?, ?, ?, false, ?);');
        
        if(!$req->execute([$last_name, $first_name, $email, $password, $roles, $id_centers]))
            print_r($bdd->errorInfo());

        //get id of the user you just add

        $id_user = $bdd->lastInsertId();

        //insert datas in user_promotions

        foreach($promotions as $promo){

            $req = $bdd->prepare('INSERT INTO users_promotions (id_promotion, id_users, del) VALUES (?, ?, false);');

            $promo_id = get_id_promotion($promo);

            if(!$req->execute([$promo_id, $id_user]))
                print_r($bdd->errorInfo());

        }


        foreach($rights as $right){
            $req = $bdd->prepare('INSERT INTO rights (id_right, del, id_users) VALUES (?, false, ?);');
            if(!$req->execute([$right->id, $id_user]))
                print_r($bdd->errorInfo());
        }

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

function update_user($id, $last_name, $first_name, $email, $password, $roles, $id_centers, $promotions, $rights){
    
    try{
        include('loginBDD.php');

        $req = $bdd->prepare('UPDATE users SET last_name = ?, first_name = ?, email = ?, password = ?, roles = ?, id_centers = ? WHERE id = ?;');
        
        if(!$req->execute([$last_name, $first_name, $email, $password, $roles, $id_centers, $id]))
            print_r($bdd->errorInfo());


        $req = $bdd->prepare('DELETE FROM users_promotions WHERE id_users = ?;');
        
        if(!$req->execute([$id]))
            print_r($bdd->errorInfo());

        foreach($promotions as $promo){
            
            $req = $bdd->prepare('INSERT INTO users_promotions (id_promotion, id_users, del) VALUES (?, ?, false);');
            
            $promo_id = get_id_promotion($promo);

            if(!$req->execute([$promo_id, $id]))
                print_r($bdd->errorInfo());

        }

        $req = $bdd->prepare('DELETE FROM rights WHERE id_users = ?;');
        
        if(!$req->execute([$id]))
            print_r($bdd->errorInfo());


        foreach($rights as $right){
            var_dump($right);

            $req = $bdd->prepare('INSERT INTO rights (id_right, del, id_users) VALUES (?, false, ?);');
            
            if(!$req->execute([$right->id, $id]))
                print_r($bdd->errorInfo());
                
        }
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

function get_centers(){

    try{
        include('loginBDD.php');

        $req = $bdd->query('SELECT * FROM centers');
        
        $result = $req->fetchAll();
        
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

function get_id_center($center){
    $centers = get_centers();
    foreach($centers as &$cent){
        if ($cent->name == $center){
            return $cent->id;
        }
    }
}

function get_name_center($id){
    $centers = get_centers();
    foreach($centers as &$cent){
        if ($cent->id == $id){
            return $cent->name;
        }
    }
}

function get_promotions(){

    try{
        include('loginBDD.php');

        $req = $bdd->query('SELECT * FROM promotions');
        
        $result = $req->fetchAll();
        
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

function get_all_promo_name($id_user){

    try{
        include('loginBDD.php');

        $req = $bdd->prepare('SELECT * FROM users_promotions WHERE id_users = ?');

        if(!$req->execute([$id_user]))
            print_r($bdd->errorInfo());
        
        $result = $req->fetchAll();
        
        return get_name_promo($result);
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

function get_name_promo($id){
    $promotions = get_promotions();
    $promo_name = [];
    foreach($id as &$idprom){
        foreach($promotions as &$prom){
            if ($prom->id == $idprom->id_promotion){
                array_push($promo_name, $prom->name);
            }
        }
    }
    return $promo_name;
}

function get_id_promotion($promo){
    $promotions = get_promotions();
    foreach($promotions as &$prom){
        if ($prom->name == $promo){
            return $prom->id;
        }
    }
}

function get_all_rights_name($ids){
    $all_rights = \Right::get_rights('delegate');
    $rights_name =[];
    foreach($ids as &$id){
        foreach($all_rights as &$right){
            if ($right->id == $id->id_right){
                array_push($rights_name, $right->name);
            }
        }
    }
    return $rights_name;
}

function get_all_rights_user($id_user){

    try{
        include('loginBDD.php');

        $req = $bdd->prepare('SELECT id_right FROM rights WHERE id_users = ?');

        if(!$req->execute([$id_user]))
            print_r($bdd->errorInfo());
        
        $result = $req->fetchAll();
        
        return get_all_rights_name($result);
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