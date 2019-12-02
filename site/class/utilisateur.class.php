<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/pdoconnection.php";

class Utilisateur
{

    const ERROR_DATA_MISSING = 1;
    const ERROR_INVALID_LOGIN = 2;
    const ERROR_INVALID_EMAIL = 3;
    const ERROR_EMAIL_ALREADY_EXISTS = 4;
    const ERROR_LOGIN_ALREADY_EXISTS = 5;


    private $username;
    private $email;

    private $nom;
    private $prenom;
    private $is_admin;


    /**
     * Recupere un utilisateur a partir de son username en base de donnees
     * @param int $username l'id de l'utilisateur en BDD
     * @throws Exception if username invalide
     */
    public static function get(string $username = ''): Utilisateur
    {
        // username invalide
        if (!self::is_valid_login($username)) {
            throw new BadMethodCallException("The provided username is incorrect: length should be between 4 and 16 and username is composed of letters, digits and special characters '-' '_'");
        }

        // Recuperer les donnees en BDD de la recette
        // Connexion a la BDD
        $pdo = get_pdo_connection();

        // prepare statement
        $statement = $pdo->prepare("SELECT * FROM UTILISATEUR WHERE uti_login = :username");
        $statement->execute([':username' => $username]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);

        return new Utilisateur($data);
    }

    /**
     * Verifie les donnees puis enregistre un utilisateur en base de donnees
     */
    public static function register(array $data): bool
    {
        // verifie l'existance des donnees requises
        $required_data = ["login", "email", "nom", "prenom", "password"];
        foreach ($required_data as $key)
            if (!key_exists($key, $data) || empty($data[$key]))
                throw new BadMethodCallException($key, self::ERROR_DATA_MISSING);

        // verifie la validite du login
        if (!self::is_valid_login($data["login"]))
            throw new BadMethodCallException("The provided username is incorrect: length should be between 4 and 16 and username is composed of letters, digits and special characters '-' '_'", self::ERROR_INVALID_LOGIN);

        // verifie la validite de l'email
        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL))
            throw new BadMethodCallException("The provided email is incorrect", self::ERROR_INVALID_EMAIL);

        // connexion PDO a la BDD
        $pdo = get_pdo_connection();

        // Verifie que l'email ou le login ne soient pas deja enregistres en base
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM UTILISATEUR WHERE uti_mail = LOWER(?)");
        $stmt->execute([$data["email"]]);
        if ($stmt->fetchColumn() > 0) throw new Exception("email already registered !", self::ERROR_EMAIL_ALREADY_EXISTS);


        $stmt = $pdo->prepare("SELECT COUNT(*) FROM UTILISATEUR WHERE LOWER(uti_login) = LOWER(?)");
        $stmt->execute([$data["login"]]);
        if ($stmt->fetchColumn() > 0) throw new Exception("login already taken !", self::ERROR_LOGIN_ALREADY_EXISTS);

        $stmt = $pdo->prepare("INSERT INTO utilisateur (uti_login, uti_mail, uti_nom, uti_prenom, uti_pass) VALUES (?, LOWER(?), ?, ?, ?)");
        $is_registered = $stmt->execute([
            $data["login"],
            $data["email"],
            $data["nom"],
            $data["prenom"],
            password_hash($data["password"], PASSWORD_BCRYPT)
        ]);

        return $is_registered;
    }



    private function __construct($data)
    {
        $this->username = $data['uti_login'];
        $this->email = $data['uti_mail'];
        $this->nom = $data['uti_nom'];
        $this->prenom = $data['uti_prenom'];
        $this->is_admin = $data['uti_admin'] > 0;
    }


    public function get_username(): string
    {
        return $this->username;
    }
    public function get_email(): string
    {
        return $this->email;
    }
    public function get_nom(): string
    {
        return $this->nom;
    }
    public function get_prenom(): string
    {
        return $this->prenom;
    }
    public function is_admin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Verifies the validity of the login
     * The login is composed of alphanumeric and '-', '_' characters. 
     * Its length is 4 to 16 characters long
     */
    private static function is_valid_login($login)
    {
        return preg_match("/[a-zA-Z0-9\-\_]{4,16}/", $login);
    }
}
