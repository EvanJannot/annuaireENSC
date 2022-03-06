<?php require_once "includes/functions.php"; 

if (!empty($_SESSION['login'])) {
$login = $_SESSION['login'];
$name = getDb()->query("SELECT nom FROM elève WHERE login ='$login'");
$nom = $name->fetch();
$nameGestion = getDb()->query("SELECT nom FROM gestionnaire WHERE login ='$login'");
$nomGestion = $nameGestion->fetch();
$idEleve = getDb()->query("SELECT id FROM elève WHERE login ='$login'");
$idE= $idEleve->fetch();}
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-target">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-book"></span> Annuaire ENSC</a>
</div>
<div class="collapse navbar-collapse" id="navbar-collapse-target">
           
                
                <?php if (isUserConnected()) { ?>
                    <ul class="nav navbar-nav">
                    <li><a href="index.php">Accueil</a></li>
                    </ul>
                <?php } ?>
            
                <ul class="nav navbar-nav">
                    <li><a href="contact.php">Contact</a></li>
                </ul>

            <ul class="nav navbar-nav navbar-right">
        <?php if (isUserConnected()) { ?>
            

                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span> 
                            Bienvenue, <?= $_SESSION['login'] ?><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                        <?php if (!empty($nomGestion['nom'])) { ?>
                            <li><a href="gestion.php">Accepter de nouveaux élèves</a></li>
                        <?php } ?> 
                        <?php if (!empty($nomGestion['nom'])) { ?>
                            <li><a href="register.php">Créer le compte d'un élève</a></li>
                        <?php } ?> 
                        <?php if (!empty($nom['nom'])) { ?>
                            <li><a href="profil.php?id=<?=$idE['id']; ?>">Mon profil</a></li>
                        <?php } ?> 
                            <li><a href="logout.php">Se déconnecter</a></li>
                        </ul>
                    </li>
                    <?php } ?> 
                    </ul>
                    
        
    </div>
                            </div>
</nav>
