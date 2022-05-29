<?php
session_start();
if (isset($_SESSION['login'])) {
   	include 'head.php';
	require 'bdd.php';
        $bdd = getBdd();
        $stmt = $bdd->prepare("SELECT * FROM visiteur WHERE VIS_NOM='".$_SESSION['login']."'");
        $stmt->execute(); 
        $donnees = $stmt ->fetch();

        $Matricule = $donnees['VIS_MATRICULE'];
        $Nom = mb_convert_encoding($donnees['VIS_NOM'], "UTF-8", "ISO-8859-1");
        $Prenom = mb_convert_encoding($donnees['Vis_PRENOM'], "UTF-8", "ISO-8859-1");
        $Adresse = mb_convert_encoding($donnees['VIS_ADRESSE'], "UTF-8", "ISO-8859-1");
        $CodePostal = mb_convert_encoding($donnees['VIS_CP'], "UTF-8", "ISO-8859-1");
        $Ville = mb_convert_encoding($donnees['VIS_VILLE'], "UTF-8", "ISO-8859-1");
        $DateEmbauche = mb_convert_encoding($donnees['VIS_DATEEMBAUCHE'], "UTF-8", "ISO-8859-1");

			if (is_null($donnees['SEC_CODE'])) {
                $CodeSecteur = "Pas de secteur. (NULL)";
            } else {
                $CodeSecteur = mb_convert_encoding($donnees['SEC_CODE'], "UTF-8", "ISO-8859-1");
            }


        $CodeLabo = mb_convert_encoding($donnees['LAB_CODE'], "UTF-8", "ISO-8859-1");




?>
<div id="page">
<h1>Votre Profil</h1>
<hr>
<table>
	<tr>
		<th>Matricule</th>
		<td><?php echo $Matricule; ?></td>
	</tr>
	<tr>
		<th>Nom</th>
		<td><?php echo $Nom; ?></td>
	</tr>
	<tr>
		<th>Prenom</th>
		<td><?php echo $Prenom; ?></td>
	</tr>
	<tr>
		<th>Adresse</th>
		<td><?php echo $Adresse; ?></td>
	</tr>
	<tr>
		<th>Code Postal</th>
		<td><?php echo $CodePostal; ?></td>
	</tr>
	<tr>
		<th>Ville</th>
		<td><?php echo $Ville; ?></td>
	</tr>
	<tr>
		<th>Date Embauche</th>
		<td><?php echo $DateEmbauche; ?></td>
	</tr>
	<tr>
		<th>Code Secteur</th>
		<td><?php echo $CodeSecteur; ?></td>
	</tr>
	<tr>
		<th>Code Labo</th>
		<td><?php echo $CodeLabo; ?></td>
	</tr>
</table>
<hr>
<?php
if (isset($_POST['suppression'])) {
	echo 
	'<div id="mininavigation">
		<form action="profil.php" method="post">
		    <input type="submit" id="deconnexion" value="Confirmer la suppression" name="suppressionfin">
		</form>
	</div';
}

if (isset($_POST['suppressionfin'])) {
        $bdd = getBdd();
        $stmt = $bdd->prepare("DELETE FROM visiteur WHERE VIS_NOM='".$_SESSION['login']."'");
        $stmt->execute();
        header('Location:deconnexion.php');
    	exit();
}
?>
    <a href="index.php"><button>Fermer</button></a>
</div>

<div id="admin" style="top: 53%;">
	<span class="profilnom">Administration</span>
	<hr>
	<form action="profil.php" method="post">
	    <input type="submit" value="Supprimer mon profil"  id="deconnexion" name="suppression">
	</form>
</div>

<?php
include 'foot.php';
} else {
    header('Location:connexion.php');
    exit();
}
?>