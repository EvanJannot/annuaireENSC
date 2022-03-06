<?php
require_once "includes/functions.php";
session_start();
$eleves = getDb()->query('select * from elève order by nom'); 
$_Promo = $_GET['id']
?>

<!doctype html>
<html>

<?php 
$pageTitle = "Accueil";
require_once "includes/head.php"; ?>

<body>

<?php include('includes\navbar.php') ?>

<h1 class="text-center" style="font-size:55px">Elèves de la promotion : <?php echo $_Promo; ?></h1>

<div class="container">
<ul>
    <?php foreach ($eleves as $eleve) { ?>
        <?php if ($eleve['validation'] ==1 and $eleve['promotion']=$_Promo) { ?>
            <article>
                <h3><li><a href="profil.php?id=<?= $eleve['id']; ?>"><?= $eleve['nom']; print" " ?><?= $eleve['prenom'] ?></a></h3>
                <p>Promotion : <?= $eleve['promotion'] ?></p>
                </li>
                <hr>
            </article>
        <?php } ?>
    <?php } ?>
  </ul>
</div>


<?php include('includes\footer.php') ?>    
<?php require_once "includes/scripts.php"; ?></body>

</html>