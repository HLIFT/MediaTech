<?php
    class User
    {
        private $_idUser;
        private $_nomUser;
        private $_passUser;

        // ----- Constructeur ----- //

        public function __construct($donnees)
        {
            $this->hydrate($donnees);
        }

        // ----- Méthodes ----- //

        public function hydrate(array $donnees)
        {

            foreach ($donnees as $key => $value) // Chaque champ est lu
            {
                // On récupère le nom du setter correspondant à l'attribut de la classe.
                $method = 'set'.ucfirst($key);
                // Si le setter correspondant existe.
                if (method_exists($this, $method))
                {
                    // On appelle le setter.
                    $this->$method($value);
                }
            }
        }

        // ----- Getters ----- //

        public function getIdUser()
        {
            return $this->_idUser;
        }

        public function getNomUser()
        {
            return $this->_nomUser;
        }

        public function getPassUser()
        {
            return $this->_passUser;
        }

        // ----- Setters ----- //

        function setIdUser($id)
        {
            $id = (int) $id;

            if ($id > 0)
            {
                $this->_idUser = $id;
            }
        }

        function setNomUser($nom){
            if (is_string($nom))
            {
                $this->_nomUser = $nom;
            }
        }

        function setPassUser($pass){
            
            if (is_string($pass))
            {
                $this->_passUser = $pass;
            }
        }
    }

?>