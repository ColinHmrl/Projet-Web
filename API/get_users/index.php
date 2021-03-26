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

    echo json_encode(get_all_user(empty($_GET['role']) ?: $_GET['role']));


    // On encode en json et on envoie

    //echo json_encode($response);



} else {
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}




function get_all_user($role = "null")
{

    include('../../models/loginBDD.php');

    if ($role == "null") {
        $req = $bdd->prepare('SELECT * FROM users');
        if (!$req->execute())
            print_r($bdd->errorInfo());
    } else {
        $req = $bdd->prepare('SELECT * FROM users WHERE users.roles = ?');
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
