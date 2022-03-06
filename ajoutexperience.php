<?php
require_once "includes/functions.php";
session_start();
$login = $_SESSION['login'];

$idEleve = getDb()->query("SELECT id FROM elève WHERE login ='$login'");
$idE= $idEleve->fetch();
$idExp= nbidbis();  
$idOrga= nbidter();  

//Partie Organisme
if (isset($_POST['organisme'])) {
$nom = escape($_POST['organisme']);
$type= escape($_POST['typeOrga']);
$adresse= escape($_POST['adresse']);
$dpt= escape($_POST['dpt']);
$orga = getDb()->prepare('insert into organisme
(idOrg, type_, adresse, nom, departement)
values (?, ?, ?, ?, ?)');
$orga->execute(array($idOrga, $type, $adresse, $nom, $dpt));
}

//Partie experience
if (isset($_POST['ddd'])) {
  $ddd = escape($_POST['ddd']);
  $ddf = escape($_POST['ddf']);
  $typeExp = escape($_POST['typeExp']);
  $description= escape($_POST['description']);
  $salaire = escape($_POST['salaire']);
  $exp = getDb()->prepare('insert into expérience
  (idExp, ddd, ddf, type, description, salaire, idOrg, id)
  values (?, ?, ?, ?, ?, ?, ?, ?)');
  $exp->execute(array($idExp, $ddd, $ddf, $typeExp, $description, $salaire, $idOrga, $idE['id']));
}
//Partie Secteurs
if (isset($_POST['sect'])) {
  foreach($_POST['sect'] as $nomS)
  {
    $sect = escape($nomS);
    $idS = getDb()->prepare('SELECT idSec FROM secteur WHERE nom =?');
    $idS -> execute(array($sect));
    $idSect = $idS->fetch();
    $ED = getDb()->prepare('insert into est_dans
    (idExp, idSec)
    values (?, ?)');
    $ED->execute(array($idExp, $idSect['idSec']));
  }
  }
//Partie Compétences
if (isset($_POST['comp'])) {
  foreach($_POST['comp'] as $nomC)
  {
    $comp = escape($nomC);
    $idC = getDb()->prepare('SELECT idCom FROM compétences WHERE nom =?');
    $idC -> execute(array($comp));
    $idComp = $idC->fetch();
    $PR = getDb()->prepare('insert into porte_sur
    (idExp, idCom)
    values (?, ?)');
    $PR->execute(array($idExp, $idComp['idCom']));
  }
  redirect("profil.php");
  }

?>

<!doctype html>
<html>
<?php 
$pageTitle = "Ajout d'expérience";
require_once "includes/head.php"; 

?>

<body>
<?php include('includes\navbar.php') ?>

<div class="container">
          <div class="well">
          <h1 class="text-center" style="font-size:50px">Ajoutez une expérience</h1> </br>
            <form class="form-horizontal" role="form" enctype="multipart/form-data" action="ajoutexperience.php" method="post">
              <div class="form-group">
                <label class="col-sm-4 control-label">Date de début</label>
                <div class="col-sm-6">
                <input type="date" id="start" name="ddd" min="2000-01-01" max=<?php echo date('Y-m-d') ?> required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Date de fin</label>
                <div class="col-sm-6">
                <input type="date" id="start" name="ddf" min="2000-01-01" >
                </div>
              </div>
              <div class="form-group">
              <label class="col-sm-4 control-label">Sélectionnez un type d'expérience:                         </label>       
                <select multiple  name="typeExp" id="typeExp" size="4" required>
                    <option value="Autre"  selected="selected">Autre</option>
                    <option value="Stage">Stage</option>
                    <option value="CDD">CDD</option>
                    <option value="CDI">CDI</option>
                    <option value="Alternance">Alternance</option>
                    <option value="Apprentissage">Apprentissage</option>
                    <option value="ETT/Intérim">ETT/Intérim</option>
                </select>
                
                </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Description de l'expérience</label>
                <div class="col-sm-6">
                  <textarea name="description" class="form-control" rows="1" placeholder="Entrez une courte description" required></textarea>                      
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Salaire</label>
                <div class="col-sm-6">
                <input type="text" name="salaire" class="form-control" placeholder="Champ optionnel">               
                </div>
              </div>
              <div class="form-group">
              <label class="col-sm-4 control-label">Sélectionnez une ou plusieurs compétence(s):                         </label>       
                <select multiple  name="comp[]" id="comp" size="4" required>
                    <option value="Autre"  selected="selected">Autre</option>
                    <option value="C#">C#</option>
                    <option value="HTML">HTML</option>
                    <option value="CSS">CSS</option>
                    <option value="PHP">PHP</option>
                    <option value="UX design">UX design</option>
                    <option value="Wire Frame">Wire Frame</option>
                    <option value="IA">IA</option>
                    <option value="Robotique">Robotique</option>
                    <option value="Médical">Médical</option>
                    <option value="Psychologie">Pyschologie</option>
                    <option value="Signal">Signal</option>
                    <option value="SQL">SQL</option>
                </select>
                
                </div>
                <div class="form-group">
                <label class="col-sm-4 control-label">Sélectionnez un ou plusieurs sécteur(s): </label>   
                <select multiple  name="sect[]" id="sect" size="4" required >
                    <option value="autre"  selected="selected">Autre</option>
                    <option value="Informatique">Informatique</option>
                    <option value="Santé">Santé</option>
                    <option value="Aéronautique">Aéronautique</option>
                    <option value="Aérospatial">Aérospatial</option>
                    <option value="Télécommunication">Télécommunications</option>
                    <option value="Recherche-Développement">Recherche-Développement</option>
                </select>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Département(s): </label>  
                <select multiple  name="dpt" id="dpt" size="4" required >
                <option value="tout" selected="selected">Toute localisation</option>
                <option value="00">(00) Hors France</option>
                <option value="01">(01) Ain </option>
                <option value="02">(02) Aisne </option>
                <option value="03">(03) Allier </option>
                <option value="04">(04) Alpes de Haute Provence </option>
                <option value="05">(05) Hautes Alpes </option>
                <option value="06">(06) Alpes Maritimes </option>
                <option value="07">(07) Ardèche </option>
                <option value="08">(08) Ardennes </option>
                <option value="09">(09) Ariège </option>
                <option value="10">(10) Aube </option>
                <option value="11">(11) Aude </option>
                <option value="12">(12) Aveyron </option>
                <option value="13">(13) Bouches du Rhône </option>
                <option value="14">(14) Calvados </option>
                <option value="15">(15) Cantal </option>
                <option value="16">(16) Charente </option>
                <option value="17">(17) Charente Maritime </option>
                <option value="18">(18) Cher </option>
                <option value="19">(19) Corrèze </option>
                <option value="2A">(2A) Corse du Sud </option>
                <option value="2B">(2B) Haute-Corse </option>
                <option value="21">(21) Côte d'Or </option>
                <option value="22">(22) Côtes d'Armor </option>
                <option value="23">(23) Creuse </option>
                <option value="24">(24) Dordogne </option>
                <option value="25">(25) Doubs </option>
                <option value="26">(26) Drôme </option>
                <option value="27">(27) Eure </option>
                <option value="28">(28) Eure et Loir </option>
                <option value="29">(29) Finistère </option>
                <option value="30">(30) Gard </option>
                <option value="31">(31) Haute Garonne </option>
                <option value="32">(32) Gers </option>
                <option value="33">(33) Gironde </option>
                <option value="34">(34) Hérault </option>
                <option value="35">(35) Ille et Vilaine </option>
                <option value="36">(36) Indre </option>
                <option value="37">(37) Indre et Loire </option>
                <option value="38">(38) Isère </option>
                <option value="39">(39) Jura </option>
                <option value="40">(40) Landes </option>
                <option value="41">(41) Loir et Cher </option>
                <option value="42">(42) Loire </option>
                <option value="43">(43) Haute Loire </option>
                <option value="44">(44) Loire Atlantique </option>
                <option value="45">(45) Loiret </option>
                <option value="46">(46) Lot </option>
                <option value="47">(47) Lot et Garonne </option>
                <option value="48">(48) Lozère </option>
                <option value="49">(49) Maine et Loire </option>
                <option value="50">(50) Manche </option>
                <option value="51">(51) Marne </option>
                <option value="52">(52) Haute Marne </option>
                <option value="53">(53) Mayenne </option>
                <option value="54">(54) Meurthe et Moselle </option>
                <option value="55">(55) Meuse </option>
                <option value="56">(56) Morbihan </option>
                <option value="57">(57) Moselle </option>
                <option value="58">(58) Nièvre </option>
                <option value="59">(59) Nord </option>
                <option value="60">(60) Oise </option>
                <option value="61">(61) Orne </option>
                <option value="62">(62) Pas de Calais </option>
                <option value="63">(63) Puy de Dôme </option>
                <option value="64">(64) Pyrénées Atlantiques </option>
                <option value="65">(65) Hautes Pyrénées </option>
                <option value="66">(66) Pyrénées Orientales </option>
                <option value="67">(67) Bas Rhin </option>
                <option value="68">(68) Haut Rhin </option>
                <option value="69">(69) Rhône </option>
                <option value="70">(70) Haute Saône </option>
                <option value="71">(71) Saône et Loire </option>
                <option value="72">(72) Sarthe </option>
                <option value="73">(73) Savoie </option>
                <option value="74">(74) Haute Savoie </option>
                <option value="75">(75) Paris </option>
                <option value="76">(76) Seine Maritime </option>
                <option value="77">(77) Seine et Marne </option>
                <option value="78">(78) Yvelines </option>
                <option value="79">(79) Deux Sèvres </option>
                <option value="80">(80) Somme </option>
                <option value="81">(81) Tarn </option>
                <option value="82">(82) Tarn et Garonne </option>
                <option value="83">(83) Var </option>
                <option value="84">(84) Vaucluse </option>
                <option value="85">(85) Vendée </option>
                <option value="86">(86) Vienne </option>
                <option value="87">(87) Haute Vienne </option>
                <option value="88">(88) Vosges </option>
                <option value="89">(89) Yonne </option>
                <option value="90">(90) Territoire de Belfort </option>
                <option value="91">(91) Essonne </option>
                <option value="92">(92) Hauts de Seine </option>
                <option value="93">(93) Seine Saint Denis </option>
                <option value="94">(94) Val de Marne </option>
                <option value="95">(95) Val d'Oise </option>
                <option value="971">(971) Guadeloupe </option>
                <option value="972">(972) Martinique </option>
                <option value="973">(973) Guyane </option>
                <option value="974">(974) Réunion </option>
                <option value="975">(975) Saint Pierre et Miquelon </option>
                <option value="976">(976) Mayotte </option>
                </select>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Nom de l'organsime</label>
                <div class="col-sm-6">
                <input type="text" name="organisme" class="form-control" required>               
                </div>
              </div>
              <div class="form-group">
              <label class="col-sm-4 control-label">Type d'organisme                       </label>       
                <select multiple  name="typeOrga" id="typeOrga" size="4" required>
                    <option value="Autre"  selected="selected">Autre</option>
                    <option value="Laboratoire">Laboratoire</option>
                    <option value="Entreprise publique">Entreprise publique</option>
                    <option value="Entreprise privée">Entreprise privée</option>
                    <option value="Etablissement scolaire">Etablissement scolaire</option>
                </select>
                
                </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Adresse</label>
                <div class="col-sm-6">
                <input type="text" name="adresse" class="form-control" placeholder="Champ optionnel">               
                </div>
            </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                  <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-save"></span> Ajouter cette expérience</button>
                </div>
              </div>
            </form>
          </div>
            </div>



<?php include('includes\footer.php') ?>    
</body>
<?php require_once "includes/scripts.php"; ?></body>

</html>