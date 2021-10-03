<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: connexion.php"); 
    exit; 
  }

  //function qui va recuperer ta table acteur
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/desktop.css">
    <title>Document</title>
</head>
<body>
   <?php
        include "header.php";
   ?>

    <main>
        <span>PRESENTATION DES ACTEURS</span>
        <section>
            <p>Le Groupement Banque Assurance Français (GBAF) est une fédération
                représentant les 6 grands groupes français :<br><br>
                ● BNP Paribas ;<br>
                ● BPCE ;<br>
                ● Crédit Agricole ;<br>
                ● Crédit Mutuel-CIC ;<br>
                ● Société Générale ;<br>
                ● La Banque Postale.<br><br>
                Même s’il existe une forte concurrence entre ces entités, elles vont toutes travailler
                de la même façon pour gérer près de 80 millions de comptes sur le territoire
                national.
                Le GBAF est le représentant de la profession bancaire et des assureurs sur tous
                les axes de la réglementation financière française. Sa mission est de promouvoir
                l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des pouvoirs publics. </p>
        </section><hr>

        <article>
	         <span>LES ACTEURS ET PARTENAIRES</span>

<?php
// Connexion à la base de données
require_once "cons.php";

$reponse = $bdd->query('SELECT * FROM acteur');

// Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
while ($donnees = $reponse->fetch())
{

$select = $bdd->query('SELECT vote FROM  vote where vote = 1 and id_acteur='.$donnees['id_acteur'].' and id_user='.$_SESSION['id']);
$like = $select->rowCount();

$select = $bdd->query('SELECT vote FROM  vote where vote = 0 and id_acteur='.$donnees['id_acteur'].' and id_user='.$_SESSION['id']);
$dislike = $select->rowCount();
?>
   <section class="section1">
        <div>
            <img id="img2" src="assets/images/<?php echo $donnees['logo']?>" alt="logo de l´acteur">
            <label><?php echo $donnees['acteur']?></label>
        </div>

        <p><?php echo $donnees['description']?></p>
    	<p><button><a href="acteur.php?id_acteur=<?php echo $donnees['id_acteur']?>">Lire la suite </a></button></p>
   </section>
<?php
}

$reponse->closeCursor();

?>

</article>

</main><hr>


    <footer id="footer1">

             <a href="#"> Mentions légales </a> | <a href="#"> Contact </a>

    </footer>