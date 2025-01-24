<?php
// include './App/Utils/';
// session_start();


// session_unset();

// session_destroy();


// header('Location:Controller_accueil.php');
// exit;
include '.App/Utils/Bdd.php';
session_start();



session_destroy();





header('Location:Controller_accueil.php');
exit;


