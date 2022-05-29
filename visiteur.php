    <?php
    session_start();
    if (isset($_SESSION['login'])) {
        include 'head.php';
        require 'bdd.php';
        $bdd = getBdd();
        $stmt = $bdd->prepare("SELECT * FROM Visiteur");
        $stmt->execute(); 
        $donnees = $stmt ->fetch();

        $compteur = 0;

        $tabMat = array();
        $tabNom = array();
        $tabPrenom = array();
        $tabAdr = array();
        $tabVille = array();
        $tabSec = array();
        $tabLab = array();


        while($donnees = $stmt -> fetch())
            {
            // Conversion en ISO : Solution temporaire pour avoir les accents (bug UTF-8)

            $tabMat[$compteur] = mb_convert_encoding($donnees['VIS_MATRICULE'], "UTF-8", "ISO-8859-1");
            $tabNom[$compteur] = mb_convert_encoding($donnees['VIS_NOM'], "UTF-8", "ISO-8859-1");
            $tabPrenom[$compteur] = mb_convert_encoding($donnees['Vis_PRENOM'], "UTF-8", "ISO-8859-1");
            $tabAdr[$compteur] = mb_convert_encoding($donnees['VIS_ADRESSE'], "UTF-8", "ISO-8859-1");
            $tabComp[$compteur] = mb_convert_encoding($donnees['VIS_CP'], "UTF-8", "ISO-8859-1");
            $tabVille[$compteur] = mb_convert_encoding($donnees['VIS_VILLE'], "UTF-8", "ISO-8859-1");
            $tabLab[$compteur] = mb_convert_encoding($donnees['LAB_CODE'], "UTF-8", "ISO-8859-1");

            if (is_null($donnees['SEC_CODE'])) {
                $tabSec[$compteur] = "Pas de code secteur. (NULL)";
            } else {
                $tabSec[$compteur] = $donnees['SEC_CODE'];
            }

            $compteur++;
            }   
        ?>

      <div id="page">

   <?php

    for($i = 0; $i <= count($tabNom)- 1;$i++){
    echo "  
    <div id = 'visiteur".($i + 1)."' class = 'visiteur'>
    <div class='col-sm-6 col-md-12'>
    <h1>Visiteurs n°".($i + 1)."</h1>
 <table class='table table-dark'>
  <tbody>
       <tr>
      <th scope='row'>Nom</th>
      <td>".$tabNom[$i]."</td>
    </tr>
    <tr>
      <th scope='row'>Prénom</th>
      <td>".$tabPrenom[$i]."</td>
    </tr>

    <tr>
      <th scope='row'>Adresse</th>
      <td>".$tabAdr[$i]."</td>
    </tr>
    <tr>
      <th scope='row'>Code Postal</th>
      <td>".$tabComp[$i]."</td>
    </tr>
    <tr>
      <th scope='row'>Ville</th>
      <td>".$tabVille[$i]."</td>
    </tr>
    <tr>
      <th scope='row'>Secteur</th>
      <td>".$tabSec[$i]."</td>
    </tr>
    <tr>
      <th scope='row'>Labo</th>
      <td>".$tabLab[$i]."</td>
    </tr>
  </tbody>
</table>
<br>
</div>
</div>
";}?>

<div id="mininavigation">
      <form>
      
         <div class="form-group">
    <label for="exampleFormControlSelect1">Liste des Visiteurs :</label>
    <select id ="listeVisiteur" class="form-control" >
      <?php
       for($i = 0; $i <= count($tabNom)- 1;$i++){
        echo "<option id = ".($i+1).">".$tabNom[$i]."   ".$tabPrenom[$i]."</option>";


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
<script>
function Suivant() {
    if (i == nbMax){
      i= 1;
      var msg = "visiteur" + i;
      var oldMsg = "visiteur" + nbMax;
    }else{
      var msg = "visiteur" + (i+1);
      var oldMsg = "visiteur" + i;
      increment();
    }
    document.getElementById(oldMsg).style.display = "none";
    document.getElementById(msg).style.display = "initial";
}

function Precedent() {
    if (i == 1){
      i= nbMax;
      var msg = "visiteur" + i;
      var oldMsg = "visiteur" + 1;
    }else{
      var msg = "visiteur" + (i-1);
      var oldMsg = "visiteur" + i;
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
  var select = document.getElementById("listeVisiteur");
  var valeur = select.options[select.selectedIndex].id ;

  var msg = "visiteur" + valeur;
  var oldMsg = "visiteur" + i;
  i = valeur ;

    document.getElementById(oldMsg).style.display = "none";
    document.getElementById(msg).style.display = "initial"; 
}

</script>
<script type="text/javascript">
  var nbMax = <?php echo json_encode(count($tabNom)); ?>;

  var i = 1
  var msg = "";
  for (pas = 2; pas < nbMax+1; pas++) {
    msg = "visiteur" + pas;
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