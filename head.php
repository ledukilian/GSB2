<?php
    $login = $_SESSION['login'];
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="style.css">
        <title>Laboratoire GSB</title>
    </head>
    <body>
        <div id="tete">
            Laboratoire GSB
        </div>
        <div id="navigation">
            <a href="compterendu.php"><div class="menu">Compte-rendu</div></a>
            <a href="visiteur.php"><div class="menu">Visiteur</div></a>
            <a href="praticien.php"><div class="menu">Praticien</div></a>
            <a href="medicament.php"><div class="menu">Médicament</div></a>
        </div>
        <div id="logo">
            <img src="logo.png" alt="Logo" width="auto" height="auto">
        </div>
        <div class="msg profil">
        <?php
            echo 'Bonjour <span class="profilnom">'.$login.'</span> !';
        ?>
<!--         <hr>
            <p>Prénom : Info</p>
            <p>Info 1 : Info</p>
            <p>Info 1 : Info</p>
            <p>Info 1 : Info</p> -->
        <hr>
<a href="profil.php"><button id="voirProfil">Voir votre profil</button></a>
<a href="deconnexion.php"><button id="deconnexion">Se déconnecter</button></a></th>
</div>