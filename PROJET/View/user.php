<?php
    $title = "Gestion du compte";
    include("../View/header.php");

    if (isset($_GET['idUser']))
    {
        $idUser = $_GET['idUser'];
        $donnees = $managerUser->getByID($idUser);

        $nomUser = $donnees->getNomUser();
        $passUser = $donnees->getPassUser();

    }
    else
    {
        $idUser = null;
        $nomUser = null;
        $passUser = null;
    }
?>
        <p class="message"><b>Gestion du compte</b></p>

            <div class="del">
                <br>
                <b>Utilisateur :</b> <?php echo $nomUser ?><br>
                <br>
                <b>Mot de passe :</b> <a href="../View/change_mdp.php?idUser=<?php echo $idUser ?>"><input class="change-mdp" type="button" value="Changer Mot de Passe"></a>
                <br>
            </div>
            <div class="div2">
                <p><b>Les films pour lesquels vous avez voté :</b></p>
                <br>
                <table>
                    <tr>
                        <th>Jacket</th>
                        <th>ID du film</th>
                        <th>Titre</th>
                        <th>Année de parution</th>
                        <th>Score</th>
                        <th>Nombre de votants</th>
                        <th>Acteurs</th>
                    </tr>
                <?php
                    $donnees = $managerFilm->getFilmsUser($idUser);

                    foreach ($donnees as $film)
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
                        echo '<td>'.$film['nbVotants'].'</td>';

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

                        echo '</tr>';
                    }
                ?>
                </table>

                <br>
                <br>
                <div class="btn-align">
                    <a href="../index.php"><input type="button" value="Retour"></a>
                </div>
        </div>
    </body>
</html>
