<?php
require_once "includes/functions.php";
session_start();
$login = $_SESSION['login'];

if (isset($_GET['id']))
{$_ID = $_GET['id'];}

$idEleve = getDb()->query("SELECT id FROM elève WHERE login ='$login'");
$idE= $idEleve->fetch();
$exp = getDb()->query("SELECT * FROM expérience WHERE id ='$_ID' ORDER BY description"); 

$name = getDb()->query("SELECT nom FROM elève WHERE id ='$_ID'");
$nom = $name->fetch();

$firstname = getDb()->query("SELECT prenom FROM elève WHERE id ='$_ID'");
$prenom = $firstname->fetch();

$promotion = getDb()->query("SELECT promotion FROM elève WHERE id ='$_ID'");
$promo = $promotion->fetch();

$adresseP = getDb()->query("SELECT adresseP FROM elève WHERE id ='$_ID'");
$adresse = $adresseP->fetch();

$adresseE = getDb()->query("SELECT adresseE FROM elève WHERE id ='$_ID'");
$mail = $adresseE->fetch();

$telephone = getDb()->query("SELECT telephone FROM elève WHERE id ='$_ID'");
$tel = $telephone->fetch();

$nomprenom = $nom['nom'] . " " . $prenom['prenom'];
?>


<!doctype html>
<html>
<?php 
$pageTitle = "Profil";
require_once "includes/head.php"; 

?>

<?php include('includes\navbar.php') ?>

<div class="container">

      <div class="row row-offcanvas row-offcanvas-left">


          <div class="jumbotron">
            <h1 class="text-center">
              <?php  echo  $nomprenom?> 
              <?php
          if(!isset($_ID) or $idE['id'] == $_ID)
          {?>
              <a href="modifprofil.php"><button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-pencil" ></span></button></a>
              <?php } ?>
            </h1>
            <p class="text-center">
                Elève de l'ENSC au sein de la promotion <?php  echo   $promo['promotion']; ?>
            </p>
          </div>
          <div class="row">
            <div class="col-xs-6 col-lg-4">
              <h2 class="text-center">Adresse Postale</h2>
              <p class="text-center"> L'adresse postale de <?php  echo  $nomprenom?> est : </br> <?= $adresse['adresseP'] ?> </p>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <h2 class="text-center">Adresse email</h2>
              <p class="text-center"> L'adresse électronique de <?php  echo  $nomprenom?> est : </br> <?= $mail['adresseE'] ?> </p>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-4">
              <h2 class="text-center">Téléphone</h2>
              <p class="text-center">Le numéro de téléphone de <?php  echo  $nomprenom?> est : </br> +33<?= $tel['telephone'] ?> </br> </br> </br> </p>
            </div><!--/.col-xs-6.col-lg-4-->
          </div><!--/row-->
          <div class="row">
          <h1 class="text-center">Expérience(s)</h1>
          <?php
          if(!isset($_ID) or $idE['id'] == $_ID)
          {?>
          <div class="text-center">
          <a href="ajoutexperience.php"><button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-plus" ></span> Ajoutez une expérience</button></a>
          </div>
          <?php } ?>
          </div>
          <ul>
          <?php foreach ($exp as $experience) { ?>
           <article>
                <h2><li><?= $experience['description']; print" " ?></h2>
                <div class="col-xs-6 col-lg-4">
                <span style="font-size:18px">Type d'expérience :</span> <?= $experience['type'] ?> </br> <span style="font-size:18px">Date de début:</span> <?= $experience['ddd'] ?> 
                <?php if($experience['ddf']!=null){
                  print "</br> <span style=font-size:18px>Date de fin:</span> $experience[ddf]";      
                } 
                ?>
                </div>
                <div class="col-xs-6 col-lg-4">
                <?php 
                $orga = getDb()->query("SELECT * FROM organisme WHERE idOrg='$experience[idOrg]'"); 
                $organisme = $orga->fetch();
                print "<span style=font-size:18px>Organisme:</span> $organisme[nom] </br>"; 
                print "<span style=font-size:18px>Département:</span> $organisme[departement] </br>"; 
                ?>
                </div>
                <div class="col-xs-6 col-lg-4">
                <span style="font-size:18px">Secteur(s): </span>
                <?php 
                print" ";
                $sectExp = getDb()->query("SELECT * FROM est_dans WHERE idExp='$experience[idExp]'"); 
                foreach($sectExp as $_sectExp)
                {
                  $sect = getDb()->query("SELECT * FROM secteur WHERE idSec='$_sectExp[idSec]'"); 
                  $secteur = $sect->fetch();
                  print "$secteur[nom] "; 
                }
                ?>
                <span style="font-size:18px"></br>Compétence(s): </span>
                <?php 
                print" ";
                $compExp = getDb()->query("SELECT * FROM porte_sur WHERE idExp='$experience[idExp]'"); 
                foreach($compExp as $_compExp)
                {
                  $comp = getDb()->query("SELECT * FROM compétences WHERE idCom='$_compExp[idCom]'"); 
                  $competence = $comp->fetch();
                  print "$competence[nom], "; 
                }
                ?>
                </div>
                </li>
                
            </article>
           
          <?php } ?>
          </ul>
      </div><!--/row-->

<?php include('includes\footer.php') ?>    
</div>
</div>
<?php require_once "includes/scripts.php"; ?></body>

</html>