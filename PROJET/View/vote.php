<?php
    $title = "Voter";
    include("../View/header.php");

    if (isset($_GET['idFilm']))
    {
        $idFilm = $_GET['idFilm'];
        $donnees = $managerFilm->getByID($idFilm);

        $titre = $donnees->getTitre();
        $annee = $donnees->getAnnee();
        $score = $donnees->getScore();
        $vote = $donnees->getVote();
        $jacket = $donnees->getJacket();
    }
    else
    {
        $idFilm = null;
        $titre = null;
        $annee = null;
        $score = null;
        $vote = null;
        $jacket = null;
    }

    if(isset($_GET['idUser']))
    {
        $idUser = $_GET['idUser'];
        $donnees = $managerUser->getById($idUser);

        $nomUser = $donnees->getNomUser();
    }
    else
    {
        $idUser = null;
        $nomUser = null;
    }
?>
        <p class="message"><b><?php echo $nomUser ?>, voulez-vous vraiment voter pour le film suivant ?</b></p>
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
                <a href="../View/film.php"><input type="button" value="Retour"></a><a href="../View/confirm_vote.php?idFilm=<?php echo $idFilm ?>&idUser=<?php echo $idUser ?>"><input type="button" value="Valider"></a>
            </div>
        </div>
    </body>
</html>
