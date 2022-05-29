    <?php
    session_start();
    if (isset($_SESSION['login'])) {
        include 'head.php';
        require 'bdd.php';
        $bdd = getBdd();
       $stmt = $bdd->prepare("SELECT * FROM praticien INNER JOIN type_praticien ON praticien.TYP_CODE =type_praticien.TYP_CODE");
        $stmt->execute(); 
        $donnees = $stmt ->fetch();

        $compteur = 0;

        $tabCode = array();
        $tabNom = array();
        $tabPrenom = array();
        $tabAdr = array();
        $tabVille = array();
        $tabCp = array();
        $tabCoef = array();
        $tabLab = array();


        while($donnees = $stmt -> fetch())
            {
            // Conversion en ISO : Solution temporaire pour avoir les accents (bug UTF-8)
            $tabCode[$compteur] = $donnees['PRA_NUM'];
            $tabNom[$compteur] = mb_convert_encoding($donnees['PRA_NOM'], "UTF-8", "ISO-8859-1");
            $tabPrenom[$compteur] = mb_convert_encoding($donnees['PRA_PRENOM'], "UTF-8", "ISO-8859-1");
            $tabAdr[$compteur] = mb_convert_encoding($donnees['PRA_ADRESSE'], "UTF-8", "ISO-8859-1");
            $tabCp[$compteur] = $donnees['PRA_CP'];
            $tabVille[$compteur] = $donnees['PRA_VILLE'];
            $tabCoef[$compteur] = $donnees['PRA_COEFNOTORIETE'];
            $tabLab[$compteur] = mb_convert_encoding($donnees['TYP_LIBELLE'], "UTF-8", "ISO-8859-1");
            $compteur++;
            }   
        ?>

      <div id="page">

    <?php

    for($i = 0; $i <= count($tabNom)- 1;$i++){
    echo "  
    <div id = 'Praticien".($i + 1)."' class = 'Praticien'>
    <div class='col-sm-6 col-md-12'>
    <h1>Praticien n°".($i + 1)."</h1>
 <table class='table table-dark'>
  <tbody>
       <tr>
      <th scope='row'>Code</th>
      <td>".$tabCode[$i]."</td>
    </tr>
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
      <th scope='row'>Ville</th>
      <td>".$tabVille[$i]."</td>
    </tr>
    <tr>
      <th scope='row'>Code Postal</th>
      <td>".$tabCp[$i]."</td>
    </tr>
    <tr>
      <th scope='row'>Coefficient Notoriété</th>
      <td>".$tabCoef[$i]."</td>
    </tr>
    <tr>
      <th scope='row'>Lieu D'excercice</th>
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
    <label for="exampleFormControlSelect1">Liste des Praticiens : </label>
    <select id ="listePraticien" class="form-control" >
      <?php
       for($i = 0; $i <= count($tabNom)- 1;$i++){
        echo "<option id = ".($i+1).">".$tabNom[$i]."   ".$tabPrenom[$i]."</option>";
       }
      ?>
         </select>
         <button type="button" onclick="update()">Valider</button>

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
        var msg = "Praticien" + i;
        var oldMsg = "Praticien" + nbMax;
    }else{
        var msg = "Praticien" + (i+1);
        var oldMsg = "Praticien" + i;
        increment();
    }
    document.getElementById(oldMsg).style.display = "none";
    document.getElementById(msg).style.display = "initial";
}

function Precedent() {
    if (i == 1){
        i= nbMax;
        var msg = "Praticien" + i;
        var oldMsg = "Praticien" + 1;
    }else{
        var msg = "Praticien" + (i-1);
        var oldMsg = "Praticien" + i;
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
    var select = document.getElementById("listePraticien");
    var valeur = select.options[select.selectedIndex].id ;

    var msg = "Praticien" + valeur;
    var oldMsg = "Praticien" + i;
    i = valeur ;

    document.getElementById(oldMsg).style.display = "none";
    document.getElementById(msg).style.display = "initial"; 
}

</script>
<script type="text/javascript">
    /*Permet de recup une variable en PHP*/
    var nbMax = <?php echo json_encode(count($tabNom)); ?>;

    var i = 1
    var msg = "";
    /*Cache les tableaux au chargement de la page*/
    for (pas = 2; pas < nbMax+1; pas++) {
        msg = "Praticien" + pas;
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