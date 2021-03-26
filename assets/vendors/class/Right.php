<?php

    class Right{

        public $id;
        public $name;

        public static
            $SFx1,$SFx2,$SFx3,$SFx4,$SFx5,$SFx6,$SFx7,$SFx8,$SFx9,$SFx10,
            $SFx11,$SFx12,$SFx13,$SFx14,$SFx15,$SFx16,$SFx17,$SFx18,$SFx19,$SFx20,
            $SFx21,$SFx22,$SFx23,$SFx24,$SFx25,$SFx26,$SFx27,$SFx28,$SFx29,$SFx30,
            $SFx31,$SFx32,$SFx33,$SFx34,$SFx35;

        public function  __construct($id,$name) {
            $this->id = $id;
            $this->name = $name;

        }
        
        public static function init() {

            self::$SFx1 = new Right(1,'Authentifier');
            self::$SFx2 = new Right(2,'Rechercher une entreprise');
            self::$SFx3 = new Right(3,'Créer une entreprise');
            self::$SFx4 = new Right(4,'Modifier une entreprise');
            self::$SFx5 = new Right(5,'Evaluer une entreprise');
            self::$SFx6 = new Right(6,'Supprimer une entreprise');
            self::$SFx7 = new Right(7,'Consulter les stats des entreprises');
            self::$SFx8 = new Right(8,'Rechercher une offre');
            self::$SFx9 = new Right(9,'Créer une offre');
            self::$SFx10 = new Right(10,'Modifier une offre');
            self::$SFx11 = new Right(11,'Supprimer une offre');
            self::$SFx12 = new Right(12,'Consulter les stats des offres');
            self::$SFx13 = new Right(13,'Rechercher un compte pilote');
            self::$SFx14 = new Right(14,'Créer un compte pilote');
            self::$SFx15 = new Right(15,'Modifier un compte pilote');
            self::$SFx16 = new Right(16,'Supprimer un compte pilote');
            self::$SFx17 = new Right(17,'Rechercher un compte délégué');
            self::$SFx18 = new Right(18,'Créer un compte délégué');
            self::$SFx19 = new Right(19,'Modifier un compte délégué');
            self::$SFx20 = new Right(20,'Supprimer un compte délégué');
            self::$SFx21 = new Right(21,'Assigner des droits à un délégué');
            self::$SFx22 = new Right(22,'Rechercher un compte étudiant');
            self::$SFx23 = new Right(23,'Créer un compte étudiant');
            self::$SFx24 = new Right(24,'Modifier un compte étudiant');
            self::$SFx25 = new Right(25,'Supprimer un compte étudiant');
            self::$SFx26 = new Right(26,'Consulter les stats des étudiants');
            self::$SFx27 = new Right(27,'Ajouter une offre à la wish-list');
            self::$SFx28 = new Right(28,'Retirer une offre à la wish-list');
            self::$SFx29 = new Right(29,'Postuler à une offre');
            self::$SFx30 = new Right(30,"Informer le système de l'avancement de la candidature step 1");
            self::$SFx31 = new Right(31,"Informer le système de l'avancement de la candidature step 2");
            self::$SFx32 = new Right(32,"Informer le système de l'avancement de la candidature step 3");
            self::$SFx33 = new Right(33,"Informer le système de l'avancement de la candidature step 4");
            self::$SFx34 = new Right(34,"Informer le système de l'avancement de la candidature step 5");
            self::$SFx35 = new Right(35,"Informer le système de l'avancement de la candidature step 6");
            }

        public static function get_rights($roles){
            if (self::$SFx1 == null)
                self::init();
            switch ($roles){
                case "admin":
                    return [
                        Right::$SFx1,
                        Right::$SFx2,
                        Right::$SFx3,
                        Right::$SFx4,
                        Right::$SFx5,
                        Right::$SFx6,
                        Right::$SFx7,
                        Right::$SFx8,
                        Right::$SFx9,
                        Right::$SFx10,
                        Right::$SFx11,
                        Right::$SFx12,
                        Right::$SFx13,
                        Right::$SFx14,
                        Right::$SFx15,
                        Right::$SFx16,
                        Right::$SFx17,
                        Right::$SFx18,
                        Right::$SFx19,
                        Right::$SFx20,
                        Right::$SFx21,
                        Right::$SFx22,
                        Right::$SFx23,
                        Right::$SFx24,
                        Right::$SFx25,
                        Right::$SFx26,
                        Right::$SFx27,
                        Right::$SFx28,
                        Right::$SFx29,
                        Right::$SFx30,
                        Right::$SFx31,
                        Right::$SFx32,
                        Right::$SFx33,
                        Right::$SFx34,
                        Right::$SFx35
                    ];
                    break;
                case "pilot":
                    return [
                        Right::$SFx1,
                        Right::$SFx2,
                        Right::$SFx3,
                        Right::$SFx4,
                        Right::$SFx5,
                        Right::$SFx6,
                        Right::$SFx7,
                        Right::$SFx8,
                        Right::$SFx9,
                        Right::$SFx10,
                        Right::$SFx11,
                        Right::$SFx12,
                        Right::$SFx17,
                        Right::$SFx18,
                        Right::$SFx19,
                        Right::$SFx20,
                        Right::$SFx21,
                        Right::$SFx22,
                        Right::$SFx23,
                        Right::$SFx24,
                        Right::$SFx25,
                        Right::$SFx26,
                        Right::$SFx32,
                        Right::$SFx33
                    ];
                    break;
                case "student":
                    return [
                        Right::$SFx1,
                        Right::$SFx2,
                        Right::$SFx3,
                        Right::$SFx4,
                        Right::$SFx5,
                        Right::$SFx6,
                        Right::$SFx7,
                        Right::$SFx8,
                        Right::$SFx12,
                        Right::$SFx27,
                        Right::$SFx28,
                        Right::$SFx29,
                        Right::$SFx30,
                        Right::$SFx31,
                        Right::$SFx34
                    ];
                    break;  
                case "delegate":
                    return [
                        Right::$SFx1,
                        Right::$SFx2,
                        Right::$SFx3,
                        Right::$SFx4,
                        Right::$SFx5,
                        Right::$SFx6,
                        Right::$SFx7,
                        Right::$SFx8,
                        Right::$SFx9,
                        Right::$SFx10,
                        Right::$SFx11,
                        Right::$SFx12,
                        Right::$SFx13,
                        Right::$SFx14,
                        Right::$SFx15,
                        Right::$SFx16,
                        Right::$SFx17,
                        Right::$SFx18,
                        Right::$SFx19,
                        Right::$SFx20,
                        Right::$SFx22,
                        Right::$SFx23,
                        Right::$SFx24,
                        Right::$SFx25,
                        Right::$SFx26,
                        Right::$SFx32,
                        Right::$SFx33
                    ];  
            }   
        }
    }

?>