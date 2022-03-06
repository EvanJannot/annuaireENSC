<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

<?php 
$pageTitle = "Contact";
require_once "includes/head.php"; ?>

<body>
<?php include('includes\navbar.php') ?>
<div class="container">

<div class="jumbotron">
<div class="container">
<h1 class="text-center" style="font-size:55px">Contactez-nous! </h1>
</br>
<div class="col-xs-12 ">
<div class="container text-center">

<div class="row">
            <div class="col-xs-6 col-lg-6">
            <img class = "displayed" src="picture/clucas.png" width=50%>
              <h2>Corentin Lucas</h2>
              <p>clucas@ensc.fr</p>
            </div><!--/.col-xs-6.col-lg-4-->
            <div class="col-xs-6 col-lg-6">
            <img class = "displayed" src="picture/ejannot.png" width=50%>
              <h2>Evan Jannot</h2>
              <p>ejannot@ensc.fr</p>
            </div><!--/.col-xs-6.col-lg-4-->
</div>

</div>
</div>
</div>
</div>

</div>
</body>

<?php include('includes\footer.php') ?>    
</div>
</div>
<?php require_once "includes/scripts.php"; ?></body>

</html>