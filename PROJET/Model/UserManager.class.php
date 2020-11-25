<?php

    class UserManager
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

            $query = $this->_bdd->prepare("SELECT * FROM user WHERE idUser = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new User($donnees);
        }

        public function add(User $user)
        {
            $query = $this->_bdd->prepare("INSERT INTO user(nomUser, passUser) VALUES(?, ?)");
            $query->execute(array($user->getNomUser(), $user->getPassUser()));

            $user->hydrate([
                'idUser' => $this->_bdd->lastInsertId(),
                'nomUser' => $user->getNomUser(),
                'passUser' => $user->getPassUser()
            ]);
        }

        public function update(User $user)
        {
            $query = $this->_bdd->prepare("UPDATE user SET nomUser = ?, passUser = ? WHERE idUser = ?");
            $query->execute(array($user->getNomUser(), $user->getPassUser(), $user->getIdUser()));
        }

        public function delete(User $user)
        {
            $query = $this->_bdd->prepare("DELETE FROM user WHERE idUser = ?");
            $query->execute(array($user->getIdUser()));
        }

        public function valid($nomUser, $passUser)
        {
            $query = $this->_bdd->prepare("SELECT * FROM user WHERE nomUser = ? AND passUser = ? LIMIT 1");
            $query->execute(array($nomUser, $passUser));
            $result = $query->fetchAll();
            return $result;
        }

        public function exist($nomUser)
        {
            $query = $this->_bdd->prepare("SELECT * FROM user WHERE nomUser = ? LIMIT 1");
            $query->execute(array($nomUser));
            $result = $query->fetchAll();
            return $result;
        }

        public function getId($nomUser)
        {
            $query = $this->_bdd->prepare("SELECT idUser AS id FROM user WHERE nomUser = ? LIMIT 1");
            $query->execute(array($nomUser));
            $result = $query->fetch();
            $result = intval($result['id']);
            return $result;
        }

    }      

?>