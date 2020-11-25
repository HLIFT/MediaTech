<?php

    if (isset($_POST['Valider']))
    {
        header("Location: ../View/acteur.php");
    }

    $title = "Ajouter acteur";
    include("../View/header.php");

    if(isset($_POST['prenom']))
    {
        $prenom = (is_string($_POST['prenom']) && $_POST['prenom'] != '') ? $_POST['prenom'] : false;
        $nom = (is_string($_POST['nom']) && $_POST['nom'] != '') ? $_POST['nom'] : false;
        $film = $_POST['film'];

        if($prenom && $nom && $film == null)
        { 
            if (isset($_FILES['fichier']) &&
            $_FILES['fichier']['error'] == 0 &&
            $_FILES['fichier']['size'] <= 1 * 1024 * 1024) //Méga bytes
            {
                $infosfichier = pathinfo($_FILES['fichier']['name']);
                $ext_upload = $infosfichier['extension'];
                if (in_array($ext_upload, array('jpg','png', 'jpeg')))
                {
                    move_uploaded_file($_FILES['fichier']['tmp_name'], '../Style/Photos/'.basename($_FILES['fichier']['name']));
                }
            }

            $photo = '../Style/Photos/'.basename($_FILES['fichier']['name']);

            $newActeur = new Acteur([
                'idActeur' => $id,
                'prenom' => $prenom,
                'nom' => $nom,
                'photo' => $photo
            ]);

            $managerActeur->add($newActeur);
        }

        elseif ($prenom && $nom && $film != null)
        {
            if (isset($_FILES['fichier']) &&
            $_FILES['fichier']['error'] == 0 &&
            $_FILES['fichier']['size'] <= 1 * 1024 * 1024) //Méga bytes
            {
                $infosfichier = pathinfo($_FILES['fichier']['name']);
                $ext_upload = $infosfichier['extension'];
                if (in_array($ext_upload, array('jpg','png', 'jpeg')))
                {
                    move_uploaded_file($_FILES['fichier']['tmp_name'], '../Style/Photos/'.basename($_FILES['fichier']['name']));
                }
            }

            $photo = '../Style/Photos/'.basename($_FILES['fichier']['name']);

            $newActeur = new Acteur([
                'prenom' => $prenom,
                'nom' => $nom,
                'photo' => $photo
            ]);

            $managerActeur->add($newActeur);

            $id = $newActeur->getIdActeur();

            foreach($film as $donnees)
            {
                $filmID = (int) $donnees;

                if ($managerFilm->getById($filmID) != null)
                {
                    $newCast = new Casting([
                        'idFilm' => $filmID,
                        'idActeur' => $id
                    ]);
        
                    $managerCasting->add($newCast);
                }
            }
        }
    }
?>
        <div class="div">
            <form action="" method="post" enctype="multipart/form-data">
                <h1><b>Ajouter un acteur :</b></h1>

                <input type='text' name='prenom' placeholder="Prenom" required>
                <input type='text' name='nom' placeholder="Nom" required>
                <p>Ajouter un ou plusieurs film(s) à l'acteur :</p>
                <select name='film[]' multiple>
                    <option value=""></option>;
                    <?php
                        $donnees = $managerFilm->getFilms();

                        foreach($donnees as $film)
                        {
                    ?>
                    <option value="<?php echo $film['idFilm']?>"><?php echo $film['idFilm'].' - '.$film['titre'] ?></option>
                    <?php
                        }
                    ?>
                </select>

                <p>Ajouter une photo à l'acteur :</p>
                <input type="hidden"  name="MAX_FILE_SIZE" value="1048576" />
                <input type="file" name="fichier" />

                <a href="../View/acteur.php"><input type="button" value="Retour"></a>
                <input type='submit' name='Valider' value='Valider'>
                
                <br>
                
            </form>
        </div>
    </body>
</html>
