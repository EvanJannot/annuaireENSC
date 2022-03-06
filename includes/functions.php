<?php

// Connect to the database. Returns a PDO object
function getDb() {
    // Local deployment
    $db_name = 'id16470347_annuaire';
    $server = 'localhost';
    $username = 'id16470347_evan';
    $password = 'Evanjannot#33400';
    $db = "annuaire";
    
    return new PDO("mysql:host=$server;dbname=$db;charset=utf8", "$username", "$password",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

// Check if a user is connected
function isUserConnected() {
    return isset($_SESSION['login']);
}

// Redirect to a URL
function redirect($url) {
    header("Location: $url");
}

// Escape a value to prevent XSS attacks
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}

function nbid(){
    try
    {
	    $db = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
    $requete = $db->query ('SELECT COUNT(id) as countid FROM elève');
    $ligne = $requete->fetch();
    $id=($ligne['countid']+1);
    return $id;
}

function nbidbis(){
    try
    {
	    $db = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
    $requete = $db->query ('SELECT COUNT(idExp) as countid FROM expérience');
    $ligne = $requete->fetch();
    $id=($ligne['countid']+1);
    return $id;
}

function nbidter(){
    try
    {
	    $db = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
    $requete = $db->query ('SELECT COUNT(idOrg) as countid FROM organisme');
    $ligne = $requete->fetch();
    $id=($ligne['countid']+1);
    return $id;
}




function age($date) { 
    $today = date("Y-m-d");
    $age = date($date);
    $diff = date_diff(date_create($today), date_create($age));
    return $diff->format('%y');
} 