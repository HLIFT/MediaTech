<?php
    $title = "Supprimer film";
    include("../View/header.php");

    if (isset($_GET['idActeur']))
    {
        $id = $_GET['idActeur'];
        $donnees = $managerActeur->getByID($id);

        $prenom = $donnees->getPrenom();
        $nom = $donnees->getNom();
        $photo = $donnees->getPhoto();
    }
    else
    {
        $id = null;
        $prenom = null;
        $nom = null;
        $photo = null;
    }
?>
        <p class="message"><b>Voulez-vous vraiment supprimer l'acteur suivant ?</b></p>
        <div class="div2">
            <div class="del">
                <br>
                <b>Prenom :</b> <?php echo $prenom ?><br>
                <b>Nom :</b> <?php echo $nom ?><br>
                <br>
                <img src="<?php echo $photo ?>" alt="Photo" class = "img"/>
                <br>
                <br>
                <a href="../View/acteur.php"><input type="button" value="Retour"></a><a href="../View/confirm_delete.php/?idActeur=<?php echo $id ?>"><input type="button" value="Valider">
            </div>
        </div>
    </body>
</html>
