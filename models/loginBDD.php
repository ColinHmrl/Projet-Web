<?php

//Configuration de la BDD

$bdd = new \PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '',array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING));
$bdd->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

