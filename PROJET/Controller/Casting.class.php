<?php
    class Casting
    {
        private $_idCast;
        private $_idFilm;
        private $_idActeur;

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

        function getIdCast()
        {
            return $this->_idCast;
        }

        function getIdFilm()
        {
            return $this->_idFilm;
        }

        function getIdActeur()
        {
            return $this->_idActeur;
        }

        // ----- Setters ----- //

        function setIdCast($idCast)
        {
            $idCast = (int) $idCast;
            $this->_idCast = $idCast;
        }

        function setIdFilm($idFilm)
        {
            $idFilm = (int) $idFilm;
            $this->_idFilm = $idFilm;
        }

        function setIdActeur($idActeur)
        {
            $idActeur = (int) $idActeur;
            $this->_idActeur = $idActeur;
        }

    }
?>