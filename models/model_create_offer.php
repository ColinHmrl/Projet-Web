<?php
class Offer{
    static function update_form($id,$locality_offer,$training_period,$remuneration_basis,$offer_date,$title,$nb_places,$description){
        return'update';
        $sum_offer_date = $offer_date ;
        $sum_offer_date .= " " .date('h:i:s');       
        try{
            include('loginBDD.php');
            $sql = " UPDATE offer SET locality_offer = :locality_offer,training_period = :training_period,remuneration_basis = :remuneration_basis,offer_date = :offer_date, nb_places = :nb_places, title = :title,description = :description,del = :del,id_company = :id_company";
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
                ':id_company' => self::get_company_by_name($company_name)->id
                ]);
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }

    static function post_form($locality_offer,$training_period,$remuneration_basis,$offer_date,$title,$nb_places,$description,$company_name) {
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
                    ':id_company' => self::get_company_by_name($company_name)->id
                

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
        $sql = "SELECT DISTINCT name FROM company";
        $prepared = $bdd->prepare($sql);
        $prepared->execute();
        $result = $prepared->fetchAll();
        return($result);
    }
    static function get_company_by_name($name){
        try{
            include('loginBDD.php');
            $sql = "SELECT id,name FROM `company` WHERE name = :name";
            $prepared = $bdd->prepare($sql);

            if(!$prepared->execute([
                ':name' => $name
            ])){
                print_r($bdd->errorInfo());
            }

            $result = $prepared->fetch();
            var_dump($result);
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