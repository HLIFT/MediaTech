<?php
    class Acteur
    {
        private $_idActeur;
        private $_prenom;
        private $_nom;
        private $_photo;
    
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

        // ------ Getters ----- //

        function getIdActeur()
        {
            return $this->_idActeur;
        }

        function getPrenom()
        {
            return $this->_prenom;
        }

        function getNom()
        {
            return $this->_nom;
        }

        function getPhoto()
        {
            return $this->_photo;
        }

        // ------ Setters ----- //

        function setIdActeur($id)
        {
            $id = (int) $id;

            if ($id > 0)
            {
                $this->_idActeur = $id;
            }
        }

        function setPrenom($prenom)
        {
            if (is_string($prenom))
            {
                $this->_prenom = $prenom;
            }
        }

        function setNom($nom)
        {
            if (is_string($nom))
            {
                $this->_nom = $nom;
            }
        }

        function setPhoto($photo)
        {
            if(is_string($photo))
            {
                $this->_photo = $photo;
            }
        }
    
    }

?>