<?php
require_once "includes/functions.php";
session_start();
$eleves = getDb()->query('select * from elève order by nom'); 

    if (isset($_POST['eleve']) ) 
    { 
        foreach($_POST['eleve'] as $nouveau)
        {
            $nouv= escape($nouveau);
            $stmt = getDb()->prepare("UPDATE elève SET validation=1 WHERE nom='$nouv'");
            $stmt->execute(); 
            redirect("gestion.php");
        }
    } 

    if(isset($_POST['tous']))
    {
        foreach ($eleves as $eleve) 
        { 
            if($eleve['validation'] ==0)
            {
                $valider = getDb()->prepare("UPDATE elève SET validation=1 WHERE id='$eleve[id]'");
                $valider->execute(); 
                redirect("gestion.php");
            }
        }
    }

?>

<!doctype html>
<html>

<?php 
$pageTitle = "Gestion des demandes";
require_once "includes/head.php"; ?>

<body >

<?php include('includes\navbar.php') ?>
<div class="container">

<div class="jumbotron">
<div class="container">
<form class="form-signin form-horizontal" role="form" action="gestion.php" method="post" col-4>
<h1 class="text-center" style="font-size:55px">Acceptez de nouveaux élèves</h1>
<div class = "text-center">
            <h3><input type="checkbox" id="tous" name="tous">
            <label for="tous">Accepter tous les élèves</label></h3>
<button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-ok"></span> Accepter la séléction</button>
</div>
</br>
<div class="carre" style ="background-color: white; padding-bottom: 200px" >
    <div class="container" >

<?php ?>
  <ul>
    <?php 

    foreach ($eleves as $eleve) { ?>
        <?php if ($eleve['validation'] ==0) { ?>
      <article>
                <h3><input type="checkbox" id="<?= $eleve['nom'];?>" name="eleve[]" value="<?= $eleve['nom'];?>">
                <label for="<?= $eleve['nom'];?>"><?= $eleve['nom']; print" " ?><?= $eleve['prenom'] ?></label></h3>
                <p>Promotion : <?= $eleve['promotion'] ?></p>
                <hr>
            </article>
            <?php } ?>
        <?php } ?>
        </ul>
<?php ?>
</form>


        
<?php include('includes\footer.php') ?>    
</div>
</div>
<?php require_once "includes/scripts.php"; ?></body>

</html>