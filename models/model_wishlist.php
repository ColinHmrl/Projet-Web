<?php

class model_wishlist {

    static function getOffer($tab){

        //

        include('loginBDD.php');

        $stringSQL = 'SELECT offer.id,company.name,locality_offer,title,nb_places,offer.description,offer_date,training_period,DATEDIFF(CURRENT_TIMESTAMP, date_post) AS day_ago,remuneration_basis FROM offer INNER JOIN company ON company.id = offer.id_company INNER JOIN wishlist ON wishlist.id_offer = offer.id';
        $tableValue = [];

        $count = count($tab);

        if(isset($tab['promotion']))
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

        $req = $bdd->prepare($stringSQL);// WHERE email = ? AND password = ?');

        if(!$req->execute($tableValue))
            print_r($bdd->errorInfo());
        else {
            //var_dump(hash('sha256',$password));
            $donnees = [];
            while($donnee = $req->fetch()) {

                if(isset($tab['promotion'])) {
                    if(array_search($tab['promotion'],model_search_offer::getPromo($donnee->id)) !== false)
                    $donnees[] = $donnee;
                }
                else
                $donnees[] = $donnee;
            }
            $req->closeCursor();
            return $donnees;
            echo 'No Result';
        
    }

}


static function isWishlist($id_user,$id_offer) {

    include('loginBDD.php');
    $req = $bdd->prepare('SELECT * FROM wishlist WHERE id_users = ? AND id_offer = ?');

    if(!$req->execute([$id_user,$id_offer]))
        print_r($bdd->errorInfo());
    else {
        $test = $req->fetch();
        $req->closeCursor();
        return $test ? true : false;
            
          
        
    }


}


static function remove($id_user,$id_offer) {

    if(self::isWishlist($id_user,$id_offer)) {

        include('loginBDD.php');
        $req = $bdd->prepare('DELETE FROM wishlist WHERE id_users = ? AND id_offer = ?');

        if(!$req->execute([$id_user,$id_offer]))
        print_r($bdd->errorInfo());
        else {
        $req->closeCursor();
    }


    }
    

}


static function add($id_user,$id_offer) {

    if(!self::isWishlist($id_user,$id_offer)) {
    include('loginBDD.php');
    $req = $bdd->prepare("INSERT INTO `wishlist` (`id_users`, `id_offer`, `step`, `del`) VALUES (?, ?, '0', '0');");

    if(!$req->execute([$id_user,$id_offer]))
        print_r($bdd->errorInfo());
    else {
        $req->closeCursor();
    }
    }
}

static function getStep($id_user,$id_offer) {


    if(self::isWishlist($id_user,$id_offer)) {

        include('loginBDD.php');
        $req = $bdd->prepare('SELECT step FROM wishlist WHERE id_users = ? AND id_offer = ?');

        if(!$req->execute([$id_user,$id_offer]))
        print_r($bdd->errorInfo());
        else {
        
        if($jaj = $req->fetch()) {
            $req->closeCursor();
            return $jaj;
        }
      
    }




}

}
}