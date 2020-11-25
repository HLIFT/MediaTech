<?php

    class VoteManager
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

            $query = $this->_bdd->prepare("SELECT * FROM vote WHERE idVote = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Vote($donnees);   
        }

        public function getByFilm(Film $film)
        {

            $query = $this->_bdd->prepare("SELECT * FROM vote WHERE idFilm = ?");
            $query->execute(array($film->getIdFilm()));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Vote($donnees);
        }

        public function getByUser(User $user)
        {

            $query = $this->_bdd->prepare("SELECT * FROM vote WHERE idUser = ?");
            $query->execute(array($user->getIdUser()));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Vote($donnees);
        }

        public function add(Vote $vote)
        {
            $query = $this->_bdd->prepare("INSERT INTO vote(idFilm, idUser) VALUES(?, ?)");
            $query->execute(array($vote->getIdFilm(), $vote->getIdUser()));

            $vote->hydrate([
                'idVote' => $this->_bdd->lastInsertId(),
                'idFilm' => $vote->getIdFilm(),
                'idUser' => $vote->getIdUser()
            ]);
        }

        public function update(Vote $vote)
        {
            $query = $this->_bdd->prepare("UPDATE vote SET idFilm = ?, idUser = ? WHERE idVote = ?");
            $query->execute(array($vote->getIdFilm(), $vote->getIdUser(), $vote->getIdVote()));
        }

        public function delete(Vote $vote)
        {
            $query = $this->_bdd->prepare("DELETE FROM vote WHERE idVote = ?");
            $query->execute(array($vote->getIdVote()));
        }

        public function deleteByFilm($id)
        {
            $query = $this->_bdd->prepare("DELETE FROM vote WHERE idFilm = ?");
            $query->execute(array($id));
        }

        public function deleteByUser($id)
        {
            $query = $this->_bdd->prepare("DELETE FROM vote WHERE idUser = ?");
            $query->execute(array($id));
        }

        public function getBy(Film $film, User $user)
        {
            $votes = [];

            $query = $this->_bdd->prepare("SELECT idVote FROM vote WHERE idFilm = ? AND idUser = ?");
            $query->execute(array($film->getIdFilm(), $user->getIdUser()));

            while ($donnees = $query->fetch(PDO::FETCH_ASSOC))
            {
                $votes[] = new Vote($donnees);
            }

            return $votes;
        }

        public function getId($idFilm, $idUser)
        {
            $query = $this->_bdd->prepare("SELECT idVote AS id FROM vote WHERE idFilm = ? AND idUser = ?");
            $query->execute(array($idFilm, $idUser));
            $result = $query->fetch();
            $result = intval($result['id']);
            return $result;
        }

        public function aVote($idFilm, $idUser)
        {
            $query = $this->_bdd->prepare("SELECT * FROM vote WHERE idFilm = ? AND idUser = ?");
            $query->execute(array($idFilm, $idUser));
            $result = $query->rowCount();
            return $result;
        }

    }      

?>