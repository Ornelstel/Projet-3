<?php
try{
    $bdd=new PDO('mysql:host=localhost; dbname=test;', 'root', '');
}

catch(Exeption $e){
    die('Erreur : '.$e->getMessage());
}
    
$reponse=$bdd->query('SELECT possesseur FROM jeux_video');

while($données=$reponse->fetch()){
?>

<p><strong>Jaime bien le joueur <?php echo $données['possesseur']; ?> car il peut avoir jusqu´a <?php echo $données['nbre_joueurs_max']; ?> 
au maximum</strong></p>
<?php
}

$reponse->closeCursor();


?>
