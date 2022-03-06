<?php
require_once "includes/functions.php";
session_start();
if (isUserConnected()) { 
$eleves = getDb()->query('select * from elève order by nom'); 
$exp = getDb()->query("SELECT * FROM expérience ORDER BY idExp"); 
$prom = getDb()->query("SELECT promotion FROM elève ORDER BY promotion");
$promoCompteur =0;

if(isset($_POST['recherche']) AND !empty($_POST['recherche'])) {
   $q = escape($_POST['recherche']);
   $recherche = getDb()->query("SELECT * FROM elève WHERE nom = '$q' OR prenom='$q' OR CONCAT(nom,' ', prenom)='$q' OR CONCAT(prenom,' ', nom)='$q' ");
}
if(isset($_POST['comp']))
{
    foreach($_POST['comp'] as $nomC)
    {
      $comp = escape($nomC);
      if($comp != "Toutes")
      {
        $idC = getDb()->prepare('SELECT idCom FROM compétences WHERE nom =?');
        $idC -> execute(array($comp));
        $idComp = $idC->fetch();
        $expComp = getDb()->prepare("SELECT idExp FROM porte_sur WHERE idCom ='$idComp[idCom]'");
        $expComp -> execute();
        $_expC = $expComp->fetch();
        if($_expC != null)
        {
            $_ExperienceC = getDb()->query("SELECT * FROM expérience WHERE idExp ='$_expC[idExp]'");
        }
        if($_expC == null)
        {
            break;
        }
      }
    }
}
if(isset($_POST['sect']))
{
    foreach($_POST['sect'] as $nomS)
    {
      $sect = escape($nomS);
      if($sect != "Tous")
      {
        $idS = getDb()->prepare('SELECT idSec FROM secteur WHERE nom =?');
        $idS -> execute(array($sect));
        $idSect = $idS->fetch();
        $expSect=  getDb()->prepare("SELECT idSec FROM est_dans WHERE idSec ='$idSect[idSec]'");
        $expSect -> execute();
        $_expS = $expSect->fetch();
        if($_expS != null)
        {
            $_ExperienceS = getDb()->query("SELECT * FROM expérience WHERE idExp ='$_expS[idSec]'");
        }
        if($_expS == null)
        {
            break;
        }
      }
    }
}

if(isset($_POST['dpt']))
{
    foreach($_POST['dpt'] as $nomDPT)
    {
      $dpt = escape($nomDPT);
      if($dpt != "Tous")
      {
        $idDPT = getDb()->prepare('SELECT idOrg FROM organisme WHERE departement =?');
        $idDPT -> execute(array($dpt));
        $idD = $idDPT->fetch();
        if($idD != null)
        {
            $_ExperienceD=  getDb()->query("SELECT * FROM expérience WHERE idOrg ='$idD[idOrg]'");
        }
        if($idD == null)
        {
            break;
        }
      }
    }
}

?>

<!doctype html>
<html>

<?php 
$pageTitle = "Accueil";
require_once "includes/head.php"; ?>

<body >

<?php include('includes\navbar.php') ?>
<div class="container">

<div class="jumbotron">
<div class="container">
<h1 class="text-center" style="font-size:55px">Effectuez votre recherche</h1>
</br>
<div class="col-xs-12 ">
<div class="container text-center">
	<div class="row">
		<div class="col-md-12">
      <form class="form-inline" role="form" action="index.php" method="post">
            <div class="input-group" id="adv-search" action="index.php" method="post">
                <input type="text" name="recherche" class="form-control" placeholder="Rechercher..." />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">                     
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
            </br>
            </br>
            <div class="form-group">
                <label class="col-sm-3 control-label">Compétence(s): 
                <select multiple  name="comp[]" id="comp" size="4" >
                    <option value="Toutes"  selected="selected">Toutes</option>
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
                    </label>
                </select>
                </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label">Sécteur(s): 
                <select multiple  name="sect[]" id="sect" size="4" >
                    <option value="Tous"  selected="selected">Tous</option>
                    <option value="Informatique">Informatique</option>
                    <option value="Santé">Santé</option>
                    <option value="Aéronautique">Aéronautique</option>
                    <option value="Aérospatial">Aérospatial</option>
                    <option value="Télécommunication">Télécommunications</option>
                    <option value="Recherche-Développement">Recherche-Développement</option>
                    </label>
                </select>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Département(s): 
                <select multiple  name="dpt[]" id="dpt" size="4" >
                <option value="Tous" selected="selected">Toute localisation</option>
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
                    </label>
                </select>
            </div>

              
      </form>
    </div>
  </div>
</div>
</div>
</div>
</div>

<h3> Promotion  
    <?php foreach ($prom as $promo) { 
    if($promo['promotion'] != $promoCompteur)
    {
        $compteur =1;?>
    <?php if($compteur ==1) {?>
        <a href="promo.php?id=<?= $promo['promotion']; ?>"><?= $promo['promotion']; ?> </a>
        <?php}
        else
        {?>
        <a href="promo.php?id=<?= $promo['promotion']; ?>"><?= print" / "; $promo['promotion'];?> </a>
        <?php }
        $promoCompteur = $promo['promotion'];
        $compteur++;
    }?>
    <?php } ?>
</h3>

</br>
<div class="carre" style ="background-color: white; padding-bottom: 200px" >
    <div class="container" >

<?php	if(isset($_POST['recherche']) AND !empty($_POST   ['recherche'])) {?>
    <?php if($recherche->rowCount() > 0) { ?>
        <ul>
            <?php while($a = $recherche->fetch()) { ?>
                <h3><li><a href = "eleve.php"><?= $a['nom']; print" " ?><?= $a['prenom'] ?></a></h3>
                <p>Promotion : <?= $a['promotion'] ?></p>
                </li>
            <?php } ?>
        </ul>

    <?php } else { ?>
    <h3>Aucun résultat</h3>
    <?php } ?>

<?php } ?>

<!-- Pas de filtre -->
<?php	if(empty($_POST['recherche']) and !isset($_POST['comp']) and !isset($_POST['sect']) and !isset($_POST['dpt']) )  { ?>
  <ul>
    <?php foreach ($eleves as $eleve) { ?>
        <?php if ($eleve['validation'] ==1) { ?>
            <article>
                <h3><li><a href="profil.php?id=<?= $eleve['id']; ?>"><?= $eleve['nom']; print" " ?><?= $eleve['prenom'] ?></a></h3>
                <p>Promotion : <?= $eleve['promotion'] ?></p>
                </li>
                <hr>
            </article>
        <?php } ?>
    <?php } ?>
  </ul>
<?php } ?>

<!-- Utilisation des filtres -->
<?php	if(empty($_POST['recherche']) and isset($_POST['comp']) and isset($_POST['sect']) and isset($_POST['dpt'])) {
    if($sect !="Tous" and $_expS!=null) //Si on choisit un secteur (contient aussi les combinaisons secteur+compétence+dpt, secteur+compétence, secteur+dpt)
    { 
        if($comp=="Toutes" and $dpt=="Tous") //Si on choisit pas de compétence et pas de département
        {
            foreach($_ExperienceS as $expS)
            {
                $_EleveS = getDb()->query("SELECT * FROM elève WHERE id ='$expS[id]'");
                ?><ul>
                <?php
                foreach($_EleveS as $eleveS) {?>
                    <article>
                    <h3><li><a href="profil.php?id=<?= $eleveS['id']; ?>"><?= $eleveS['nom']; print" " ?><?= $eleveS['prenom'] ?></a></h3>
                    <p>Promotion : <?= $eleveS['promotion'] ?></p>
                    </li>
                    <hr>
                    </article>
                <?php } ?>
                </ul>
            <?php }
        }

        else if ($comp=="Toutes" and $dpt!="Tous" and $idD!=null) // Si on choisit un département mais pas de compétence
        {
            foreach($_ExperienceS as $expS)
            {
                foreach($_ExperienceD as $expD)
                {
                    $_EleveD = getDb()->query("SELECT * FROM elève WHERE id ='$expS[id]' AND id='$expD[id]'");
                    ?><ul>
                    <?php
                    foreach($_EleveD as $eleveD) {?>
                        <article>
                            <h3><li><a href="profil.php?id=<?= $eleveD['id']; ?>"><?= $eleveD['nom']; print" " ?><?= $eleveD['prenom'] ?></a></h3>
                            <p>Promotion : <?= $eleveD['promotion'] ?></p>
                            </li>
                            <hr>
                        </article>
                    <?php } ?>
                    </ul>
                <?php }
            }
        }

        else if($dpt == "Tous" and $comp !="Toutes" and $_expC!=null) // Si on choisit une compétence mais pas de département
        {
            foreach($_ExperienceS as $expS)
            {
                foreach($_ExperienceC as $expC)
                {
                    $_EleveF = getDb()->query("SELECT * FROM elève WHERE id ='$expS[id]' AND id='$expC[id]'");
                    ?><ul>
                    <?php
                    foreach($_EleveF as $eleveF) {?>
                        <article>
                            <h3><li><a href="profil.php?id=<?= $eleveF['id']; ?>"><?= $eleveF['nom']; print" " ?><?= $eleveF['prenom'] ?></a></h3>
                            <p>Promotion : <?= $eleveF['promotion'] ?></p>
                            </li>
                            <hr>
                        </article>
                    <?php } ?>
                    </ul>
                <?php }
            }
        }

        else if($comp !="Toutes" and $_expC!=null and $dpt !="Tous" and $idD!=null) // Si on choisit une compétence et un département
        {
            foreach($_ExperienceS as $expS)
            {
                foreach($_ExperienceC as $expC)
                {
                    foreach($_ExperienceD as $expD)
                    {
                        $_EleveD = getDb()->query("SELECT * FROM elève WHERE id ='$expS[id]' AND id='$expC[id]' AND id='$expD[id]'");
                        ?><ul>
                        <?php
                        foreach($_EleveD as $eleveD) {?>
                            <article>
                                <h3><li><a href="profil.php?id=<?= $eleveD['id']; ?>"><?= $eleveD['nom']; print" " ?><?= $eleveD['prenom'] ?></a></h3>
                                <p>Promotion : <?= $eleveD['promotion'] ?></p>
                                </li>
                                <hr>
                            </article>
                        <?php } ?>
                        </ul>
                    <?php }
                    
                }
            }
        }
    }

    if($comp !="Toutes" and $_expC!=null) //On choisit une compétence (contient aussi la combinaison compétence/dpt)
    {
        if($sect=="Tous" and $dpt=="Tous")
        {
            foreach($_ExperienceC as $expC)
            {
                $_EleveC = getDb()->query("SELECT * FROM elève WHERE id ='$expC[id]'");
                ?><ul>
                <?php
                foreach($_EleveC as $eleveC) {?>
                    <article>
                    <h3><li><a href="profil.php?id=<?= $eleveC['id']; ?>"><?= $eleveC['nom']; print" " ?><?= $eleveC['prenom'] ?></a></h3>
                    <p>Promotion : <?= $eleveC['promotion'] ?></p>
                    </li>
                    <hr>
                    </article>
                <?php } ?>
                </ul>
            <?php }
        }

        else if ($sect=="Tous" and $dpt!="Tous" and $idD != null)
        {
            foreach($_ExperienceC as $expC)
            {
                foreach($_ExperienceD as $expD)
                {
                    $_EleveD = getDb()->query("SELECT * FROM elève WHERE id ='$expC[id]' AND id='$expD[id]'");
                    ?><ul>
                    <?php
                    foreach($_EleveD as $eleveD) {?>
                        <article>
                            <h3><li><a href="profil.php?id=<?= $eleveD['id']; ?>"><?= $eleveD['nom']; print" " ?><?= $eleveD['prenom'] ?></a></h3>
                            <p>Promotion : <?= $eleveD['promotion'] ?></p>
                            </li>
                            <hr>
                        </article>
                    <?php } ?>
                    </ul>
                <?php }
            }
        }
    }

    if ($dpt !="Tous" and $idD!=null and $idD!=null) //On choisit un département
    {
        if($sect=="Tous" and $comp=="Toutes")
        {
            foreach($_ExperienceD as $expD)
            {
                $_EleveD = getDb()->query("SELECT * FROM elève WHERE id ='$expD[id]'");
                ?><ul>
                <?php
                foreach($_EleveD as $eleveD) {?>
                    <article>
                    <h3><li><a href="profil.php?id=<?= $eleveD['id']; ?>"><?= $eleveD['nom']; print" " ?><?= $eleveD['prenom'] ?></a></h3>
                    <p>Promotion : <?= $eleveD['promotion'] ?></p>
                    </li>
                    <hr>
                    </article>
                <?php } ?>
                </ul>
            <?php }
        }
    }

    else if ($comp =="Toutes" and $sect=="Tous" and $dpt =="Tous") //On ne sélectionne aucun filtre
    {?>
    <ul>
        <?php foreach ($eleves as $eleve) { ?>
            <?php if ($eleve['validation'] ==1) { ?>
                <article>
                    <h3><li><a href="profil.php?id=<?= $eleve['id']; ?>"><?= $eleve['nom']; print" " ?><?= $eleve['prenom'] ?></a></h3>
                    <p>Promotion : <?= $eleve['promotion'] ?></p>
                    </li>
                    <hr>
                </article>
            <?php } ?>
        <?php } ?>
    </ul>
    <?php }
}
} 
else
{
    redirect('login.php');
}?>

<?php include('includes\footer.php') ?>    
</div>
</div>
<?php require_once "includes/scripts.php"; ?></body>

</html>