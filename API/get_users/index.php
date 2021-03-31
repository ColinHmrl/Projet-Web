<?php





if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Headers requis
    // Accès depuis n'importe quel site ou appareil (*)
    header("Access-Control-Allow-Origin: *");

    // Format des données envoyées
    header("Content-Type: application/json; charset=UTF-8");

    // Méthode autorisée
    header("Access-Control-Allow-Methods: GET");

    // Durée de vie de la requête
    header("Access-Control-Max-Age: 3600");

    // Entêtes autorisées
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_GET["user"]) && !empty($_GET["token"])) {



        if(ApiGetUser::verifUser($_GET["user"], $_GET["token"])) {
            echo json_encode(ApiGetUser::getAllUser(empty($_GET['role']) ?: $_GET['role']));
        }
        else {
            http_response_code(403);
            echo json_encode(["message" => "token invalide"]);
        }
        


    }
    else {
        http_response_code(403);
        echo json_encode(["message" => "token invalide"]);
    }
    


    // On encode en json et on envoie

    //echo json_encode($response);



} else {
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}


class ApiGetUser {

static function getAllUser($role = "null")
{

    include('../../models/loginBDD.php');

    if ($role == "null") {
        $req = $bdd->prepare('SELECT * FROM users WHERE users.del = 0');
        if (!$req->execute())
            print_r($bdd->errorInfo());
    } else {
        $req = $bdd->prepare('SELECT * FROM users WHERE users.roles = ? and users.del = 0');
        if (!$req->execute([$role]))
            print_r($bdd->errorInfo());
    }


    //$tableauProduits = $req->fetchAll(PDO::FETCH_ASSOC);

    //$tableauUsers['nbrResult'] = 0;
    if (!($row = $req->fetch(PDO::FETCH_ASSOC))) {
        $tableauUsers['error'] = "No result";
    } else {
        do {
            extract($row);
            $prod = [
                "id" => $id,
                "last_name" => $last_name,
                "first_name" => $first_name,
                "email" => $email,
                "roles" => $roles
            ];

            $tableauUsers['users'][] = $prod;
            //$tableauUsers['nbrResult']++;
        } while ($row = $req->fetch(PDO::FETCH_ASSOC));
    }

    //$tableauUsers['nbrResult'] = $result;
    return $tableauUsers;
}

static function verifUser($user,$password) {


    include('../../models/loginBDD.php');
        
        $req = $bdd->prepare('SELECT id FROM users WHERE email = ? AND password = ?');// WHERE email = ? AND password = ?');
    
        if(!$req->execute([$user,$password]))
            print_r($bdd->errorInfo());
        else {
            //var_dump(hash('sha256',$password));
            return $req->fetch() ? true : false;        
            
            
        }
    }

}