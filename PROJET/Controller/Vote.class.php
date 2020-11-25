<?php
    class Vote
    {
        private $_idVote;
        private $_idFilm;
        private $_idUser;

        // ----- Constructeur ----- //

        function __construct($donnees)
        {
            $this->hydrate($donnees);
        }

        // ----- Hydrate ----- //

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

        function getIdVote()
        {
            return $this->_idVote;
        }

        function getIdFilm()
        {
            return $this->_idFilm;
        }

        function getIdUser()
        {
            return $this->_idUser;
        }

        // ----- Setters ----- //

        function setIdVote($id)
        {
            $id = (int) $id;

            if ($id > 0)
            {
                $this->_idVote = $id;
            }
        }

        function setIdFilm($id)
        {
            $id = (int) $id;

            if ($id > 0)
            {
                $this->_idFilm = $id;
            }
        }

        function setIdUser($id)
        {
            $id = (int) $id;

            if ($id > 0)
            {
                $this->_idUser = $id;
            }
        }

    }
?>