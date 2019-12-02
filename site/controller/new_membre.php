<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/class/utilisateur.class.php';


if (!isset($_POST) || !is_array($_POST)) exit(json_encode(['success' => false, 'message' => "Erreur interne, merci d'essayer plus tard."]));


try {
    // enregistre l'utilisateur dans la BDD a partir de la requete POST
    Utilisateur::register($_POST);

    //POUR LA DEMO: enregistre l'utilisateur en session
    session_start();

    $_SESSION["utilisateur"] = $_POST["login"];

    exit(json_encode(["success" => true, "message" => $_POST["login"]]));
} catch (Exception $e) {
    $msg = "";
    switch ($e->getCode()) {
        case Utilisateur::ERROR_DATA_MISSING:
            $msg = "Le champs {$e->getMessage()} n'est pas renseigne";
            break;
        case Utilisateur::ERROR_INVALID_LOGIN:
            $msg = "Le login est invalide";
            break;
        case Utilisateur::ERROR_INVALID_EMAIL:
            $msg = "L'email est invalide";
            break;
        case Utilisateur::ERROR_EMAIL_ALREADY_EXISTS:
            $msg = "L'email saisi est deja utilise";
            break;
        case Utilisateur::ERROR_LOGIN_ALREADY_EXISTS:
            $msg = "Le nom d'utilisateur saisi est deja utilise";
            break;
        default:
            $msg = "Erreur interne";
    }

    exit(json_encode(['success' => false, "message" => $msg]));
}
