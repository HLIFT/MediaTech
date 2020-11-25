<?php

    include("../View/header.php");

    if (isset($_GET['idFilm']))
    {
        $idFilm = $_GET['idFilm'];
        $donnees = $managerFilm->getByID($idFilm);
        //var_dump($donnees);

        $titre = $donnees->getTitre();
        $annee = $donnees->getAnnee();
        $score = $donnees->getScore();
        $nbVote = $donnees->getVote();
        $jacket = $donnees->getJacket();
    }
    else
    {
        $idFilm = null;
        $titre = null;
        $annee = null;
        $score = null;
        $nbVote = null;
        $jacket = null;
    }

    if (isset($_GET['idFilm']) && isset($_GET['idUser']))
    {
        
        $idFilm = $_GET['idFilm'];
        $idUser = $_GET['idUser'];

        $vote = new Vote([
            'idFilm' => $idFilm,
            'idUser' => $idUser
        ]);

        $managerVote->add($vote);

        $nbVote += 1;

        $film = new Film([
            'idFilm' => $idFilm,
            'titre' => $titre,
            'annee' => $annee,
            'score' => $score,
            'nbVotants' => $nbVote,
            'jacket' => $jacket
        ]);

        $managerFilm->update($film);

        header("Location: ../View/film.php");
    }
?>