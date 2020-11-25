<?php
    class Film
    {
        private $_idFilm;
        private $_titre;
        private $_annee;
        private $_score;
        private $_vote;
        private $_jacket;

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

        function getIdFilm()
        {
            return $this->_idFilm;
        }

        function getTitre()
        {
            return $this->_titre;
        }

        function getAnnee()
        {
            return $this->_annee;
        }

        function getScore()
        {
            return $this->_score;
        }

        function getVote()
        {
            return $this->_vote;
        }

        function getJacket()
        {
            return $this->_jacket;
        }

        // ----- Setters ----- //

        function setIdFilm($id)
        {
            $id = (int) $id;

            if ($id > 0)
            {
                $this->_idFilm = $id;
            }
        }

        function setTitre($titre)
        {
            if (is_string($titre))
            {
                $this->_titre = $titre;
            }
        }

        function setAnnee($annee)
        {
            $annee = (int) $annee;
            if (($annee >= 0) && ($annee <= (date('Y')+5)))
            {
                $this->_annee = $annee;
            }
        }

        function setScore($score)
        {
            $score = (float) $score;
            if (($score >= 0) && ($score <= 10))
            {
                $this->_score = $score;
            }
        }

        function setNbVotants($vote)
        {
            $vote = (int) $vote;
            if ($vote >= 0)
            {
                $this->_vote = $vote;
            }
        }

        function setJacket($jacket)
        {
            if(is_string($jacket))
            {
                $this->_jacket = $jacket;
            }
        }

    }
?>