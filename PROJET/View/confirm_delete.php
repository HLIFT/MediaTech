<?php

    include("../View/header.php");

    if (isset($_GET['idFilm']))
    {
        $id = $_GET['idFilm'];
        $donnees = $managerFilm->getByID($id);
        //var_dump($donnees);

        $titre = $donnees->getTitre();
        $annee = $donnees->getAnnee();
        $score = $donnees->getScore();
        $vote = $donnees->getVote();
    }
    else
    {
        $id = null;
        $titre = null;
        $annee = null;
        $score = null;
        $vote = null;
    }

    if (isset($_GET['idActeur']))
    {
        $id = $_GET['idActeur'];
        $donnees = $managerActeur->getById($id);

        $prenom = $donnees->getPrenom();
        $nom = $donnees->getNom();
    }
    else
    {
        $id = null;
        $prenom = null;
        $nom = null;
    }

    if (isset($_GET['idFilm']))
    {
        
        $id = $_GET['idFilm'];

        $managerCasting->deleteByFilm($id);

        $film = new Film([
            'idFilm' => $id,
            'titre' => $titre,
            'annee' => $annee,
            'score' => $score,
            'nbVotants' => $vote
        ]);

        $managerFilm->delete($film);

        header("Location: ../film.php");
    }

    if (isset($_GET['idActeur']))
    {
        $id = $_GET['idActeur'];

        $managerCasting->deleteByActeur($id);
        
        $acteur = new Acteur([
            'idActeur' => $id,
            'prenom' => $prenom,
            'nom' => $nom
        ]);

        $managerActeur->delete($acteur);

        header("Location: ../acteur.php");
    }
?>