<?php
    session_start();
    
    function chargerModel($class)
    {
        if (is_file('../Model/'.$class.'.class.php'))
        {
        
            require '../Model/'.$class.'.class.php';
        }
        else if (is_file('./Model/'.$class.'.class.php'))
        {
            require './Model/'.$class.'.class.php';
        }
    }

    function chargerController($class)
    {
        if (is_file('../Controller/'.$class.'.class.php'))
        {
            require '../Controller/'.$class.'.class.php';
        }
        else if (is_file('./Controller/'.$class.'.class.php'))
        {
            require './Controller/'.$class.'.class.php';
        }
    }

    spl_autoload_register('chargerModel');
    spl_autoload_register('chargerController');

    

    $bdd = new BddConnectionManager('localhost', 'root', '', 'php');

    $managerFilm = new FilmManager($bdd->getBdd());
    $managerActeur = new ActeurManager($bdd->getBdd());
    $managerCasting = new CastingManager($bdd->getBdd());
    $managerUser = new UserManager($bdd->getBdd());
    $managerVote = new VoteManager($bdd->getBdd());

    $current_dir = getcwd();
    $current_dir = str_replace("\\", "/", $current_dir); // Utilisateurs de Windows, pensez à changer vos antislashes

    $path = $current_dir;
    $file = basename($path);

    if(isset($_SESSION["connected"]))
    {
        $isConnect = true;
        $user = $_SESSION["user"];
        $idUser = $managerUser->getId($user);
    }
    else
    {
        $isConnect = false;
        $user = null;
        $idUser = null;
    }

    if ($file == "PROJET")
    {
    ?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title?></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="./Style/design.css">
        <link rel="icon" type="image/png" href="./Style/onglet.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
        <meta charset="UTF-8">
    </head>
    <body>
        <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light nav">
            <a class="navbar-brand nav-text" href="./index.php">
              <img src="./Style/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
              MediaTech
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link nav-text" href="./index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link nav-text" href="./View/film.php">Films</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link nav-text" href="./View/acteur.php">Acteurs</a>
                </li>
              </ul>
              <?php
                if($isConnect != true)
                {  
                    echo '<a href="./View/login.php" class="btn btn-outline-success my-2 my-sm-0 connect">Se connecter<img src="./Style/bonhomme.png" class="icone-connect" alt="icone-connect"></a>';
                }
                else
                {
                    $user = $_SESSION["user"];
                    echo '<p class="my-2 my-sm-0 ctq nav-text">Connecté en tant que :</p>';
                    echo '<a class="nav-link nav-text compte" href="./View/user.php?idUser='.$idUser.'">'.$user.'</a>';
                    echo '<a href="./View/session.php?modif=deconnexion" class="btn btn-outline-success my-2 my-sm-0 connect">Se déconnecter<img src="./Style/logout.png" class="icone-connect" alt="icone-connect"></a>';
                }
              ?>
            </div>
          </nav>
          </div>

<?php
    }

    else
    {
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title?></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="../Style/design.css">
        <link rel="icon" type="image/png" href="../Style/onglet.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
        <meta charset="UTF-8">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light nav">
            <a class="navbar-brand nav-text" href="../index.php">
            <img src="../Style/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            MediaTech
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <a class="nav-link nav-text" href="../index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link nav-text" href="../View/film.php">Films</a>
                </li>
                <li class="nav-item">
                <a class="nav-link nav-text" href="../View/acteur.php">Acteurs</a>
                </li>
            </ul>
            <?php
                if($isConnect != true)
                {  
                    echo '<a href="../View/login.php" class="btn btn-outline-success my-2 my-sm-0 connect">Se connecter<img src="../Style/bonhomme.png" class="icone-connect" alt="icone-connect"></a>';
                }
                else
                {
                    $user = $_SESSION["user"];
                    echo '<p class="my-2 my-sm-0 ctq nav-text">Connecté en tant que :</p>';
                    echo '<a class="nav-link nav-text compte" href="../View/user.php?idUser='.$idUser.'">'.$user.'</a>';
                    echo '<a href="../View/session.php?modif=deconnexion" class="btn btn-outline-success my-2 my-sm-0 connect">Se déconnecter<img src="../Style/logout.png" class="icone-connect" alt="icone-connect"></a>';
                }
              ?>
            </div>
        </nav>

<?php
    }
?>
