    <?php
    session_start();
    if (isset($_SESSION['login'])) {
        include 'head.php';
        require 'bdd.php';
        $bdd = getBdd();
        $stmt = $bdd->prepare("SELECT * FROM medicament INNER JOIN famille ON medicament.FAM_CODE = famille.FAM_CODE");
        $stmt->execute(); 
        $donnees = $stmt ->fetch();

        $compteur = 0;

        $tabCode = array();
        $tabNom = array();
        $tabFam = array();
        $tabComp = array();
        $tabEff = array();
        $tabContre = array();
        $tabPrix = array();


        while($donnees = $stmt -> fetch())
            {
            // Conversion en ISO : Solution temporaire pour avoir les accents (bug UTF-8)
            $tabCode[$compteur] = mb_convert_encoding($donnees['MED_DEPOTLEGAL'], "UTF-8", "ISO-8859-1");
            $tabNom[$compteur] = mb_convert_encoding($donnees['MED_NOMCOMMERCIAL'], "UTF-8", "ISO-8859-1");
            $tabFam[$compteur] = mb_convert_encoding($donnees['FAM_LIBELLE'], "UTF-8", "ISO-8859-1");
            $tabComp[$compteur] = mb_convert_encoding($donnees['MED_COMPOSITION'], "UTF-8", "ISO-8859-1");
            $tabEff[$compteur] = mb_convert_encoding($donnees['MED_EFFETS'], "UTF-8", "ISO-8859-1");
            $tabContre[$compteur] = mb_convert_encoding($donnees['MED_CONTREINDIC'], "UTF-8", "ISO-8859-1");

            if (is_null($donnees['MED_PRIXECHANTILLON'])) {
                $tabPrix[$compteur] = "Pas d'indication de prix. (NULL)";
            } else {
                $tabPrix[$compteur] = $donnees['MED_PRIXECHANTILLON'];
            }

            $compteur++;
            }   
        ?>

      <div id="page">
    <?php

    for($i = 0; $i <= count($tabCode)- 1;$i++){
    echo "  
    <div id = 'medoc".($i + 1)."' class = 'medicament'>
    <div class='col-sm-6 col-md-12'>
    <h1>Médicament n°".($i + 1)."</h1>
 <table class='table table-dark'>
  <tbody>
       <tr>
      <th>Code</th>
      <td>".$tabCode[$i]."</td>
    </tr>
    <tr>
      <th>Nom Commercial</th>
      <td>".$tabNom[$i]."</td>
    </tr>

    <tr>
      <th>Famille</th>
      <td>".$tabFam[$i]."</td>
    </tr>
    <tr>
      <th>Composition</th>
      <td>".$tabComp[$i]."</td>
    </tr>
    <tr>
      <th>Effets indésirables</th>
      <td>".$tabEff[$i]."</td>
    </tr>
    <tr>
      <th>Contre indications</th>
      <td>".$tabContre[$i]."</td>
    </tr>
    <tr>
      <th>Prix Echantillon</th>
      <td>".$tabPrix[$i]."</td>
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
    <label for="exampleFormControlSelect1">Liste des Médicaments :</label>
    <select id ="listeMedicaments" class="form-control" >
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
        var msg = "medoc" + i;
        var oldMsg = "medoc" + nbMax;
    }else{
        var msg = "medoc" + (i+1);
        var oldMsg = "medoc" + i;
        increment();
    }
    document.getElementById(oldMsg).style.display = "none";
    document.getElementById(msg).style.display = "initial";
}

function Precedent() {
    if (i == 1){
        i= nbMax;
        var msg = "medoc" + i;
        var oldMsg = "medoc" + 1;
    }else{
        var msg = "medoc" + (i-1);
        var oldMsg = "medoc" + i;
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
  var select = document.getElementById("listeMedicaments");
  var valeur = select.options[select.selectedIndex].id ;

  var msg = "medoc" + valeur;
  var oldMsg = "medoc" + i;
  i = valeur ;

    document.getElementById(oldMsg).style.display = "none";
    document.getElementById(msg).style.display = "initial"; 
}

</script>
<script type="text/javascript">
    var nbMax = <?php echo json_encode(count($tabCode)); ?>;
    var i = 1
    var msg = "";
    for (pas = 2; pas < nbMax+1; pas++) {
        msg = "medoc" + pas;
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