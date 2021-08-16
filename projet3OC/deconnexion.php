<?php
session_start();

$_SESSION = array(); //regroupe mes variables session dans un tableau

session_destroy();//je détruis mon tableau 

header("location: connexion.php");
exit;
?>