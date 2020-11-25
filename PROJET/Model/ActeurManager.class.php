<?php

    class ActeurManager
    {
        private $_bdd;

        // ----- Constructeur ----- //

        function __construct($bdd) 
        {
            $this->setBdd($bdd); 
        }

        // ----- Setters ----- //

        public function setBdd(PDO $bdd)
        {
            $this->_bdd = $bdd;
        }

        // ----- Méthodes ----- //

        public function getById($id)
        {
            $id = (int) $id;

            $query = $this->_bdd->prepare("SELECT * FROM acteur WHERE idActeur = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Acteur($donnees);
        }

        public function add(Acteur $acteur)
        {
            $query = $this->_bdd->prepare("INSERT INTO acteur(prenom, nom, photo) VALUES(?, ?, ?)");
            $query->execute(array($acteur->getPrenom(), $acteur->getNom(), $acteur->getPhoto()));

            $acteur->hydrate([
                'idActeur' => $this->_bdd->lastInsertId(),
                'prenom' => $acteur->getPrenom(),
                'nom' => $acteur->getNom(),
                'photo' => $acteur->getPhoto()
            ]);
        }

        public function update(Acteur $acteur)
        {
            $query = $this->_bdd->prepare("UPDATE acteur SET prenom = ?, nom = ?, photo = ? WHERE idActeur = ?");
            $query->execute(array($acteur->getPrenom(), $acteur->getNom(), $acteur->getPhoto(), $acteur->getIdActeur()));
        }

        public function delete(Acteur $acteur)
        {
            $query = $this->_bdd->prepare("DELETE FROM acteur WHERE idActeur = ?");
            $query->execute(array($acteur->getIdActeur()));
        }

        public function getActorIn(Film $film)
        {
            $acteurs = [];

            $query = $this->_bdd->prepare("SELECT acteur.idActeur, prenom, nom FROM acteur LEFT OUTER JOIN casting ON acteur.idActeur = casting.idActeur WHERE idFilm = ?");
            $query->execute(array($film->getIdFilm()));
            
            while ($donnees = $query->fetch(PDO::FETCH_ASSOC))
            {
                $acteurs[] = new Acteur($donnees);
            }

            return $acteurs;
        }

        function getActors()
        {
            $query = $this->_bdd->prepare("SELECT * FROM acteur");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function getActorsFilm($id)
        {
            $query = $this->_bdd->prepare("SELECT acteur.idActeur, prenom, nom FROM acteur LEFT OUTER JOIN casting ON acteur.idActeur = casting.idActeur WHERE idFilm = ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }

    }      

?>