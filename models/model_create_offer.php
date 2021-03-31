<?php
class Offer{
    static function update_form($id,$locality_offer,$training_period,$remuneration_basis,$offer_date,$title,$nb_places,$description,$company_id){
        $sum_offer_date = $offer_date ;
        $sum_offer_date .= " " .date('h:i:s');       
        try{
            include('loginBDD.php');
            $sql = " UPDATE offer SET locality_offer = :locality_offer,training_period = :training_period,remuneration_basis = :remuneration_basis,offer_date = :offer_date, nb_places = :nb_places, title = :title,description = :description,del = :del,id_company = :id_company WHERE offer.id = :id";
            $prepared = $bdd->prepare($sql);
            $prepared->execute([
                ':locality_offer'=> $locality_offer,
                ':training_period'=> $training_period,
                ':remuneration_basis'=> $remuneration_basis,
                ':offer_date'=> $sum_offer_date ,
                ':title'=> $title,
                ':nb_places' => $nb_places,
                ':del' => 0,
                ':description' => $description,
                ':id_company' => $company_id,
                ':id' => $id
                ]);
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }

    static function post_form($locality_offer,$training_period,$remuneration_basis,$offer_date,$title,$nb_places,$description,$company_id) {
        $date_post = date('y-m-d h:i:s');
        $sum_offer_date = $offer_date ;
        $sum_offer_date .= " " .date('h:i:s');
 
            
        if($_POST){ 
            // var_dump($_POST);
            try {
                include('loginBDD.php');
                //$dbh = new PDO('mysql:host=localhost;dbname=projetweb', 'root', 'root');
                $sql = "INSERT INTO offer (locality_offer, training_period, remuneration_basis, offer_date, nb_places, date_post, title, description, del, id_company) VALUES ( :locality_offer, :training_period, :remuneration_basis, :offer_date, :nb_places, :date_post, :title, :description, :del, :id_company )"; 
                $prepared = $bdd->prepare($sql);
                $prepared->execute([
                    ':locality_offer'=> $locality_offer,
                    ':training_period'=> $training_period,
                    ':remuneration_basis'=> $remuneration_basis,
                    ':offer_date'=> $sum_offer_date ,
                    ':title'=> $title,
                    ':date_post'=> $date_post,
                    ':nb_places' => $nb_places,
                    ':del' => 0,
                    ':description' => $description,
                    ':id_company' => $company_id
                

                ]);
            }
            catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }


    static function get_offer($id){
        try{
            include('loginBDD.php');
            $sql = "SELECT offer.id,locality_offer,training_period,remuneration_basis,nb_places,date_post,title,offer.description,offer.del,id_company,name,SUBSTRING(offer_date,1,10) as offer_date FROM `offer` INNER JOIN company on offer.id_company = company.id WHERE offer.id = :id";
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

    static function get_company(){
        include('loginBDD.php');
        $sql = "SELECT DISTINCT id FROM company";
        $prepared = $bdd->prepare($sql);
        $prepared->execute();
        $result = $prepared->fetchAll();
        return($result);
    }
    static function get_company_by_name($name){
        try{
            include('loginBDD.php');
            $sql = "SELECT id,name FROM `company` WHERE name = ?";
            $prepared = $bdd->prepare($sql);
            if(!$prepared->execute([$name]))
                print_r($bdd->errorInfo());
            

            $result = $prepared->fetch();
            //var_dump($result);
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
        static function get_company_by_id($id){
        try{
            include('loginBDD.php');
            $sql = "SELECT name FROM `company` WHERE id = ?";
            $prepared = $bdd->prepare($sql);
            if(!$prepared->execute([$id]))
                print_r($bdd->errorInfo());
            

            $result = $prepared->fetch();
            //var_dump($result);
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






    static function GetLastOfferID(){
            try{
            include('loginBDD.php');
            $sql = "SELECT MAX(id) as max FROM offer";
            $prepared = $bdd->prepare($sql);

            if(!$prepared->execute()){
                print_r($bdd->errorInfo());
            }

            $result = $prepared->fetch();
            return $result->max;

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
    static function PostOfferPromotion($id_promo,$id_offer){

        if($_POST){ 
        
            try {
                include('loginBDD.php');
                $sql = "INSERT INTO offer_promotions (id_offer, id_promotions) VALUES (:id_offer,:id_promotions)"; 
                $prepared = $bdd->prepare($sql);
                $prepared->execute([
                    ':id_offer' => $id_offer,
                    ':id_promotions' => $id_promo
                ]);
                
            }
            catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }
    static function DeleteOfferPromotion($id_offer){
        if($_POST){ 
        
            try {
                include('loginBDD.php');
                $sql = "DELETE FROM offer_promotions WHERE id_offer = :id_offer "; 
                $prepared = $bdd->prepare($sql);
                
                $prepared->execute([
                    ':id_offer' => $id_offer
                ]);
            }
            catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }




    }
    static function CheckOfferPromotionRelation($id_promo,$id_offer){

         

             try{
                include('loginBDD.php');
                $sql = "SELECT COUNT(id_offer) as exist FROM offer_promotions WHERE id_offer = :id_offer AND id_promotions = :id_promotions";
                $prepared = $bdd->prepare($sql);

                if(!$prepared->execute([
                    ':id_offer' => $id_offer,
                    ':id_promotions' => $id_promo
                ])){
                    print_r($bdd->errorInfo());
                }

                $result = $prepared->fetch();

                
                if($result->exist){
                    return 'checked';
                }else{
                    return 'do not exist';
                }
                    
                
                

             }catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        
    }

}

?>