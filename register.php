<?php
require_once "includes/functions.php";
session_start();
$isgood=true;
$nomGestion;
if (!empty($_SESSION['login'])) {
$login = $_SESSION['login'];
$nameGestion = getDb()->query("SELECT nom FROM gestionnaire WHERE login ='$login'");
$nomGestion = $nameGestion->fetch();}

if (isset($_POST['mail']) and isset($_POST['firstname']) and isset($_POST['name']) and isset($_POST['password']) and isset($_POST['passwordbis']) and isset($_POST['adresse']) and isset($_POST['tel']) and isset($_POST['sexe']) and isset($_POST['promotion']) and isset($_POST['age'])) {
  $mail = escape($_POST['mail']);
  $firstname = escape($_POST['firstname']);
  $name = escape($_POST['name']);
  $password = escape($_POST['password']);
  $passwordbis = escape($_POST['passwordbis']);
  $id= nbid();
  $adresse = escape($_POST['adresse']);
  $tel = escape($_POST['tel']);
  $sexe = escape($_POST['sexe']);
  $promotion = escape($_POST['promotion']) ;
  $login = strtolower(substr($firstname,0,1)).''.strtolower(substr($name,0,strlen($name)));
  $age = age(escape($_POST['age']));
  
  if($password == $passwordbis)
  {
    if (!empty($nomGestion['nom']))
    {
      $stmt = getDb()->prepare('insert into elève
      (adresseE, prenom, nom, mdp, id, validation, adresseP, telephone, sexe, promotion,login, age)
      values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )');
      $stmt->execute(array($mail, $firstname, $name, $password, $id, 1, $adresse, $tel, $sexe, $promotion, $login, $age));
      redirect("index.php");
    }
    else
    {
      $stmt = getDb()->prepare('insert into elève
      (adresseE, prenom, nom, mdp, id, validation, adresseP, telephone, sexe, promotion,login, age)
      values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )');
      $stmt->execute(array($mail, $firstname, $name, $password, $id, 0, $adresse, $tel, $sexe, $promotion, $login, $age));
      redirect("login.php");
    }
  
  }
  else
  {
    $isgood=false;
  }
}
 
?>

  <!doctype html>
  <html>
  <?php 
$pageTitle = "Inscription";
require_once "includes/head.php"; ?>

    <body>
      <div class="container">
        
      <?php include('includes\navbar.php') ?>
      <img class = "displayed" src="picture/ENSC.png" width=15%>
<div class="container">
          <div class="well">
          <h2 class="text-center" style="font-size:40px">Inscription</h2>
            <form class="form-horizontal" role="form" enctype="multipart/form-data" action="register.php" method="post">
              <input type="hidden" name="id" value="">
              <div class="form-group">
                <label class="col-sm-4 control-label">Email</label>
                <div class="col-sm-6">
                  <input type="text" name="mail" value="" class="form-control" placeholder="Entrez votre email" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Prénom</label>
                <div class="col-sm-6">
                  <input type="text" name="firstname" class="form-control" placeholder="Entrez votre prénom" required>
                                      
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Nom</label>
                <div class="col-sm-6">
                <input type="text" name="name" class="form-control" placeholder="Entrez votre nom" required>
                                      
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Adresse</label>
                <div class="col-sm-6">
                <input type="text" name="adresse" class="form-control" placeholder="Entrez votre adresse" required>
                                      
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-4 control-label">Téléphone</label>
                <div class="col-sm-6">
                <input type="text" name="tel" class="form-control" placeholder="Entrez votre numéro de téléphone" required>               
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Sexe</label>
                <div class="col-sm-6">
                <select name="sexe" id="sexe">
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                    <option value="Autre">Autre</option>
                </select>
                </div>
              </div>

                <div class="form-group">
                <label class="col-sm-4 control-label">Date de naissance</label>
                <div class="col-sm-6">
                <input type="date" id="start" name="age" min="1940-01-01" max="2002-01-01">



                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Promotion</label>
                <div class="col-sm-6">
                <select name="promotion" id="promotion">
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                </select>
                                      
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Mot de passe</label>
                <div class="col-sm-6">
                  <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Répétez votre mot de passe</label>
                <div class="col-sm-4">
                    <input type="password" name="passwordbis" class="form-control" placeholder="Re-entrez votre mot de passe" required>   
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
                  <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-save"></span> S'inscrire</button>
                </div>
              </div>
            </form>
            <?php include('includes\footer.php') ?>    
          </div>
            </div>


          <?php require_once "includes/scripts.php"; ?></body>

  </html>

  