<?php

namespace Requetes;

require_once "../assets/vendors/class/Right.php";

class User{

    static function insertUser($last_name, $first_name, $email, $password, $roles, $id_centers,$promotions,$rights){
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
    
                $req = $bdd->prepare('INSERT INTO users_promotions (id_promotions, id_users) VALUES (?, ?);');
                $promo_id = Promotion::getIdPromotion($promo);
                if(!$req->execute([$promo_id, $id_user]))
                    print_r($bdd->errorInfo());
            }
    
    
            foreach($rights as $right){
                $req = $bdd->prepare('INSERT INTO rights (id_right, id_users) VALUES (?, ?);');
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

    static function getUser($id){

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

    static function updateUser($id, $last_name, $first_name, $email, $password, $roles, $id_centers, $promotions, $rights){
        
        try{
            include('loginBDD.php');

            if($password != 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' ){

                $req = $bdd->prepare('UPDATE users SET last_name = ?, first_name = ?, email = ?, password = ?, roles = ?, id_centers = ? WHERE id = ?;');
                
                if(!$req->execute([$last_name, $first_name, $email, $password, $roles, $id_centers, $id]))
                    print_r($bdd->errorInfo());
            
            }else{

                $req = $bdd->prepare('UPDATE users SET last_name = ?, first_name = ?, email = ?, roles = ?, id_centers = ? WHERE id = ?;');
                
                if(!$req->execute([$last_name, $first_name, $email, $roles, $id_centers, $id]))
                    print_r($bdd->errorInfo());

            }

            $req = $bdd->prepare('DELETE FROM users_promotions WHERE id_users = ?;');
            
            if(!$req->execute([$id]))
                print_r($bdd->errorInfo());

            foreach($promotions as $promo){
                
                $req = $bdd->prepare('INSERT INTO users_promotions (id_promotions, id_users) VALUES (?, ?);');
                
                $promo_id = Promotion::getIdPromotion($promo);

                if(!$req->execute([$promo_id, $id]))
                    print_r($bdd->errorInfo());

            }

            $req = $bdd->prepare('DELETE FROM rights WHERE id_users = ?;');
            
            if(!$req->execute([$id]))
                print_r($bdd->errorInfo());


            foreach($rights as $right){
                var_dump($right);

                $req = $bdd->prepare('INSERT INTO rights (id_right, id_users) VALUES (?, ?);');
                
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
    
}

class Center{

    static function getCenters(){

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

    static function getIdCenter($center){
        $centers = Center::getCenters();
        foreach($centers as &$cent){
            if ($cent->name == $center){
                return $cent->id;
            }
        }
    }

    static function getNameCenter($id){
        $centers = Center::getCenters();
        foreach($centers as &$cent){
            if ($cent->id == $id){
                return $cent->name;
            }
        }
    }
    static function getCenter($id){
        try{
            include('loginBDD.php');
            $sql = "SELECT centers.name FROM users INNER JOIN centers on users.id_centers = centers.id WHERE users.id = :id";
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
}

class Promotion{

    static function getPromotions(){

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

    static function getAllPromoName($id_user){

        try{
            include('loginBDD.php');

            $req = $bdd->prepare('SELECT * FROM users_promotions WHERE id_users = ?');

            if(!$req->execute([$id_user]))
                print_r($bdd->errorInfo());
            
            $result = $req->fetchAll();
            
            return Promotion::getNamePromo($result);
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

    static function getNamePromo($id){
        $promotions = Promotion::getPromotions();
        $promo_name = [];
        foreach($id as &$idprom){
            foreach($promotions as &$prom){
                if ($prom->id == $idprom->id_promotions){
                    array_push($promo_name, $prom->name);
                }
            }
        }
        return $promo_name;
    }

    static function getIdPromotion($promo){
        $promotions = Promotion::getPromotions();
        foreach($promotions as &$prom){
            if ($prom->name == $promo){
                return $prom->id;
            }
        }
    }

    static function getPromo($id){
        try{
            include('loginBDD.php');
            $sql = "SELECT promotions.name FROM promotions INNER JOIN users_promotions on promotions.id = users_promotions.id_promotions INNER JOIN users on users.id = users_promotions.id_users WHERE users.id = :id";
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

}
class Rights{

    static function getAllRightsName($ids){
        $all_rights = \Right::getRights('delegate');
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

    static function getAllRightsUser($id_user){

        try{
            include('loginBDD.php');

            $req = $bdd->prepare('SELECT id_right FROM rights WHERE id_users = ?');

            if(!$req->execute([$id_user]))
                print_r($bdd->errorInfo());
            
            $result = $req->fetchAll();
            
            return Rights::getAllRightsName($result);
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

    static function haveRight($id_users, $right_name){

        $id_right = "";
        foreach (\Right::getRights("admin") as &$right) {
            if($right->name == $right_name){
                $id_right = $right->id;
            }
        }

        include('loginBDD.php');
        try{
        $req = $bdd->prepare('SELECT * FROM rights WHERE id_right = ? AND id_users = ?');
            
            if(!$req->execute([$id_right,$id_users]))
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

        if($req->fetch()) return true;
        else return false;
    }
}


class Stats{
    static function getNbrInWishlist($id){
        try{
            include('loginBDD.php');
            $sql = "SELECT COUNT(id_users) as count FROM users INNER JOIN wishlist on wishlist.id_users = users.id WHERE users.id = :id";
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
    static function getNbrStudentInCharge($id){
        try{
            include('loginBDD.php');
            $sql = "SELECT COUNT('users.id') as count FROM 
                    (SELECT 'users.id' as id FROM users INNER JOIN users_promotions on users_promotions.id_users = users.id WHERE users.roles = 'student') t1
                    LEFT JOIN
                    (SELECT 'id_promotions' as id FROM users INNER JOIN users_promotions on users.id = users_promotions.id_users WHERE users.id = :id) t2
                    ON (t1.id = t2.id)";

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
    static function getNbrStudentGotInternship($id){
        try{
            include('loginBDD.php');
            $sql = "SELECT count(id) as count FROM 
                    (SELECT users.id as id, users.id_centers as id_center,users_promotions.id_promotions as id_promo FROM users INNER JOIN users_promotions on users_promotions.id_users = users.id INNER JOIN wishlist on wishlist.id_users = users.id WHERE users.roles = 'student' AND wishlist.step = 6) t1
                    LEFT JOIN 
                    (SELECT id_promotions as id_des_promos FROM users INNER JOIN users_promotions on users.id = users_promotions.id_users WHERE users.id = :id ) t2
                    ON (t1.id_promo = t2.id_des_promos)
                    RIGHT JOIN 
                    (SELECT id_centers FROM users  WHERE users.id = :id) t3
                    ON (t1.id_center = t3.id_centers)";

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
}

?>