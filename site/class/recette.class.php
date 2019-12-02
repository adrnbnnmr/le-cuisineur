<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/pdoconnection.php";

class Recette
{
    private $id; // id en BDD
    private $datePublication; // date de publication
    private $titre; // nom de la recette
    private $description; // description

    private $categorie; // objet Categorie associe
    private $auteur; // objet Utilisateur associe

    private $tempsPreparation; // temps de preparation en minute
    private $tempsCuisson; // temps de cuisson en minute
    private $tempsRepos; // temps de repos en minute

    private $difficulte; // difficulte de 1 a 5
    private $cout; // cout de 1 a 3, dans enum Difficulte
    private $illustration; // nom de fichier de la photo de la recette
    private $nombrePersonne; // nombre de personne prevu par la recette

    private $note; // moyenne des notes

    /**
     * Recupere une recette a partir de son id en base de donnees
     * @param int $id l'id de la recette en BDD, > 0
     * @throws Exception if id invalid
     */
    public static function get(int $id = 0): Recette
    {
        // id invalide
        if ($id < 1) {
            throw new BadMethodCallException("The provided id is incorrect: should be a strictly positive integer");
        }

        // Recuperer les donnees en BDD de la recette
        // Connexion a la BDD
        $pdo = get_pdo_connection();

        // prepare statement
        $statement = $pdo->prepare("SELECT * FROM RECETTE WHERE rct_id = :id");
        $statement->execute([':id' => $id]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);

        return new Recette($data);
    }


    public static function get_random_recette(string $cat = "all")
    {
        $pdo = get_pdo_connection();

        if ($cat === "all") {
            $stmt = $pdo->prepare("SELECT * FROM RECETTE");
            $stmt->execute();
        } else {
            $stmt = $pdo->prepare("SELECT * FROM RECETTE WHERE cat_label = ?");
            $stmt->execute([$cat]);
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $random_row = array_rand($data);

        return new Recette($data[$random_row]);
    }

    public static function get_test_recette()
    {
        return new Recette(['test' => '']);
    }


    private function __construct(array $data)
    {

        if (key_exists('test', $data)) {
            $this->id = 'dummyid'; // id en BDD
            $this->datePublication = 'dummydatePublication'; // date de publication
            $this->titre = 'dummytitre'; // nom de la recette
            $this->description = 'dummydescription'; // description
            $this->categorie = 'dummycategorie'; // objet Categorie associe
            $this->auteur = 'dummyauteur'; // objet Utilisateur associe
            $this->tempsPreparation = '1'; // temps de preparation en minute
            $this->tempsCuisson = '1'; // temps de cuisson en minute
            $this->tempsRepos = '1'; // temps de repos en minute
            $this->difficulte = '2'; // difficulte de 1 a 5
            $this->cout = '4'; // cout de 1 a 3, dans enum Difficulte
            $this->illustration = 'dummyillustration'; // nom de fichier de la photo de la recette
            $this->nombrePersonne = '3'; // nombre de personne prevu par la recette
            $this->note = '4'; // moyenne des notes
        } else {

            // Recuperer les instances de l'auteur et de la categorie
            $this->auteur = $data['uti_login'];

            $this->categorie = $data['cat_label'];

            // Le fichier existe-t-il ?
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $data['rct_illustration'])) {
                throw new Exception("Le fichier image n'existe pas pour la recette : rct_id:{$data['rct_id']}, rct_illustration:{$data['rct_illustration']}");
            }

            $this->illustration = $data['rct_illustration'];

            $this->id = $data['rct_id'];
            $this->datePublication = $data['rct_date'];
            $this->titre = $data['rct_titre'];
            $this->description = $data['rct_description'];

            $this->cout = $data['rct_cout'];
            $this->difficulte = $data['rct_difficulte'];

            $this->nombrePersonne = $data['rct_nb_personnes'];

            $this->tempsPreparation = $data['rct_temps_preparation'];
            $this->tempsCuisson = $data['rct_temps_cuisson'];
            $this->tempsRepos = $data['rct_temps_repos'];

            $this->note = $data['rct_note'];
        }
    }

    /**
     * Retourne des informations de la recette sous forme de chaine de caractere HTML
     */
    public function to_info_HTML()
    {
        return <<<HTML
        <div class="inforecette">
			<picture class="inforecette__picture">
				<img src="/recette/{$this->id}/illustration" alt="Menu picture">
			</picture>
			<div class="inforecette__data">
				<h1 class='inforecette__titre'>{$this->titre}</h1>
                <h2 class='inforecette__auteur'>{$this->auteur}</h2>
                <ul class='inforecette__temps'>
                    <li>Preparation : {$this->tempsPreparation} min</li>		                   
                    <li>Cuisson : {$this->tempsCuisson} min</li>					
                    <li>Repos : {$this->tempsRepos} min</li>
                </ul>
				<ul class='inforecette__stats stats'>
					<li class="stats__element">
                        <div class="stats__label">Difficulte</div>
                        <meter value="{$this->difficulte}" min="0" max="5"></meter>
                    </li>
					<li class="stats__element">
                        <div class="stats__label">Cout</div>
                        <meter value="{$this->cout}" min="0" max="3" low="1" high="3"></meter>
                    </li>
					<li class="stats__element">
                        <div class="stats__label">Note</div>
                        <meter value="{$this->note}" min="0" max="5"></meter>
                    </li>
				</ul>
			</div>
		</div>
HTML;
    }

    /**
     *
     */
    public function to_detailed_HTML()
    { }

    public function get_id(): int
    {
        return $this->id;
    }
    public function get_date_publication(): DateTime
    {
        return $this->datePublication;
    }
    public function get_titre(): string
    {
        return $this->titre;
    }
    public function get_description(): string
    {
        return $this->description;
    }
    public function get_categorie(): string
    {
        return $this->categorie;
    }
    public function get_auteur(): string
    {
        return $this->auteur;
    }
    public function get_temps_preparation(): int
    {
        return $this->tempsPreparation;
    }
    public function get_temps_cuisson(): int
    {
        return $this->tempsCuisson;
    }
    public function get_temps_repos(): int
    {
        return $this->tempsRepos;
    }
    public function get_difficulte(): int
    {
        return $this->difficulte;
    }
    public function get_cout(): int
    {
        return $this->cout;
    }
    public function get_illustration(): string
    {
        return $this->illustration;
    }
    public function get_nombre_personne(): int
    {
        return $this->nombrePersonne;
    }
    public function get_note(): int
    {
        return $this->note;
    }
}
