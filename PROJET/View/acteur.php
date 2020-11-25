<?php
    $title = "Acteurs";
    include("../View/header.php");
?>

        <div class="div2">
            <h1><b>Liste des acteurs :</b></h1>

            <div class="btn-align">
                <a href="../index.php"><input type="button" value="Accueil"></a>
                <a href="../View/film.php"><input type="button" value="Liste des films"></a>
                <a href="session.php?modif=add_acteur"><input type="button" value="Ajouter un acteur"></a>
            </div> 

            <table>
                <tr>
                <th></th>
                <th>ID de l'acteur</th>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Films dans lesquels il a joué</th>
                <th>Modifier</th>
                </tr>

                <?php
                    $donneesActeur = $managerActeur->getActors();

                    foreach ($donneesActeur as $acteur)
                    {
                        $donnees = $managerFilm->getFilmsWithActor($managerActeur->getByID($acteur['idActeur']));
                        $donneesFilm = $donnees;

                        echo '<tr>';
                        echo '<td><img src="'.$acteur['photo'].'" alt="Photo" class ="img"/></td>';
                        echo '<td>'.$acteur['idActeur'].'</td>';
                        echo '<td>'.$acteur['prenom'].'</td>';
                        echo '<td>'.$acteur['nom'].'</td>';

                        if ($donneesFilm != null)
                        {
                            echo '<td>';

                            foreach($donneesFilm as $film)
                            {
                                echo $film->getTitre().'<br>';
                            }

                            echo'</td>';
                        }
                        else
                        {
                            echo '<td></td>';
                        }
                ?>
                        <td>
                            <a href = "session.php?idActeur=<?=$acteur['idActeur']?>&amp;modif=edit_acteur"><input type = "button" value = "Modifier"></a>
                            <a href = "session.php?idActeur=<?=$acteur['idActeur']?>&amp;modif=delete_acteur"><input type = "button" value = "Supprimer"></a>
                        </td>
                <?php
                        echo '<tr>';
                    }
                ?>
            </table> 

            <div class="btn-align">
                <a href="../index.php"><input type="button" value="Accueil"></a>
                <a href="../View/film.php"><input type="button" value="Liste des films"></a>
                <a href="session.php?modif=add_acteur"><input type="button" value="Ajouter un acteur"></a>
            </div>   
        </div>
    </body>
</html>
