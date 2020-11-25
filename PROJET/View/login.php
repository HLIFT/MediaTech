<?php
    $title = "Connexion";
    include("../View/header.php");

    @$login=$_POST["login"];
    @$pass=($_POST["pass"]);
    @$valider=$_POST["valider"];
    
    if(isset($valider)){
        $valid = $managerUser->valid($login, $pass);
        if(isset($_GET['erreur']))
        {
            if(count($valid)>0)
            {
                $_SESSION["user"]=$login;
                $_SESSION["connected"]=true;
                header("location:../index.php");
            }
        }
        else
        {
            if(count($valid)>0)
            {
                $_SESSION["user"]=$login;
                $_SESSION["connected"]=true;
                header("location:../index.php");
            }
            else
            {
                $isConnect=false;
                header("location:../View/login.php?erreur=1");
            }
        }
        
    }
?>
        <div class="div">
            <form method="post" action="">
                <h1>Connexion</h1>
                <p class="erreur">
                    <?php
                        if (isset($_GET['erreur']))
                        {
                            $err = $_GET['erreur'];
                            if($err == 1)
                            {
                                echo "Nom d'utilisateur ou mot de passe incorrect";
                            }
                        }
                    ?>
                </p>
                <input type="text" name="login" placeholder="Nom d'utilisateur" required/><br />
                <input type="password" name="pass" placeholder="Mot de passe" required/><br />
                <input type="submit" name="valider" value="Se connecter" />
                <br>
                <br>
                <p>Pas encore inscrit ?</p>
                <a href="../View/inscription.php"><input type="button" value="S'inscrire"></a>
            </form>
        </div>
   </body>
</html>
