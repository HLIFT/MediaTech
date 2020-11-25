<?php
    $title = "Films";
    include("../View/header.php");
?>
        <div class="div2">
            <h1><b>Liste des films :</b></h1>

            <div class="btn-align">
                <a href="../index.php"><input type="button" value="Accueil"></a><a href="../View/acteur.php"><input type="button" value="Liste des acteurs"></a><a href="session.php?modif=add_film"><input type="button" value="Ajouter un film"></a>
            </div>

            <table>
                <tr>
                    <th>Jacket</th>
                    <th>ID du film</th>
                    <th>Titre</th>
                    <th>Année de parution</th>
                    <th>Score</th>
                    <th>Nombre de votants</th>
                    <th>Acteurs</th>
                    <th>Modifier</th>
                </tr>

                <?php
                    $donneesFilm = $managerFilm->getFilms();

                    foreach ($donneesFilm as $film)
                    {
                        $donnees = $managerActeur->getActorIn($managerFilm->getByID($film['idFilm']));

                        $donneesActeur = $donnees;
                        $src = $film['jacket'];

                        echo '<tr>';
                        echo '<td><img src="'.$film['jacket'].'" alt="jacket" class ="img"/></td>';
                        echo '<td>'.$film['idFilm'].'</td>';
                        echo '<td>'.$film['titre'].'</td>';
                        echo '<td>'.$film['annee'].'</td>';
                        echo '<td>'.$film['score'].'</td>';
                        echo '<td>'.$film['nbVotants'].'<a href = "session.php?idFilm='.$film['idFilm'].'&modif=vote&idUser='.$idUser.'"><input type = "button" value = "Voter"></a></td>';

                        if ($donneesActeur != null)
                        {
                            echo '<td>';

                            foreach($donneesActeur as $acteur)
                            {
                                echo $acteur->getPrenom().' '.$acteur->getNom().'<br>';
                            }

                            echo'</td>';
                        }
                        else
                        {
                            echo '<td></td>';
                        }
                        ?>
                        <td>
                            <a href = "session.php?idFilm=<?=$film['idFilm']?>&modif=edit_film"><input type = "button" value = "Modifier"></a>
                            <a href = "session.php?idFilm=<?=$film['idFilm']?>&modif=delete_film"><input type = "button" value = "Supprimer"></a>
                        </td>
                <?php
                        echo '<tr>';
                    }
                ?>
            </table> 

            <div class="btn-align">
                <a href="../index.php"><input type="button" value="Accueil"></a>
                <a href="../View/acteur.php"><input type="button" value="Liste des acteurs"></a>
                <a href="session.php?modif=add_film"><input type="button" value="Ajouter un film"></a>
            </div>
        </div>
    </body>
</html>