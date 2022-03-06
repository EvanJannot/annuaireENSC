<?php
require_once "includes/functions.php";
session_start();
$login = $_SESSION['login'];
$isgood=true;

if (isset($_POST['mail']) OR isset($_POST['password']) OR isset($_POST['passwordbis']) OR isset($_POST['adresse']) OR isset($_POST['tel'])) {
    $mail = escape($_POST['mail']);
    $password = escape($_POST['password']);
    $passwordbis = escape($_POST['passwordbis']);
    $adresse = escape($_POST['adresse']);
    $tel = escape($_POST['tel']);
    
    if (!empty($_POST['mail']))
    {
        $adresseE = getDb()->prepare("UPDATE elève SET adresseE='$mail' WHERE login='$login'");
        $adresseE->execute(); 
    } 
    if (!empty($_POST['password']))
    {
        if($password == $passwordbis)
        {
            $MDP = getDb()->prepare("UPDATE elève SET mdp='$password' WHERE login='$login'");
            $MDP->execute(); 
        }
        else
        {
            $isgood=false;
        }
    } 
    if (!empty($_POST['adresse']))
    {
        $adresseP = getDb()->prepare("UPDATE elève SET adresseP='$adresse' WHERE login='$login'");
        $adresseP->execute(); 
    } 
    if (!empty($_POST['tel']))
    {
        $telephone = getDb()->prepare("UPDATE elève SET telephone='$tel' WHERE login='$login'");
        $telephone->execute(); 
    } 
    redirect("profil.php");


  }
?>

<!doctype html>
<html>
<?php 
$pageTitle = "Modification du profil";
require_once "includes/head.php"; 

?>

<body>
<?php include('includes\navbar.php') ?>

</br></br></br></br></br></br>
<div class="container">
          <div class="well">
          <h2 class="text-center" style="font-size:40px">Edition du profil</h2>
            <form class="form-horizontal" role="form" enctype="multipart/form-data" action="modifprofil.php" method="post">
              <div class="form-group">
                <label class="col-sm-4 control-label">Modifiez votre email</label>
                <div class="col-sm-6">
                  <input type="text" name="mail" class="form-control" placeholder="Entrez votre nouveau email">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Modifiez votre adresse</label>
                <div class="col-sm-6">
                <input type="text" name="adresse" class="form-control" placeholder="Entrez votre nouvelle adresse">                  
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Modifiez votre numéro de téléphone</label>
                <div class="col-sm-6">
                <input type="text" name="tel" class="form-control" placeholder="Entrez votre nouveau numéro de téléphone">               
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Changez votre mot de passe</label>
                <div class="col-sm-6">
                  <input type="password" name="password" class="form-control" placeholder="Entrez votre nouveau mot de passe">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Répétez votre nouveau mot de passe</label>
                <div class="col-sm-4">
                    <input type="password" name="passwordbis" class="form-control" placeholder="Re-entrez votre nouveau mot de passe">   
                </div>
              </div>
              <?php
              if($isgood == false)
              {
                print"<center>Erreur, veuillez entrer le même mot de passe dans les deux cases.</center>";
                echo '</br>';
              }
            ?>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                  <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-save"></span>Valider les modifications</button>
                </div>
              </div>
            </form>
          </div>
            </div>



<?php include('includes\footer.php') ?>    
</body>
<?php require_once "includes/scripts.php"; ?></body>

</html>