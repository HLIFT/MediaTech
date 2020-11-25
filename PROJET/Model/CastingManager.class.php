<?php

    class CastingManager
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

        public function add(Casting $casting)
        {
            $query = $this->_bdd->prepare("INSERT INTO casting(idFilm, idActeur) VALUES(?, ?)");
            $query->execute(array($casting->getIdFilm(), $casting->getIdActeur()));

            $casting->hydrate([
                'idCast' => $this->_bdd->lastInsertId(),
                'idFilm' => $casting->getIdFilm(),
                'idActeur' => $casting->getIdActeur()
            ]);
        }

        public function update(Casting $casting)
        {
            $query = $this->_bdd->prepare("UPDATE casting SET idFilm = ?, idActeur = ? WHERE idCast = ?");
            $query->execute(array($casting->getIdFilm(), $casting->getIdActeur(), $casting->getIdCast()));
        }

        public function delete(Casting $casting)
        {
            $query = $this->_bdd->prepare("DELETE FROM casting WHERE idCast = ?");
            $query->execute(array($casting->getIdCast()));
        }

        public function deleteByFilm($id)
        {
            $query = $this->_bdd->prepare("DELETE FROM casting WHERE idFilm = ?");
            $query->execute(array($id));
        }

        public function deleteByActeur($id)
        {
            $query = $this->_bdd->prepare("DELETE FROM casting WHERE idActeur = ?");
            $query->execute(array($id));
        }

        public function getBy(Film $film, Acteur $acteur)
        {
            $castings = [];

            $query = $this->_bdd->prepare("SELECT idCast FROM casting WHERE idFilm = ? AND idActeur = ?");
            $query->execute(array($film->getIdFilm(), $acteur->getIdActeur()));

            while ($donnees = $query->fetch(PDO::FETCH_ASSOC))
            {
                $castings[] = new Casting($donnees);
            }

            return $castings;
        }

        public function getId($idFilm, $idActeur)
        {
            $query = $this->_bdd->prepare("SELECT idCast AS id FROM casting WHERE idFilm = ? AND idActeur = ?");
            $query->execute(array($idFilm, $idActeur));
            $result = $query->fetch();
            $result = intval($result['id']);
            return $result;
        }

    }      

?>