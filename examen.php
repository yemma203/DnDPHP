<?php

require_once("./config.php");

try {
    $host = DB_HOST;
    $port = DB_PORT;
    $user = DB_USER;
    $pwd = DB_PWD;
    $db_name = "dj_et_drag";

    $connexion = new PDO("mysql:host=$host;port=$port;dbname=$db_name", $user, $pwd);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Erreur lors de la connexion à la database : " . $e->getMessage();
    die();
}

class Personnage
{
    // On met les variables en private pour éviter qu'ils soient modifiés en dehors de la classe
    private $nom;
    private $pv;
    private $pa;

    private $pa_utilises;
    private $pd;
    private $experience;
    private $niveau;
    private $inventaire;
    private $argent;

    private $salle_actuelle;

    public function __construct($nom, $pv, $pa, $pd, $experience, $niveau)
    {
        $this->nom = $nom;
        $this->pv = $pv;
        $this->pa = $pa;
        $this->pd = $pd;
        $this->experience = $experience;
        $this->niveau = $niveau;
        $this->inventaire = [];
        $this->salle_actuelle = 1;
        $this->pa_utilises = 0;
        $this->argent = 0;
    }

    // GETTERS

    public function getNom()
    {
        return $this->nom;
    }

    public function getPv()
    {
        return $this->pv;
    }

    public function getPa()
    {
        return $this->pa;
    }

    public function getPd()
    {
        return $this->pd;
    }

    public function getExperience()
    {
        return $this->experience;
    }

    public function getNiveau()
    {
        return $this->niveau;
    }

    public function getInventaire()
    {
        return $this->inventaire;
    }

    public function getSalleActuelle()
    {
        return $this->salle_actuelle;
    }
    public function getPa_utilises()
    {
        return $this->pa_utilises;
    }
    public function getArgent()
    {
        return $this->argent;
    }

    // SETTERS

    public function setPV($pv)
    {
        $this->pv = $pv;
    }
    public function setSalle_actuelle($salle_actuelle)
    {
        $this->salle_actuelle = $salle_actuelle;
    }
    public function setPa_utilises($pa_utilises)
    {
        $this->pa_utilises = $pa_utilises;
    }

    public function setArgent($argent)
    {
        $this->argent = $argent;
    }

    // METHODS

    public function ajouterInventaire($objet)
    {
        // Ajoute un objet de la classe Objet à l'inventaire du personnage
        array_push($this->inventaire, $objet);
    }

    public function retirerInventaire($objet)
    {
        // Retire un objet de l'inventaire du personnage
        unset($this->inventaire[array_search($objet, $this->inventaire)]);
        // On réindexe le tableau
        $this->inventaire = array_values($this->inventaire);
    }

    public function gagnerExperience($experience)
    {
        // Ajoute de l'expérience au personnage
        $this->experience += $experience;

        // Si l'expérience du personnage est supérieure à 100, il gagne un niveau
        if ($this->experience >= 100) {
            $this->experience -= 100;
            $this->niveau += 1;
            echo "Le personnage " . $this->nom . " passe au niveau " . $this->niveau . " !\n";

            // Gain de statistiques
            $this->pv += 10;
            $this->pa += 1;
            $this->pd += 1;
        }
    }

    public function subirDegats($degats)
    {
        // Retire des points de vie au personnage
        if ($degats - $this->pd > 0) {
            $this->pv -= $degats - $this->pd;
            echo "Le personnage " . $this->nom . " subit " . ($degats - $this->pd) . " dégâts !";
        } else {
            echo "Le personnage " . $this->nom . " n'a pas subi de dégâts !";
        }

        // Si les points de vie du personnage sont inférieurs ou égaux à 0, il meurt
        if ($this->pv <= 0) {
            echo "Le personnage " . $this->nom . " est mort !";
        }
    }

    public function attaquer($cible, $degats)
    {
        // Attaque la cible
        $cible->subirDegats($degats);
    }

    public function afficherInventaire()
    {
        // Affiche l'inventaire du personnage
        echo "Inventaire de " . $this->nom . " : \n";
        for ($i = 0; $i < count($this->inventaire); $i++) {
            echo ($i + 1) . ". " . $this->inventaire[$i]->getNom() . " -> " . $this->inventaire[$i]->getPa() . "PA \n";
        }
    }
}

class Monstre
{
    private $nom;
    private $pv;
    private $puissance_attaque;
    private $difficulte;

    public function __construct($nom, $pv, $puissance_attaque, $difficulte)
    {
        $this->nom = $nom;
        $this->pv = $pv;
        $this->puissance_attaque = $puissance_attaque;
        $this->difficulte = $difficulte;
    }

    // GETTERS

    public function getNom()
    {
        return $this->nom;
    }

    public function getPv()
    {
        return $this->pv;
    }

    public function getPuissanceAttaque()
    {
        return $this->puissance_attaque;
    }

    public function getDifficulte()
    {
        return $this->difficulte;
    }

    // METHODS

    public function subirDegats($degats)
    {
        // Retire des points de vie au monstre
        echo "Le monstre " . $this->nom . " subit " . $degats . " dégâts !\n";
        $this->pv -= $degats;

        // Si les points de vie du monstre sont inférieurs ou égaux à 0, il meurt
        if ($this->pv <= 0) {
            echo "Le monstre " . $this->nom . " est mort !";
        }
    }

    public function attaquer($cible)
    {
        // Attaque la cible
        $cible->subirDegats($this->puissance_attaque);
    }

    public function afficherMonstre()
    {
        // Affiche les caractéristiques du monstre
        echo "Monstre " . $this->nom . " : \n";
        echo "Points de vie : " . $this->pv . "\n";
        echo "Puissance d'attaque : " . $this->puissance_attaque . "\n";
        echo "Difficulté : " . $this->difficulte . "\n";
    }
}

class Enigme
{
    private $difficulte;
    private $enonce;
    private $mauvaise_reponse1;
    private $mauvaise_reponse2;
    private $mauvaise_reponse3;
    private $bonne_reponse;

    public function __construct($difficulte, $enonce, $mauvaise_reponse1, $mauvaise_reponse2, $mauvaise_reponse3, $bonne_reponse)
    {
        $this->difficulte = $difficulte;
        $this->enonce = $enonce;
        $this->mauvaise_reponse1 = $mauvaise_reponse1;
        $this->mauvaise_reponse2 = $mauvaise_reponse2;
        $this->mauvaise_reponse3 = $mauvaise_reponse3;
        $this->bonne_reponse = $bonne_reponse;
    }

    // GETTERS

    public function getDifficulte()
    {
        return $this->difficulte;
    }

    public function getEnonce()
    {
        return $this->enonce;
    }

    public function getMauvaiseReponse1()
    {
        return $this->mauvaise_reponse1;
    }

    public function getMauvaiseReponse2()
    {
        return $this->mauvaise_reponse2;
    }

    public function getMauvaiseReponse3()
    {
        return $this->mauvaise_reponse3;
    }

    public function getBonneReponse()
    {
        return $this->bonne_reponse;
    }

    // METHODS

    public function afficherEnigme()
    {
        // Affiche l'énoncé de l'énigme et les réponses de facon aléatoire
        $reponses = [$this->mauvaise_reponse1, $this->mauvaise_reponse2, $this->mauvaise_reponse3, $this->bonne_reponse];
        shuffle($reponses);
        echo $this->enonce . "\n";
        echo "1. " . $reponses[0] . "\n";
        echo "2. " . $reponses[1] . "\n";
        echo "3. " . $reponses[2] . "\n";
        echo "4. " . $reponses[3] . "\n";

        $reponse = (int)readline("Quelle est votre réponse ? \n");
        while ($reponse < 1 || $reponse > 4) {
            $reponse = (int)readline("Quelle est votre réponse ? \n");
        }

        return $this->verifierReponse($reponses[$reponse - 1]);
    }

    public function verifierReponse($reponse)
    {
        // Vérifie si la réponse est correcte
        if ($reponse == $this->bonne_reponse) {
            return true;
        } else {
            return false;
        }
    }
}

class Objet
{
    // Classe parente de Arme et Potion
    private $nom;

    private $prix;

    public function __construct($nom, $prix)
    {
        $this->nom = $nom;
        $this->prix = $prix;
    }
    public function getNom()
    {
        return $this->nom;
    }

    public function getPrix()
    {
        return $this->prix;
    }
}

class Arme extends Objet
{
    private $degats;
    private $pa;

    public function __construct($nom, $prix, $degats, $pa)
    {
        parent::__construct($nom, $prix);
        $this->degats = $degats;
        $this->pa = $pa;
    }

    // GETTERS

    public function getDegats()
    {
        return $this->degats;
    }

    public function getPa()
    {
        return $this->pa;
    }
}

class Potion extends Objet
{
    private $pv;
    private $pa;

    public function __construct($nom, $prix, $pv, $pa)
    {
        parent::__construct($nom, $prix);
        $this->pv = $pv;
        $this->pa = $pa;
    }

    // GETTERS

    public function getPv()
    {
        return $this->pv;
    }
    public function getPa()
    {
        return $this->pa;
    }
}

class Marchand
{
    private $nom;
    private $inventaire;

    public function __construct($nom)
    {
        $this->nom = $nom;
        $this->inventaire = [];
    }

    // GETTERS

    public function getNom()
    {
        return $this->nom;
    }

    public function getInventaire()
    {
        return $this->inventaire;
    }

    // METHODS

    public function recupererObjets($objets)
    {
        // Ajoute des objets à l'inventaire du marchand
        // Le marchand a entre 2 et 5 objets dans son inventaire
        // On récupère des objets aléatoirement dans la liste des objets

        $nb_objets = rand(2, 5);
        for ($i = 0; $i < $nb_objets; $i++) {
            $objet = $objets[rand(0, count($objets) - 1)];
            // On vérifie que l'objet n'est pas déjà dans l'inventaire du marchand
            while (in_array($objet, $this->inventaire)) {
                $objet = $objets[rand(0, count($objets) - 1)];
            }
            if ($objet["pv"] != null) {
                $objet = new Potion($objet["nom"], $objet["prix"], $objet["pv"], $objet["pa"]);
            } else {
                $objet = new Arme($objet["nom"], $objet["prix"], $objet["degats"], $objet["pa"]);
            }
            array_push($this->inventaire, $objet);
        }
    }

    public function afficherInventaire()
    {
        // Affiche l'inventaire du marchand
        echo "Inventaire de " . $this->nom . " : \n";
        for ($i = 0; $i < count($this->inventaire); $i++) {
            echo ($i + 1) . ". " . $this->inventaire[$i]->getNom() . " -> " . $this->inventaire[$i]->getPrix() . " pièces (" . $this->inventaire[$i]->getPa() .  " PA)\n";
        }
    }

    public function supprimerObjet($objet)
    {
        // Supprime un objet de l'inventaire du marchand
        unset($this->inventaire[array_search($objet, $this->inventaire)]);
        // On réindexe le tableau
        $this->inventaire = array_values($this->inventaire);
    }

    public function viderInventaire()
    {
        // Vide l'inventaire du marchand
        $this->inventaire = [];
    }
}

class PersonnageDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function ajouterPersonnage($personnage)
    {
        // Ajoute un personnage à la base de données, on utilise la commande INSERT INTO pour ajouter une ligne dans la table personnage
        try {
            $requete = $this->db->prepare("INSERT INTO personnage(nom, pv, point_action, point_defense, experience, niveau, salle_actuelle) VALUES (:nom, :pv, :pa, :pd, :experience, :niveau, :salle_actuelle)");
            $requete->execute([
                ":nom" => $personnage->getNom(),
                ":pv" => $personnage->getPv(),
                ":pa" => $personnage->getPa(),
                ":pd" => $personnage->getPd(),
                ":experience" => $personnage->getExperience(),
                ":niveau" => $personnage->getNiveau(),
                ":salle_actuelle" => $personnage->getSalleActuelle()
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du personnage : " . $e->getMessage();
            die();
        }
    }

    public function recupererPersonnage()
    {
        // Fonction qui récupère le personnage dans la base de données
        // On utilise la commande SELECT pour récupérer les données de la table personnage
        // On recupere tous les personnages avec * car il n'y a qu'un seul personnage dans la base de données
        try {
            $requete = $this->db->prepare("SELECT * FROM personnage");
            $requete->execute();
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
            if ($resultat == null) {
                return null;
            } else {
                $personnage = new Personnage($resultat["nom"], $resultat["pv"], $resultat["point_action"], $resultat["point_defense"], $resultat["experience"], $resultat["niveau"]);
                $personnage->setSalle_actuelle($resultat["salle_actuelle"]);
                return $personnage;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du personnage : " . $e->getMessage();
            die();
        }
    }

    public function sauvegarderPersonnage($personnage)
    {
        // Fonction qui met à jour les informations du personnage dans la base de données
        // Cela permet de sauvegarder le personnage
        try {
            $requete = $this->db->prepare("UPDATE personnage SET pv = :pv, point_action = :pa, point_defense = :pd, experience = :experience, niveau = :niveau, salle_actuelle = :salle_actuelle WHERE nom = :nom");
            $requete->execute([
                ":nom" => $personnage->getNom(),
                ":pv" => $personnage->getPv(),
                ":pa" => $personnage->getPa(),
                ":pd" => $personnage->getPd(),
                ":experience" => $personnage->getExperience(),
                ":niveau" => $personnage->getNiveau(),
                ":salle_actuelle" => $personnage->getSalleActuelle()
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de la sauvegarde du personnage : " . $e->getMessage();
            die();
        }
    }

    public function supprimerPersonnage()
    {
        // Fonction qui supprime le personnage de la base de données
        // On utilise la commande DELETE pour supprimer le personnage
        try {
            $requete = $this->db->prepare("DELETE FROM personnage");
            $requete->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression du personnage : " . $e->getMessage();
            die();
        }
    }
}

class InventaireDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function ajouterObjet($personnage, $objet)
    {
        $id_objet = 0;
        $id_personnage = 0;

        // Récupèration de l'id de l'objet
        try {
            $requete = $this->db->prepare("SELECT id FROM objet WHERE nom = :nom");
            $requete->execute([":nom" => $objet->getNom()]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
            $id_objet = $resultat["id"];
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'objet : " . $e->getMessage();
            die();
        }

        // Récupèration de l'id du personnage
        try {
            $requete = $this->db->prepare("SELECT id FROM personnage WHERE nom = :nom");
            $requete->execute([":nom" => $personnage->getNom()]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
            $id_personnage = $resultat["id"];
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du personnage : " . $e->getMessage();
            die();
        }

        // Ajout de l'objet à l'inventaire
        try {
            $requete = $this->db->prepare("INSERT INTO inventaire(id_personnage, id_objet) VALUES (:id_personnage, :id_objet)");
            $requete->execute([":id_personnage" => $id_personnage, ":id_objet" => $id_objet]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'objet à l'inventaire : " . $e->getMessage();
            die();
        }
    }

    public function supprimerInventaire()
    {
        try {
            $requete = $this->db->prepare("DELETE FROM inventaire");
            $requete->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de l'inventaire : " . $e->getMessage();
            die();
        }
    }

    public function recupererInventaire($personnage)
    {
        // On recupere d'abord l'id du personnage grace à son nom
        try {
            $requete = $this->db->prepare("SELECT id FROM personnage WHERE nom = :nom");
            $requete->execute([":nom" => $personnage->getNom()]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
            $id_personnage = $resultat["id"];
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'id du personnage : " . $e->getMessage();
            die();
        }

        // On récupère ensuite les objets de l'inventaire du personnage
        try {
            $requete = $this->db->prepare("SELECT * FROM inventaire WHERE id_personnage = :id_personnage");
            $requete->execute([":id_personnage" => $id_personnage]);
            $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
            $inventaire = [];
            foreach ($resultat as $objet) {
                $requete = $this->db->prepare("SELECT * FROM objet WHERE id = :id");
                $requete->execute([":id" => $objet["id_objet"]]);
                $resultat = $requete->fetch(PDO::FETCH_ASSOC);
                if ($resultat["pv"] != null) {
                    $objet = new Potion($resultat["nom"], $resultat["prix"], $resultat["pv"], $resultat["pa"]);
                } else {
                    $objet = new Arme($resultat["nom"], $resultat["prix"], $resultat["degats"], $resultat["pa"]);
                }
                array_push($inventaire, $objet);
            }
            return $inventaire;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'inventaire : " . $e->getMessage();
            die();
        }
    }
}

class ObjetDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function recupererTousLesObjets()
    {
        // Récupère les objets liés au personnage
        // Pour cela, chaque objet a une variable objet_marchand qui vaut 0 si l'objet est lié au personnage et 1 si l'objet est lié au marchand
        // (On a essayer d'utiliser un boolean ce qui est plus adapté ici mais cela ne fonctionnait pas)
        try {
            $requete = $this->db->prepare("SELECT * FROM objet WHERE objet_marchand = 0");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
            return $resultat;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des objets : " . $e->getMessage();
            die();
        }
    }
}

class SalleDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function recupererSalle($id)
    {
        // Fonction qui récupère une salle en fonction de son id
        try {
            $requete = $this->db->prepare("SELECT * FROM salle WHERE id = :id");
            $requete->execute([":id" => $id]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
            return $resultat;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la salle : " . $e->getMessage();
            die();
        }
    }
}
class MonstreDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function recupererMonstre($difficulte)
    {
        // Fonction qui récupère un monstre aléatoirement en fonction de sa difficulté
        try {
            $requete = $this->db->prepare("SELECT * FROM monstre WHERE difficulte = :difficulte ORDER BY RAND() LIMIT 1");
            $requete->execute([":difficulte" => $difficulte]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
            $monstre = new Monstre($resultat["nom"], $resultat["pv"], $resultat["puissance"], $resultat["difficulte"]);
            return $monstre;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du monstre : " . $e->getMessage();
            die();
        }
    }
}

class EnigmeDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function recupererEnigme($difficulte)
    {
        // Fonction qui récupère une énigme aléatoirement en fonction de sa difficulté
        try {
            $requete = $this->db->prepare("SELECT * FROM enigme WHERE difficulte = :difficulte ORDER BY RAND() LIMIT 1");
            $requete->execute([":difficulte" => $difficulte]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
            $enigme = new Enigme($resultat["difficulte"], $resultat["enonce"], $resultat["mauvaise_reponse1"], $resultat["mauvaise_reponse2"], $resultat["mauvaise_reponse3"], $resultat["bonne_reponse"]);
            return $enigme;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'énigme : " . $e->getMessage();
            die();
        }
    }
}

class MarchanDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function recupererMarchand()
    {
        // Fonction qui récupère les objets liés au marchand (où objet_marchand = 1)
        try {
            $requete = $this->db->prepare("SELECT * FROM objet WHERE objet_marchand = 1");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
            return $resultat;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du marchand : " . $e->getMessage();
            die();
        }
    }
}

// Fonctions

function choixAttaque($personnage)
{
    // Je joueur choisi entre attaquer avec ses poings, attaquer avec une arme de son inventaire ou utiliser une potion de son inventaire
    $choix = readline("Que voulez-vous faire ? \n1. Attaquer avec vos poings \n2. Utiliser un objet\n3. Voir les statistiques du personnage\n");
    if ($choix == 1) {
        popen('cls', 'w');
        // Attaque avec les poings
        $personnage->setPa_utilises($personnage->getPa_utilises() + 1);
        return "poings";

    } elseif ($choix == 2 && count($personnage->getInventaire()) <= 0) {
        echo "Vous n'avez pas d'objet dans votre inventaire !\n \n";
        return choixAttaque($personnage);

    } else if ($choix == 2) {
        // Attaque avec une arme
        popen('cls', 'w');
        $personnage->afficherInventaire();
        $choix_objet = (int)readline("Quelle arme voulez-vous utiliser ? Entrer 0 pour ne pas utiliser d'objet \n");
        while ($choix_objet < 0 || $choix_objet > count($personnage->getInventaire())) {
            $choix_objet = (int)readline("Quelle arme voulez-vous utiliser ? Entrer 0 pour ne pas utiliser d'objet \n");
        }
        if ($choix_objet == 0) {
            return choixAttaque($personnage);
        }

        $objet = $personnage->getInventaire()[$choix_objet - 1];

        // On vérifie que le personnage a assez de points d'action pour utiliser l'objet
        if ($objet->getPA() > ($personnage->getPa() - $personnage->getPa_utilises())) {
            echo "Vous n'avez pas assez de points d'action pour utiliser cette arme !\n";
            return choixAttaque($personnage);
        }

        // On enlève les points d'action au personnage en fonction de l'objet utilisé
        $personnage->setPa_utilises($personnage->getPa_utilises() + $objet->getPa());
        return $objet;

    } else if ($choix == 3) {
        popen('cls', 'w');
        // Affiche les statistiques du personnage
        echo "Statistiques de " . $personnage->getNom() . " : \n";
        echo "Points de vie : " . $personnage->getPv() . "\n";
        echo "Points de défense : " . $personnage->getPd() . "\n";
        echo "Expérience : " . $personnage->getExperience() . "\n";
        echo "Niveau : " . $personnage->getNiveau() . "\n";
        return choixAttaque($personnage);

    } else {
        // Si le joueur entre un choix invalide, on lui redemande de choisir
        echo "Choix invalide !\n";
        return choixAttaque($personnage);
    }
}

function combat($personnage, $monstre)
{
    // Combat entre le personnage et le monstre
    while ($personnage->getPv() > 0 && $monstre->getPv() > 0) {

        // Tour du joueur
        popen('cls', 'w');
        echo "C'est à votre tour !\n";
        echo "Il reste " . $monstre->getPv() . " points de vie au monstre !\n";
        readline("Appuyer sur entrer pour continuer !\n");
        popen('cls', 'w');

        while ($personnage->getPa_utilises() < $personnage->getPa()) {
            // A chaque action, on vérifie si le monstre est mort
            if ($monstre->getPv() <= 0) {
                break;
            }
            echo "Points d'action restants : " . ($personnage->getPa() - $personnage->getPa_utilises()) . "\n";
            $choix = choixAttaque($personnage);
            if ($choix == "poings") {
                echo "Vous attaquez le monstre avec vos poings !\n";
                $personnage->attaquer($monstre, 5);
                echo "\n";
            } elseif ($choix instanceof Arme) {
                echo "Vous attaquez le monstre avec votre " . $choix->getNom() . " !\n";
                $personnage->attaquer($monstre, $choix->getDegats());
            } else {
                echo "Vous utilisez une potion !\n";
                $personnage->setPv($personnage->getPv() + $choix->getPv());
                // On supprime la potion de l'inventaire
                $personnage->retirerInventaire($choix);
            }
        }

        // On remet les points d'action utilisés à 0
        $personnage->setPa_utilises(0);

        // Tour du monstre

        if ($monstre->getPv() > 0 && $personnage->getPv() > 0) {
            echo "C'est au tour du monstre !\n";
            sleep(2);
            popen('cls', 'w');

            echo "Le monstre attaque !\n";
            $monstre->attaquer($personnage);
            readline("\nAppuyer sur entrer pour continuer !\n");
        }
    }

    // La fonction renvoie true si le personnage a gagné le combat et false s'il a perdu

    if ($personnage->getPv() > 0) {
        return true;
    } else {
        echo "Vous avez été vaincu par le monstre !\n";
        return false;
    }
}

function enigme($personnage, $enigme)
{
    // Affiche l'énigme
    if ($enigme->afficherEnigme()) {
        // Si la réponse est correcte, le personnage gagne de l'expérience
        popen('cls', 'w');
        echo "Bonne réponse !\n";
        switch ($enigme->getDifficulte()) {
            case "facile":
                $personnage->gagnerExperience(40);
                break;
            case "moyen":
                $personnage->gagnerExperience(60);
                break;
            case "difficile":
                $personnage->gagnerExperience(90);
                break;
        }
    } else {
        echo "Mauvaise réponse !\n";
        // Si la réponse est incorrecte, le personnage perd des points de vie
        $personnage->subirDegats(10);
        echo "\n";
    }
}

function gagnerObjetAleatoire($personnage, $objets, $inventaireDAO)
{
    // Ajoute un objet aléatoire à l'inventaire du personnage
    $objet = $objets[rand(0, count($objets) - 1)];

    // On check si le personnage a déjà l'objet dans son inventaire, si oui on en génère un autre
    while (in_array($objet, $personnage->getInventaire()) || $objet->getPa() > $personnage->getPa()) {
        $objet = $objets[rand(0, count($objets) - 1)];
    }

    $personnage->ajouterInventaire($objet);
    echo "Vous avez gagné : " . $objet->getNom() . " !\n";

    // Ajoute l'objet à l'inventaire de la database
    $inventaireDAO->ajouterObjet($personnage, $objet);
}

function debutPartie($personnage, $personnageDAO, $inventaireDAO)
{

    // On check si le personnage existe dans la database

    if ($personnage == null) {
        // Si le personnage n'existe pas, on le crée
        echo "Aucune partie n'a été trouvée !\n"
            . "Création d'un nouveau personnage !\n";
        sleep(3);
        // popen('cls', 'w');
        $nom = readline("Quel est le nom de votre personnage ? \n");
        $personnage = new Personnage($nom, 100, 3, 1, 0, 1);
        $personnageDAO->ajouterPersonnage($personnage);
        echo "La partie va commencer !\n";
        sleep(3);
        popen('cls', 'w');
        return $personnage;

    } else if ($personnage != null) {
        // Si le personnage existe, on lui demande s'il veut continuer sa partie ou en créer une nouvelle
        $choix = readline("Une partie a été trouvée ! \n1. Continuer la partie \n2. Créer une nouvelle partie \n");
        while ($choix != 1 && $choix != 2) {
            $choix = readline("Une partie a été trouvée ! \n1. Continuer la partie \n2. Créer une nouvelle partie \n");
        }
        if ($choix == 1) {
            sleep(1);
            popen('cls', 'w');
            // On laisse le personnage tel quel
            echo "Vous continuez votre partie !\n";
            // On récupère l'inventaire du personnage
            $inventaire = $inventaireDAO->recupererInventaire($personnage);
            foreach ($inventaire as $objet) {
                $personnage->ajouterInventaire($objet);
            }
            echo "La partie va commencer !\n";
            sleep(3);
            popen('cls', 'w');
            return $personnage;

        } else if ($choix == 2) {
            // On supprime le personnage de la database
            $personnageDAO->supprimerPersonnage($personnage);
            // On crée un nouveau personnage
            $nom = readline("Quel est le nom de votre personnage ? \n");
            $personnage = new Personnage($nom, 100, 3, 1, 0, 1);
            $personnageDAO->ajouterPersonnage($personnage);
            $inventaireDAO->supprimerInventaire();
            echo "La partie va commencer !\n";
            sleep(3);
            popen('cls', 'w');
            return $personnage;
        }
    }
}

function gagnerArgent($personnage, $salle_actuelle)
{
    // Gain d'argent aléatoire à chaque fin de salle en fonction de la salle actuelle
    $argent = (rand(1, 15) * $salle_actuelle);
    echo "Vous avez gagné " . $argent . " pièces d'or !\n";
    $personnage->setArgent($personnage->getArgent() + $argent);
}

function echangeMarchand($marchand, $personnage, $inventaireDAO, $marchandDAO)
{
    echo "Vous entrez dans la salle du marchand !\n";
    echo "Vous avez " . $personnage->getArgent() . " pièces !\n";
    readline("Appuyez sur entrer pour continuer !\n");

    // On vide l'inventaire du marchand
    $marchand->viderInventaire();

    // On récupère de nouveaux objets
    $marchand->recupererObjets($marchandDAO->recupererMarchand());
    popen('cls', 'w');
    
    $continuer = true;

    while ($continuer) {
        $choix1 = readline("Voulez-vous acheter des objets (1), vendre des objets (2) ou quitter (3) ? \n");
        
        while ($choix1 != 1 && $choix1 != 2 && $choix1 != 3) {
            $choix1 = readline("Voulez-vous acheter des objets (1), vendre des objets (2) ou quitter (3) ? \n");
        }
        
        popen('cls', 'w');
        
        if ($choix1 == 1) {
            if (count($marchand->getInventaire()) == 0) {
                echo "Le marchand n'a plus d'objets à vendre !\n";
                break;
            }
            $marchand->afficherInventaire();
            $choix2 = readline("Quel objet voulez-vous acheter ? Entrer 0 pour ne rien acheter \n");
            while ($choix2 < 0 || $choix2 > count($marchand->getInventaire())) {
                $choix2 = readline("Quel objet voulez-vous acheter ? Entrer 0 pour ne rien acheter \n");
            }
            if ($choix2 == 0) {
                break;
            }
    
            $objet = $marchand->getInventaire()[$choix2 - 1];
            if ($personnage->getArgent() < $objet->getPrix()) {
                echo "Vous n'avez pas assez d'argent pour acheter cet objet !\n";
            } else {
                // On retire l'argent au personnage et on ajoute l'objet à son inventaire
                $personnage->setArgent($personnage->getArgent() - $objet->getPrix());
                $personnage->ajouterInventaire($objet);
                // On ajoute l'objet également à la database
                $inventaireDAO->ajouterObjet($personnage, $objet);

                // On supprime l'objet de l'inventaire du marchand
                $marchand->supprimerObjet($objet);
                echo "Vous avez acheté " . $objet->getNom() . " !\n";
            }
            echo "Vous avez " . $personnage->getArgent() . " pièces !\n";
        } elseif ($choix1 == 2) {
            if (count($personnage->getInventaire()) == 0) {
                echo "Vous n'avez plus d'objets à vendre !\n";
                break;
            }
            $personnage->afficherInventaire();
            $choix2 = readline("Quel objet voulez-vous vendre ? Entrer 0 pour ne rien vendre \n");
            while ($choix2 < 0 || $choix2 > count($personnage->getInventaire())) {
                $choix2 = readline("Quel objet voulez-vous vendre ? Entrer 0 pour ne rien vendre \n");
            }
            if ($choix2 == 0) {
                break;
            }
            
            // Mise en place d'une taxe pour que les objets ne puissent pas être revendus au même prix
            $taxe = 10;

            $objet = $personnage->getInventaire()[$choix2 - 1];
            // On ajoute l'argent au personnage et on supprime l'objet de son inventaire
            $personnage->setArgent($personnage->getArgent() + ($objet->getPrix() - $taxe));
            echo "Vous avez vendu " . $objet->getNom() . " pour " . ($objet->getPrix() - $taxe) ." pieces !\n";
            $personnage->retirerInventaire($objet);
            // On supprime l'objet de la database
            $inventaireDAO->supprimerInventaire($personnage, $objet);   
    
            readline("Appuyez sur entrer pour continuer !\n");
            popen('cls', 'w');
            echo "Vous avez " . $personnage->getArgent() . " pièces !\n";
        } elseif ($choix1 == 3) {
            $continuer = false;
        }
    }
}


// Instanciation des DAO
$personnageDAO = new PersonnageDAO($connexion);
$inventaireDAO = new InventaireDAO($connexion);
$objetDAO = new ObjetDAO($connexion);
$monstreDAO = new MonstreDAO($connexion);
$enigmeDAO = new EnigmeDAO($connexion);
$salleDAO = new SalleDAO($connexion);
$marchandDAO = new MarchanDAO($connexion);


// Instanciation des objets non liés au marchand présents dans la database

$objetsDB = $objetDAO->recupererTousLesObjets();
$objets = [];
foreach ($objetsDB as $objet) {
    if ($objet["pv"] != null) {
        $objet = new Potion($objet["nom"], $objet["prix"], $objet["pv"], $objet["pa"]);
    } else {
        $objet = new Arme($objet["nom"], $objet["prix"], $objet["degats"], $objet["pa"]);
    }
    array_push($objets, $objet);
}



// Début de la partie

$personnage = $personnageDAO->recupererPersonnage();


$personnage = debutPartie($personnage, $personnageDAO, $inventaireDAO);
$marchand = new Marchand("Marchand Robert");


while ($personnage->getSalleActuelle() < 10) {

    // Récupération de la salle actuelle
    $salle_actuelle = $personnage->getSalleActuelle();

    echo "Vous entrez dans la salle " . $salle_actuelle . " !\n";
    $choix = readline("Voulez vous continuer ? \n1. Oui \n2. Non \n");
    while ($choix != 1 && $choix != 2) {
        $choix = readline("Voulez vous continuer ? \n1. Oui \n2. Non \n");
    }
    if ($choix == 2) {
        popen('cls', 'w');
        echo "Vous avez quittez la partie !\n";
        sleep(3);
        break;
    }
    popen('cls', 'w');


    // Récupération de la salle
    $salle = $salleDAO->recupererSalle($salle_actuelle);

    echo "C'est une salle de type " . $salle["type_salle"] . " !\n";

    if ($salle["type_salle"] === "monstre") {
        // Récupération du monstre en fonction de la difficulté de la salle
        $monstre = $monstreDAO->recupererMonstre($salle["difficulte"]);
        $monstre->afficherMonstre();

        echo "Un combat s'apprête à commencer\n";
        sleep(2);
        readline("Appuyez sur entrer pour continuer !\n");
        popen('cls', 'w');

        // Combat
        // Si le personnage perd le combat, on arrête la partie
        if (!combat($personnage, $monstre)) {
            // On supprime le personnage et son inventaire de la base de données
            $personnageDAO->supprimerPersonnage();
            $inventaireDAO->supprimerInventaire();
            exit();
        }



        // Gain d'expérience
        switch ($salle["difficulte"]) {
            case "facile":
                $personnage->gagnerExperience(40);
                break;
            case "moyen":
                $personnage->gagnerExperience(60);
                break;
            case "difficile":
                $personnage->gagnerExperience(90);
                break;
        }
    } else if ($salle["type_salle"] === "enigme") {
        // Récupération de l'énigme
        $enigme = $enigmeDAO->recupererEnigme($salle["difficulte"]);

        // Enigme
        enigme($personnage, $enigme);
    }


    // Gain d'argent
    gagnerArgent($personnage, $salle_actuelle);

    // Génération d'un objet aléatoire
    gagnerObjetAleatoire($personnage, $objets, $inventaireDAO);

    readline("Appuyez sur entrer pour continuer !\n");
    popen('cls', 'w');

    if ($salle_actuelle == 3 || $salle_actuelle == 6 || $salle_actuelle == 9) {
        // Salle du marchand
        echangeMarchand($marchand, $personnage, $inventaireDAO, $marchandDAO);
    }

    // On passe à la salle suivante
    $personnage->setSalle_actuelle($personnage->getSalleActuelle() + 1);


    // Sauvegarde du personnage
    $personnageDAO->sauvegarderPersonnage($personnage);
}


echo "Vous avez gagné !\n";
sleep(2);

// On supprime le personnage et son inventaire de la base de données pour recommencer une nouvelle partie
$personnageDAO->supprimerPersonnage();
$inventaireDAO->supprimerInventaire();
