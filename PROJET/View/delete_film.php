<?php
    $title = "Supprimer film";
    include("../View/header.php");

    if (isset($_GET['idFilm']))
    {
        $id = $_GET['idFilm'];
        $donnees = $managerFilm->getByID($id);

        $titre = $donnees->getTitre();
        $annee = $donnees->getAnnee();
        $score = $donnees->getScore();
        $vote = $donnees->getVote();
        $jacket = $donnees->getJacket();
    }
    else
    {
        $id = null;
        $titre = null;
        $annee = null;
        $score = null;
        $vote = null;
        $jacket = null;
    }
?>
        <p class="message"><b>Voulez-vous vraiment supprimer le film suivant ?</b></p>
        <div class="div2">
            <div class="del">
                <br>
                <b>Titre :</b> <?php echo $titre ?><br>
                <b>Année :</b> <?php echo $annee ?><br>
                <b>Score :</b> <?php echo $score ?><br>
                <b>Nombre de votes :</b> <?php echo $vote ?><br>
                <br>
                <img src="<?php echo $jacket ?>" alt="Jacket" class = "img"/>
                <br>
                <br>
                <a href="../View/film.php"><input type="button" value="Retour"></a><a href="../View/confirm_delete.php/?idFilm=<?php echo $id ?>"><input type="button" value="Valider"></a>
            </div>
        </div>
    </body>
</html>
