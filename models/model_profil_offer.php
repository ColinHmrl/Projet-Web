<?php
class Profil{
	static function getProfilById($id){ // get one offer by id 
        try{
            include('loginBDD.php');
            $sql = "SELECT offer.id,title,name,offer.description,locality_offer,offer_date,training_period,remuneration_basis,nb_places FROM offer INNER JOIN company on offer.id_company = company.id WHERE offer.id = :id";
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
    static function getHowManyInWishlist($id){ // get one offer by id 
        try{
            include('loginBDD.php');
            $sql = "SELECT COUNT(id_users) as nbr FROM wishlist WHERE wishlist.id_offer = :id AND step < 6";
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
    static function getHowManyTrainee($id){ // get one offer by id 
        try{
            include('loginBDD.php');
            $sql = "SELECT COUNT(id_users) as nbr FROM wishlist WHERE wishlist.id_offer = :id AND step = 6";
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