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
    <header>
        <img id="img1" src="assets/images/GBAF.JPG" alt="logo de GBAF">

        <nav class="navigation">
            
            <ul>
                <li><a href=""><img src="assets/images/param.png" alt="logo de parametre"></a></li>
                <li> Bienvenue <?php echo htmlspecialchars($_SESSION["nom"]);?></li>
                <li> <a href="deconnexion.php">Deconnexion</a></li>
            </ul>
            ssssssssssssssssss
        </nav>
    </header> <hr>

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
             <!--foreach avec ta table acteur-->
<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";

try {
  $bdd = new PDO("mysql:host=$servername;dbname=projet3", $username, $password);
  // set the PDO error mode to exception
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// Récupération des 10 derniers messages
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
            <img id="img2" src="assets/images/<?php echo $donnees['logo']?>" alt="logo de l´entreprise formation_co">
            <label><?php echo $donnees['acteur']?></label>
        </div>

        <p><?php echo $donnees['description']?></p>
    	<p><button><a href="acteur.php?id_acteur=<?php echo $donnees['id_acteur']?>">Lire la suite </a></button></p>
        <div class="vote">
           <img  src="assets/images/like.png" alt="logo de like">
           <label><?php echo $like; ?></label>
           <img src="assets/images/dislike.png" alt="logo de dislike">
           <label><?php echo $dislike; ?></label>
        </div>
   </section>
<?php
}

$reponse->closeCursor();

?>

</article>

</main><hr>


    <footer id="footer1">

            <span> | Mentions légales | Contact | </span>

    </footer>

</body>
</html>