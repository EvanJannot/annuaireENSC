<?php
require_once "includes/functions.php";
session_start();
$error =false;

if (!empty($_POST['login']) and !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $user = $_POST['utilisateur'];
    if($user =='eleve')
    {
        $stmt = getDb()->prepare('select * from elève where login=? and mdp=? and validation=1');
        $ng = getDb()->prepare('select * from elève where login=? and mdp=? and validation=0');
    }
    else
    {
        $stmt = getDb()->prepare('select * from gestionnaire where login=? and mdp=?');
    }
    
    $stmt->execute(array($login, $password));
    if ($stmt->rowCount() == 1) {
        // Authentication successful
        $_SESSION['login'] = $login;
        redirect("index.php");
    }
    else {
        $error = true;
    }
}
?>

<!doctype html>
<html>

<?php 
$pageTitle = "Connexion";
require_once "includes/head.php";
?>

<body>

    
        
<?php include('includes\navbar.php') ?>
<div class="container">

<img class = "displayed" src="picture/ENSC.png" width=25%>
        
        <div class="well">
        
        <h2 class="text-center" style="font-size:40px">Connexion</h2>     
            <form class="form-signin form-horizontal" role="form" action="login.php" method="post" col-4>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    Login:
                    <input type="text" name="login" class="form-control" placeholder="Entrez votre login" required autofocus>
                    </div>
                </div>
</br>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        Mot de passe:
                        <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                    </div>
                </div>
</br>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        Sélectionner votre type de compte: </br>
                        <input type="radio" name="utilisateur" id="eleve" value="eleve" required>
                        <label for="eleve">Elève</label>
                        <input type="radio" name="utilisateur" id="gestionnaire" value="gestionnaire" required>
                            <label for="gestionnaire">Gestionnaire</label>
                    </div>
                </div>
</br>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <div align = "center">
                        <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Se connecter</button>
                    </div>
                    </div>
                </div>
            </form>
</br>
            <div align = "center"> 
                <a href="register.php">Première visite ? S'inscrire.</a>
            </div>
        </div>
        <?php if($error == true)
        {
            print "<h2 class=text-center>Utilisateur non reconnu</h2>";
        }?>
        </div>
    <?php include('includes\footer.php') ?>    



      <?php require_once "includes/scripts.php"; ?>

</html>