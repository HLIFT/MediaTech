<?php

    class FilmManager
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

        public function getByID($id)
        {
            $id = (int) $id;

            $query = $this->_bdd->prepare("SELECT * FROM film WHERE idFilm = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Film($donnees);   
        }

        public function getByYear($annee)
        {
            $annee = (int) $annee;

            $query = $this->_bdd->prepare("SELECT * FROM film WHERE annee = ?");
            $query->execute(array($annee));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Film($donnees);
        }

        public function add(Film $film)
        {
            $query = $this->_bdd->prepare("INSERT INTO film(titre, annee, score, nbVotants, jacket) VALUES(?, ?, ?, ?, ?)");
            $query->execute(array($film->getTitre(), $film->getAnnee(), $film->getScore(), $film->getVote(), $film->getJacket()));

            $film->hydrate([
                'idFilm' => $this->_bdd->lastInsertId(),
                'titre' => $film->getTitre(),
                'annee' => $film->getAnnee(),
                'score' => $film->getScore(),
                'nbVotants' => $film->getVote(),
                'jacket' => $film->getJacket()
            ]);
        }

        public function update(Film $film)
        {
            $query = $this->_bdd->prepare("UPDATE film SET titre = ?, annee = ?, score = ?, nbVotants = ?, jacket = ? WHERE idFilm=?");
            $query->execute(array($film->getTitre(), $film->getAnnee(), $film->getScore(), $film->getVote(), $film->getJacket(), $film->getIdFilm()));
        }

        public function delete(Film $film)
        {
            $query = $this->_bdd->prepare("DELETE FROM film WHERE idFilm = ?");
            $query->execute(array($film->getIdFilm()));
        }

        public function getFilmsWithActor(Acteur $acteur)
        {
            $films = [];

            $query = $this->_bdd->prepare("SELECT film.idFilm, titre, annee, score, nbVotants FROM film LEFT OUTER JOIN casting ON film.idFilm = casting.idFilm WHERE idActeur = ?");
            $query->execute(array($acteur->getIdActeur()));

            while ($donnees = $query->fetch(PDO::FETCH_ASSOC))
            {
                $films[] = new Film($donnees);
            }

            return $films;
        }

        public function getFilms()
        {
            $query = $this->_bdd->prepare("SELECT * FROM film");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function getFilmsActor($id)
        {
            $query = $this->_bdd->prepare("SELECT film.idFilm, titre FROM film LEFT OUTER JOIN casting ON film.idFilm = casting.idFilm WHERE idActeur = ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }

        public function getFilmsNoActor($id)
        {
            $query = $this->_bdd->prepare("SELECT film.idFilm, titre FROM film LEFT OUTER JOIN casting ON film.idFilm = casting.idFilm WHERE idActeur != ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }


        public function getIdFilm(Film $film)
        {
            $query = $this->_bdd->prepare("SELECT * FROM film WHERE titre = ?, annee = ?, score = ?, nbVotants = ?");
            $query->execute(array($film->getTitre(), $film->getAnnee(), $film->getScore(), $film->getVote()));
            $result = $query->fetchAll();
            return $result;
        }

        public function getFilmsUser($id)
        {
            $query = $this->_bdd->prepare("SELECT film.idFilm, titre, annee, score, nbVotants, jacket FROM film LEFT OUTER JOIN vote ON film.idFilm = vote.idFilm WHERE idUser = ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }

    }      

?>