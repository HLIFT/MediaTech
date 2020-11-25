<?php

    include("../View/header.php");

    if(isset($_GET["modif"]))
    {
        $modif = $_GET["modif"];

        if($isConnect == true)
        {
            if($modif == "add_film")
            {
                header("location:../View/add_film.php");
            }

            else if($modif == "add_acteur")
            {
                header("location:../View/add_acteur.php");
            }

            else if($modif == "deconnexion")
            {
                header("location: ../View/confirm_deco.php");
            }

            if(isset($_GET["idFilm"]))
            {
                $idFilm = $_GET["idFilm"];

                if($modif == "edit_film")
                {
                    header("location:../View/update_film.php?idFilm=".$idFilm);
                }

                else if($modif == "delete_film")
                {
                    header("location:../view/delete_film.php?idFilm=".$idFilm);
                }

                if(isset($_GET['idUser']))
                {
                    $idUser = $_GET['idUser'];

                    if($modif == 'vote')
                    {
                        $aVote = $managerVote->aVote($idFilm, $idUser);

                        if($aVote > 0)
                        {
                            header("location: ../View/vote_impossible.php?idFilm=".$idFilm."&idUser=".$idUser);
                        }
                        else
                        {
                            header("location: ../View/vote.php?idFilm=".$idFilm."&idUser=".$idUser);
                        }
                    }
                }
            }

            if(isset($_GET["idActeur"]))
            {
                $idActeur = $_GET["idActeur"];

                if($modif == "edit_acteur")
                {
                    header("location:../View/update_acteur.php?idActeur=".$idActeur);
                }

                else if($modif == "delete_acteur")
                {
                    header("location:../View/delete_acteur.php?idActeur=".$idActeur);
                }
            }
            
        }

        else
        {
            header("location:../View/impossible.php");
        }
    }

?>