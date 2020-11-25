<?php
    class BddConnectionManager
    {
        private $_bdd;

        // ----- Constructeur ----- //

        function __construct($host, $user, $pwd, $base) 
        {
            $this->_bdd = new PDO('mysql:host='.$host.';dbname='.$base.';charset=utf8',$user,$pwd);
        }

        function getBdd()
        {
            return $this->_bdd;
        }

    }
?>

