<?php

class ModelSearchOffer {

static function getOffer($tab){

//

include('loginBDD.php');

$stringSQL = 'SELECT offer.id,company.name,locality_offer,title,nb_places,offer.description,offer_date,training_period,DATEDIFF(CURRENT_TIMESTAMP, date_post) AS day_ago,remuneration_basis FROM offer INNER JOIN company ON company.id = offer.id_company';
$tableValue = [];

$count = count($tab);

if(isset($tab['promotion']))
    $count--;
if(isset($tab['skillsName']))
    $count--;

if($count>0) {
    $stringSQL .= ' WHERE ';
    foreach(array_keys($tab) as $key => $value) {

        switch($value) {
            default:
                $stringSQL .= $value." = :".$key;
                $tableValue[':'.$key] = $tab[$value];
                if($key < count($tab)-1)
                $stringSQL .= ' AND ';
            break;
            case "nb_places" :
            case "training_period" :
            case "remuneration_basis" :
                $stringSQL .= $value." >= :".$key;
                $tableValue[':'.$key] = $tab[$value];
                if($key < count($tab)-1)
                $stringSQL .= ' AND ';
            break;
            case "promotion" :
            case "skillsName" :
            break;
            case "offer_date" :
                if($tab['offer_date']==-1)
                $stringSQL .= $value." <= CURRENT_TIMESTAMP";
                if($tab['offer_date']>=1 && $tab['offer_date']<4)
                $stringSQL .= $value." < DATE_ADD(CURRENT_TIMESTAMP, INTERVAL ".$tab['offer_date']." MONTH) AND ".$value." >= DATE_ADD(CURRENT_TIMESTAMP, INTERVAL ".($tab['offer_date']-1)." MONTH)";
                if($tab['offer_date']==4)
                $stringSQL .= $value." >= DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 3 MONTH)";
                if($key < count($tab)-1)
                $stringSQL .= ' AND ';
            break;
        }
        

    }
}
    //var_dump($stringSQL);
    $req = $bdd->prepare($stringSQL);// WHERE email = ? AND password = ?');

    if(!$req->execute($tableValue))
        print_r($bdd->errorInfo());
    else {
        //var_dump(hash('sha256',$password));
        $donnees = [];
        while($donnee = $req->fetch()) {

            if(isset($tab['promotion'])) {
                if(array_search($tab['promotion'],self::getPromo($donnee->id)) !== false) {
                    if(isset($tab['skillsName'])) {
                        if(array_search($tab['skillsName'],self::getSkills($donnee->id)) !== false) { 
                            $donnees[] = $donnee;
                        }
                    }
                    else {
                        $donnees[] = $donnee;
                    }   
                }
            }
            else {
                if(isset($tab['skillsName'])) {
                    if(array_search($tab['skillsName'],self::getSkills($donnee->id)) !== false) { 
                        $donnees[] = $donnee;
                    }
                }
                else {
                    $donnees[] = $donnee;
                }
            }
            
        }
        $req->closeCursor();
        return $donnees;
        echo 'No Result';
        
    }

}

static function getSkills($id) {

    include('loginBDD.php');
    $req = $bdd->prepare('SELECT skills.name FROM offer INNER JOIN need ON need.id_offer = offer.id INNER JOIN skills ON skills.id = need.id_skills WHERE offer.id = ?');

    if(!$req->execute([$id]))
        print_r($bdd->errorInfo());
    else {
        $donnees = [];
        //var_dump(hash('sha256',$password));
        while($donnee = $req->fetch()) {
            
            $donnees[] = $donnee->name;
        }
        $req->closeCursor();
        return $donnees;
        echo 'No Result';
        
    }
    

}

static function getPromo($id) {

    include('loginBDD.php');
    $req = $bdd->prepare('SELECT promotions.name FROM `offer` INNER JOIN offer_promotions ON offer.id = offer_promotions.id_offer INNER JOIN promotions ON promotions.id = offer_promotions.id_promotions WHERE offer.id = ?');

    if(!$req->execute([$id]))
        print_r($bdd->errorInfo());
    else {
        $donnees = [];
        //var_dump(hash('sha256',$password));
        while($donnee = $req->fetch()) {
            
            $donnees[] = $donnee->name;
        }
        $req->closeCursor();
        return $donnees;
        echo 'No Result';
        
    }
    

}


static function getLocation() {

    include('loginBDD.php');
    $req = $bdd->prepare('SELECT DISTINCT locality_offer FROM `offer`');

    if(!$req->execute())
        print_r($bdd->errorInfo());
    else {
        $donnees = [];
        //var_dump(hash('sha256',$password));
        while($donnee = $req->fetch()) {
            
            $donnees[] = $donnee->locality_offer;
        }
        $req->closeCursor();
        return $donnees;
        echo 'No Result';
        
    }



}

static function getSkillName(){
    include('loginBDD.php');
    $sql = "SELECT DISTINCT name FROM skills";
    $prepared = $bdd->prepare($sql);
    $prepared->execute();
    $result = $prepared->fetchAll();
    return($result);
}


}