<?php
    if (isset($_POST['Valider']))
    {
        header("Location: ../View/acteur.php");
    }

    $title = "Modifier acteur";
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

    if(isset($_POST['prenom']))
    {
        $prenom = (is_string($_POST['prenom']) && $_POST['prenom'] != '') ? $_POST['prenom'] : false;
        $nom = (is_string($_POST['nom']) && $_POST['nom'] != '') ? $_POST['nom'] : false;
        $film = $_POST['film'];
        $filmSupp = $_POST['filmSupp'];

        if($prenom && $nom && $film == null && $filmSupp == null)
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

            if(basename($_FILES['fichier']['name'])!='')
            {
                $photo = '../Style/Photos/'.basename($_FILES['fichier']['name']);
            }

            $newActeur = new Acteur([
                'idActeur' => $id,
                'prenom' => $prenom,
                'nom' => $nom,
                'photo' => $photo
            ]);

            $managerActeur->update($newActeur);           
        }

        elseif ($prenom && $nom && $film != null || $filmSupp != null)
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

            if(basename($_FILES['fichier']['name'])!='')
            {
                $photo = '../Style/Photos/'.basename($_FILES['fichier']['name']);
            }

            $newActeur = new Acteur([
                'idActeur' => $id,
                'prenom' => $prenom,
                'nom' => $nom,
                'photo' => $photo
            ]);

            $managerActeur->update($newActeur);

            if (isset($_POST['film']))
            {
                foreach($film as $donnees)
                {
                    $filmID = (int) $donnees;

                    if($managerFilm->getById($filmID) != null)
                    {   
                        $newCast = new Casting([
                            'idFilm' => $filmID,
                            'idActeur' => $id
                        ]);
                    
                        $managerCasting->add($newCast);
                    }

                }
            }
            
            if (isset($_POST['filmSupp']))
            {
                foreach($filmSupp as $donnees)
                {
                    $filmSuppID = (int) $donnees;

                    if($managerFilm->getById($filmSuppID) != null)
                    {
                        $idCast = $managerCasting->getId($filmSuppID, $id);

                        $cast = new Casting([
                            'idCast' => $idCast,
                            'idFilm' => $filmSuppID,
                            'idActeur' => $id
                        ]);
                        
                        $managerCasting->delete($cast);
                    }   
                }
            }
        }
    }
?>
        <div class="div3">

            <form action="" method="post" enctype="multipart/form-data">
                <h1><b>Modifier l'acteur n°<?php echo $id?> :</b></h1>

                <input type='text' name='prenom' value="<?php echo $prenom ?>" required>
                <input type='text' name='nom' value="<?php echo $nom?>" required>
                <p>Ajouter un ou plusieurs film(s) à l'acteur :</p>
                <select name='film[]' multiple>
                    <option value=""></option>;
                    <?php
                        $films = $managerFilm->getFilms();
                        $films_acteur = array();
                        $donnees = $managerFilm->getFilmsActor($id);

                        foreach($donnees as $da)
                        {
                            $films_acteur[] = $da['idFilm'];
                        }

                        foreach($films as $film)
                        {
                            if(in_array($film['idFilm'], $films_acteur) == false)
                            {
                            ?>
                                <option value="<?php echo $film['idFilm']?>"><?php echo $film['idFilm'].' - '.$film['titre'] ?></option>
                            <?php
                            }
                        }
                    ?>  
                </select>
                <p>Supprimer un ou plusieurs film(s) à l'acteur :</p>
                <select name='filmSupp[]' multiple>
                    <option value=""></option>;
                    <?php
                        $donnees = $managerFilm->getFilmsActor($id);

                        foreach($donnees as $film)
                        {
                    ?>
                        <option value="<?php echo $film['idFilm']?>"><?php echo $film['idFilm'].' - '.$film['titre'] ?></option>
                    <?php
                        }
                    ?>  
                </select>

                <p>Modifier la photo de l'acteur :</p>
                <input type="hidden"  name="MAX_FILE_SIZE" value="1048576" />
                <input type="file" name="fichier" />

                <br>

                <a href="../View/acteur.php"><input type="button" value="Retour"></a>
                <input type='submit' name='Valider' value='Valider'>

                <br>
                <br>
            </form>
        </div>
    </body>
</html>

