<?php
session_start();  // démarrage d'une session
if (isset($_SESSION['login'])) {
    include 'head.php';
?>




                <!-- Code HTML sur l'index -->



<?php   
    include 'foot.php';
    } else {
    header('Location:connexion.php');
    exit();
} ?>


