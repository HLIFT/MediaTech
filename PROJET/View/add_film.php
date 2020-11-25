<?php

    if (isset($_POST['Valider']))
    {
        header("Location: ../View/film.php");
    }

    $title = "Ajouter film";
    include("../View/header.php");

    if(isset($_POST['titre']))
    {
        $titre = (is_string($_POST['titre']) && $_POST['titre'] != '') ? $_POST['titre'] : false;
        $annee = (is_int((int)$_POST['annee'])) ? $_POST['annee'] : false;
        $score = (is_float((float)$_POST['score'])) ? $_POST['score'] : false;
        $vote = (is_int((int)$_POST['vote'])) ?  $_POST['vote'] : false;
        $acteur = $_POST['acteur'];

        if($titre && $annee && $score && $vote && $acteur == null)
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

            $jacket = '../Style/Jackets/'.basename($_FILES['fichier']['name']);

            $newFilm = new Film([
                'titre' => $titre,
                'annee' => $annee,
                'score' => $score,
                'nbVotants' => $vote,
                'jacket' => $jacket
            ]);

            $managerFilm->add($newFilm);            
        }

        elseif ($titre && $annee && $score && $vote && $acteur != null)
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

            $jacket = '../Style/Jackets/'.basename($_FILES['fichier']['name']);

            $newFilm = new Film([
                'titre' => $titre,
                'annee' => $annee,
                'score' => $score,
                'nbVotants' => $vote,
                'jacket' => $jacket
            ]);

            $managerFilm->add($newFilm);
            
            $id = $newFilm->getIdFilm();

            foreach($acteur as $donnees)
            {
                $acteurID = (int) $donnees;

                if($managerActeur->getById($acteurID))
                {
                    $newCast = new Casting([
                        'idFilm' => $id,
                        'idActeur' => $acteurID
                    ]);
        
                    $managerCasting->add($newCast);
                }
            }
        }

    }
?>
        
        <div class="div">
            <form action="" method="post" enctype="multipart/form-data">
                <h1><b>Ajouter un film :</b></h1>
                <input type='text' name='titre' placeholder="Titre" required>
                <input type='number' name='annee' placeholder="annee" required>
                <input type='number' name='score' step="0.1" placeholder="Score" required>
                <input type='number' name='vote' placeholder="Nombre de votants" required>
                <p>Ajouter un ou plusieurs acteur(s) au film :</p>
                <select name='acteur[]' multiple>
                    <option value=""></option>;
                    <?php

                    $donnees = $managerActeur->getActors();

                    foreach($donnees as $acteur)
                    {
                    ?>
                        <option value="<?php echo $acteur['idActeur']?>"><?php echo $acteur['idActeur'].' - '.$acteur['prenom'].' '.$acteur['nom'] ?></option>
                    <?php
                    }
                    ?>
                </select>

                <p>Ajouter une jacket au film :</p>
                <input type="hidden"  name="MAX_FILE_SIZE" value="1048576" />
                <input type="file" name="fichier" />

                <a href="../View/film.php"><input type="button" value="Retour"></a>
                <input type='submit' name='Valider' value='Valider'>

            </form>
        </div>
    </body>
</html>
