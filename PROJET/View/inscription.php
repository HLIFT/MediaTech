<?php
    $title = "Inscription";
    include("../View/header.php");

    @$nom=$_POST["nom"];
    @$pass=$_POST["pass"];
    @$repass=$_POST["repass"];
    @$valider=$_POST["valider"];

    if(isset($valider)){
        if($pass!=$repass) header("location:../View/inscription.php?erreur=1");
        else
        {
            $exist = $managerUser->exist($nom);

            if (isset($_GET['erreur']))
            {
                if(count($exist)>0)
                {
                    header("location:../View/inscription.php?erreur=2");
                }

                else
                {
                    $newUser = new User([
                        'nomUser' => $nom,
                        'pasUser' => $pass
                    ]);
        
                    $managerUser->add($newUser);

                    header("location:../View/login.php");
                }
            }

            else
            {
                if(count($exist)>0)
                {
                    header("location:../View/inscription.php?erreur=2");
                }
    
                else
                {
                    $newUser = new User([
                        'nomUser' => $nom,
                        'passUser' => $pass
                    ]);

                    $managerUser->add($newUser);
                    
                    header("location:../View/login.php");
                }   
            } 
        }
    }
?>
      <div class="div">
            <form method="post" action="">
                <h1>Inscription</h1>
                <p class="erreur">
                    <?php
                        if (isset($_GET['erreur']))
                        {
                            $err = $_GET['erreur'];
                            if($err == 1)
                            {
                                echo "Les mots de passe sont différents";
                            }
                            else if($err == 2)
                            {
                                echo "Le nom d'utilisateur est déjà prit";
                            }
                        }
                    ?>
                </p>
                <input type="text" name="nom" placeholder="Nom d'utilisateur" required/><br />
                <input type="password" name="pass" placeholder="Mot de passe" required/><br />
                <input type="password" name="repass" placeholder="Confirmer Mot de passe" required/><br />
                <input type="submit" name="valider" value="S'inscrire" />
                <br>
                <br>
                <p>Vous avez déjà un compte ?</p>
                <a href="../View/login.php"><input type="button" value="Se connecter"></a>
            </form>
        </div>
   </body>
</html>
