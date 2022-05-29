<?php
// Connexion à la base de données
	// 'Hôte', 'Utilisateur', 'Mot de passe'
// $hote = "localhost";
// $user = "root";
// $pass = "root";
// $bdd = "movedb";

// $connexion = new mysqli($hote, $user, $pass, $bdd);

/*
if ($connexion->connect_error) {
    die("Erreur de connexion :" . $connexion->connect_error);
} 
echo "Connexion réussie !";

*/

function escape($valeur)
{
    return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8', false);
}

function getBdd() {
	//$host = 'localhost';
	//$bdd = 'gsb2';
	$user = 'root'; 
	$pass = 'root';
    return new PDO('mysql:host=localhost;dbname=gsb2;charset = utf8', $user, $pass);
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}

?>