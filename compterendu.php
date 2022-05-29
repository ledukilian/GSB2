    <?php
    session_start();
    if (isset($_SESSION['login'])) {
        include 'head.php';
        require 'bdd.php';
        $bdd = getBdd();
        $stmt = $bdd->prepare("SELECT * FROM rapport_visite INNER JOIN visiteur ON rapport_visite.VIS_MATRICULE = visiteur.VIS_MATRICULE INNER JOIN praticien ON rapport_visite.PRA_NUM = praticien.PRA_NUM");
        $stmt->execute(); 
        $donnees = $stmt ->fetch();

        $compteur = 0;

        $tabRapNum = array();
        $tabRapBilan = array();
        $tabRapDate = array();
        $tabRapMotif = array();

        $tabPraNom = array();
        $tabPraPrenom = array();
        $tabVisNom = array();
        $tabVisPrenom = array();


        while($donnees = $stmt -> fetch())
            {
            // Conversion en ISO : Solution temporaire pour avoir les accents (bug UTF-8)
            $tabRapNum[$compteur] = mb_convert_encoding($donnees['RAP_NUM'], "UTF-8", "ISO-8859-1");
            $tabPraNom[$compteur] = mb_convert_encoding($donnees['PRA_NOM'], "UTF-8", "ISO-8859-1");
            $tabPraPrenom[$compteur] = mb_convert_encoding($donnees['PRA_PRENOM'], "UTF-8", "ISO-8859-1");
            $tabVisNom[$compteur] = mb_convert_encoding($donnees['VIS_NOM'], "UTF-8", "ISO-8859-1");
            $tabVisPrenom[$compteur] = mb_convert_encoding($donnees['Vis_PRENOM'], "UTF-8", "ISO-8859-1");

            
            // Toutes les vérifications puisque beaucoup de champs NULL
            if (is_null($donnees['RAP_BILAN'])) {
                $tabRapBilan[$compteur] = "Pas de bilan. (NULL)";
            } else {
                $tabRapBilan[$compteur] = mb_convert_encoding($donnees['RAP_BILAN'], "UTF-8", "ISO-8859-1");
            }

            if (is_null($donnees['RAP_DATE'])) {
                $tabRapDate[$compteur] = "Pas de date. (NULL)";
            } else {
                $tabRapDate[$compteur] = mb_convert_encoding($donnees['RAP_DATE'], "UTF-8", "ISO-8859-1");
            }

            if (is_null($donnees['RAP_MOTIF'])) {
                $tabRapMotif[$compteur] = "Pas de motif. (NULL)";
            } else {
                $tabRapMotif[$compteur] = mb_convert_encoding($donnees['RAP_MOTIF'], "UTF-8", "ISO-8859-1");
            }

            $compteur++;
            }   
        ?>

     <div id="page">
    <?php

    for($i = 0; $i <= count($tabRapNum)- 1;$i++){
    echo "  
    <div id = 'compterendu".($i + 1)."' class = 'lescompterendu'>
    <div class='col-sm-6 col-md-12'>
    <h1>Compte-rendu n°".$tabRapNum[$i]."</h1>
 <table class='table table-dark'>
  <tbody>
       <tr>
      <th>Numéro Rapport</th>
      <td>".$tabRapNum[$i]."</td>
    </tr>
    <tr>
      <th>Date</th>
      <td>".$tabRapDate[$i]."</td>
    </tr>
    <tr>
      <th>Praticien</th>
      <td>".$tabPraNom[$i]." ".$tabPraPrenom[$i]."</td>
    </tr>
    <tr>
      <th>Visiteur</th>
      <td>".$tabVisNom[$i]." ".$tabVisPrenom[$i]."</td>
    </tr>
    <tr>
      <th>Motif</th>
      <td>".$tabRapMotif[$i]."</td>
    </tr>
    <tr>
      <th>Bilan</th>
      <td>".$tabRapBilan[$i]."</td>
    </tr>
  </tbody>
</table>
<br>
</div>
</div>
";}?>
</div>

<div id="mininavigation">
        <form>
         <div class="form-group">
    <label for="exampleFormControlSelect1">Liste des Compte-rendu :</label>
    <select id ="listeCompteRendu" class="form-control" >
      <?php
       for($i = 0; $i <= count($tabRapNum)- 1;$i++){
        echo "<option id = ".($i+1).">"."[".$tabRapNum[$i]."] : ".$tabVisNom[$i]." ".$tabVisPrenom[$i]."</option>";
       }
      ?>
         </select>
         <button type="button" class="btn btn-outline-primary" onclick="update()">Valider</button>
    </div>
    </form>
    <button onclick="Precedent()" style="width: 100px;">Précédent</button>
    <a href="index.php"><button>Fermer</button></a>
    <button onclick="Suivant()" style="width: 100px;">Suivant</button>
</div>

<?php
if (isset($_POST['suppression'])) {
        // $bdd = getBdd();
        // $stmt = $bdd->prepare("DELETE FROM rapport_visite WHERE RAP_NUM='".$tabRapNum[$i]."'");
        // $stmt->execute();
        // header('Location:compterendu.php');
        // exit();
}
?>

<div id="admin" style="top: 64%;">
  <span class="profilnom">Administration</span>
  <hr>
   <form action="compterendu.php" method="post">
      <input type="submit" value="Supprimer ce compte-rendu"  id="deconnexion" name="suppression">
    </form>
    <form action="compterendu.php" method="post">
      <input type="submit" value="Ajouter un compte-rendu"  id="unboutonvert" name="ajouter">
    </form>
</div>

<script>
function Suivant() {
    if (i == nbMax){
        i= 1;
        var msg = "compterendu" + i;
        var oldMsg = "compterendu" + nbMax;
    }else{
        var msg = "compterendu" + (i+1);
        var oldMsg = "compterendu" + i;
        increment();
    }
    document.getElementById(oldMsg).style.display = "none";
    document.getElementById(msg).style.display = "initial";
}

function Precedent() {
    if (i == 1){
        i= nbMax;
        var msg = "compterendu" + i;
        var oldMsg = "compterendu" + 1;
    }else{
        var msg = "compterendu" + (i-1);
        var oldMsg = "compterendu" + i;
        deincrement();
    }
    document.getElementById(oldMsg).style.display = "none";
    document.getElementById(msg).style.display = "initial";
 }

function increment(){
    if (i > nbMax){
        i = 1;}
    else{
        i++;
    }   }

function deincrement(){
    if (i < 1){
        i = nbMax;}
    else{
        i--;
     }  }

function update(){
  var select = document.getElementById("listeCompteRendu");
  var valeur = select.options[select.selectedIndex].id ;

  var msg = "compterendu" + valeur;
  var oldMsg = "compterendu" + i;
  i = valeur ;

    document.getElementById(oldMsg).style.display = "none";
    document.getElementById(msg).style.display = "initial"; 
}

</script>
<script type="text/javascript">
    var nbMax = <?php echo json_encode(count($tabRapNum)); ?>;
    var i = 1
    var msg = "";
    for (pas = 2; pas < nbMax+1; pas++) {
        msg = "compterendu" + pas;
        document.getElementById(msg).style.display = "none";
        msg = "";
    }
</script>
</body>
</html>
<?php
include 'foot.php';
} else {
    header('Location:connexion.php');
    exit();
}
?>