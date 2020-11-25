<?php
    if (isset($_POST['Valider']))
    {
        header("Location: ../View/film.php");
    }

    $title = "Modifier film";
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

    if(isset($_POST['titre']))
    {
        $titre = (is_string($_POST['titre']) && $_POST['titre'] != '') ? $_POST['titre'] : false;
        $annee = (is_int((int)$_POST['annee'])) ? $_POST['annee'] : false;
        $score = (is_float((float)$_POST['score'])) ? $_POST['score'] : false;
        $vote = (is_int((int)$_POST['vote'])) ?  $_POST['vote'] : false;
        $acteur = $_POST['acteur'];
        $acteurSupp = $_POST['acteurSupp'];

        if($titre && $annee && $score && $vote && $acteur == null && $acteurSupp == null)
        {
            if (isset($_FILES['fichier']) &&
            $_FILES['fichier']['error'] == 0 &&
            $_FILES['fichier']['size'] <= 1 * 1024 * 1024) //Méga bytes
            {
                $infosfichier = pathinfo($_FILES['fichier']['name']);
                $ext_upload = $infosfichier['extension'];
                if (in_array($ext_upload, array('jpg','png', 'jpeg')))
                {
                    move_uploaded_file($_FILES['fichier']['tmp_name'], '../Style/Jackets/'.basename($_FILES['fichier']['name']));
                }
            }

            if(basename($_FILES['fichier']['name'])!='')
            {
                $jacket = '../Style/Jackets/'.basename($_FILES['fichier']['name']);
            }

            $newFilm = new Film([
                'idFilm' => $id,
                'titre' => $titre,
                'annee' => $annee,
                'score' => $score,
                'nbVotants' => $vote,
                'jacket' => $jacket
            ]);

            $managerFilm->update($newFilm);
        }

        elseif ($titre && $annee && $score && $vote && $acteur != null || $acteurSupp != null)
        {
            if (isset($_FILES['fichier']) &&
            $_FILES['fichier']['error'] == 0 &&
            $_FILES['fichier']['size'] <= 1 * 1024 * 1024) //Méga bytes
            {
                $infosfichier = pathinfo($_FILES['fichier']['name']);
                $ext_upload = $infosfichier['extension'];
                if (in_array($ext_upload, array('jpg', 'png', 'jpeg')))
                {
                    move_uploaded_file($_FILES['fichier']['tmp_name'], '../Style/Jackets/'.basename($_FILES['fichier']['name']));
                }
            }

            if(basename($_FILES['fichier']['name'])!='')
            {
                $jacket = '../Style/Jackets/'.basename($_FILES['fichier']['name']);
            }

            $newFilm = new Film([
                'idFilm' => $id,
                'titre' => $titre,
                'annee' => $annee,
                'score' => $score,
                'nbVotants' => $vote,
                'jacket' => $jacket
            ]);

            $managerFilm->update($newFilm);

            if(isset($_POST['acteur']))
            {
                foreach($acteur as $donnees)
                {
                    $acteurID = (int) $donnees;

                    if($managerActeur->getById($acteurID) != null)
                    {
                        $newCast = new Casting([
                            'idFilm' => $id,
                            'idActeur' => $acteurID
                        ]);
            
                        $managerCasting->add($newCast);
                    }
                } 
            }

            if(isset($_POST['acteurSupp']))
            {
                foreach($acteurSupp as $donnees)
                {
                    $acteurSuppID = (int) $donnees;

                    if($managerActeur->getById($acteurSuppID) != null)
                    {
                        $idCast = $managerCasting->getId($id, $acteurSuppID);
    
                        $cast = new Casting([
                            'idCast' => $idCast,
                            'idFilm' => $id,
                            'idActeur' => $acteurSuppID
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
                <h1><b>Modifier le film n°<?php echo $id?> :</b></h1>
                <input type='text' name='titre' value="<?php echo $titre ?>" required>
                <input type='number' name='annee' value="<?php echo $annee?>" required>
                <input type='number' name='score' step="0.1" value="<?php echo $score?>" required>
                <input type='number' name='vote' value="<?php echo $vote?>" required>
                <p>Ajouter un ou plusieurs acteur(s) au film :</p>
                <select name='acteur[]' multiple>
                    <option value=""></option>;
                    <?php
                        $acteurs = $managerActeur->getActors();
                        $acteurs_film = array();
                        $donnees = $managerActeur->getActorsFilm($id);

                        foreach($donnees as $df)
                        {
                            $acteurs_film[] = $df['idActeur'];
                        }

                        foreach($acteurs as $acteur)
                        {
                            if(in_array($acteur['idActeur'], $acteurs_film) == false)
                            {
                            ?>
                                <option value="<?php echo $acteur['idActeur']?>"><?php echo $acteur['idActeur'].' - '.$acteur['prenom'].' '.$acteur['nom'] ?></option>
                            <?php
                            }
                        }
                    ?>  
                </select>
                <p>Supprimer un ou plusieurs acteur(s) au film :</p>
                <select name='acteurSupp[]' multiple>
                    <option value=""></option>;
                    <?php
                        $donnees = $managerActeur->getActorsFilm($id);

                        foreach($donnees as $acteur)
                        {
                    ?>
                        <option value="<?php echo $acteur['idActeur']?>"><?php echo $acteur['idActeur'].' - '.$acteur['prenom'].' '.$acteur['nom'] ?></option>
                    <?php
                        }
                    ?>  
                </select>
                <p>Modifier la jacket du film :</p>
                <input type="hidden"  name="MAX_FILE_SIZE" value="1048576" />
                <input type="file" name="fichier"/>
                
                <br>

                <a href="../View/film.php"><input type="button" value="Retour"></a>
                <input type='submit' name='Valider' value='Valider'>
                <br>
                <br>
            </form>
        </div>
    </body>
</html>
<?php

    
?>