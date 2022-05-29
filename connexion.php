<?php
    // METHODE DU TP
    // NON FONCTIONNEL
    // if (isset($_POST['login']) && isset($_POST['password'])) {
    //     echo '<div class="msg">On arrive dans le POST</div>';
    //     require 'fonctions.php';
    //     $bdd = getBdd();
        
    //     $login = htmlspecialchars($_POST["login"]);
    //     $pass = htmlspecialchars($_POST["mdp"]);
                 
    //     $query = $bdd -> prepare("SELECT * FROM visiteur WHERE VIS_NOM = :login");
    //     $query -> BindParam(':login',$login);
    //     $query->execute();
                
    //     while ($donnees = $query->fetch()) {               
    //         if( $login == $donnees['VIS_NOM'] && $pass== $donnees["VIS_DATEEMBAUCHE"]){
    //             session_start();  // démarrage d'une session

    //                 $_SESSION['login'] = $_POST['login'];
    //                 $_SESSION['pwd'] = $_POST['mdp'];
                        
    //                 header('Location:index.php'); 
    //                 } else {
    //                     echo "<script> alert('Erreur') </script>";
    //                     echo "<h1>Erreur</h1>";
    //                 }
    //             }
    //     }

if (isset($_POST['connexion'])) {
    include 'bdd.php';
    $bdd = getBdd();

        $login = htmlspecialchars($_POST["login"]);
        $pass = htmlspecialchars($_POST["mdp"]);

        $query = $bdd -> prepare("SELECT * FROM visiteur WHERE VIS_NOM = :login");
        $query -> BindParam(':login', $login);
        $query -> execute();

        while ($donnees = $query -> fetch()) {
            if ($login == $donnees['VIS_NOM'] && $pass == $donnees["VIS_DATEEMBAUCHE"]) {
                session_start();

                $_SESSION['login'] = $_POST['login'];
                $_SESSION['pass'] = $_POST['mdp'];

                header('Location:index.php');
            }
        }
}

session_start();  // démarrage d'une session
if (isset($_SESSION['login'])) {
    header('Location:index.php');
    exit();
    } else {
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="style.css">
        <title>Connexion</title>    
    </head>
    <body>
        <div id="tete">
            Laboratoire GSB
        </div> 
        <div id="connexion">
        <h1>Connexion</h1>
        <form action="connexion.php" method="post">
            <label>Nom d'utilisateur :</label>
            <input type="text" name="login" class="champ" /><br /><br />
            <label>Mot de passe :</label>
            <input type="password" name="mdp" class="champ" />
            <br /><br />
            <input type="submit" value="Connexion" name="connexion">
        </form>
        <br />
        <!-- <a href="index.php">Retour à l'index</a> -->
        </div>
<?php include 'foot.php';
} ?>