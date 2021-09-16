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
        <img id="img1" src="assets/images/GBAF.jpg" alt="logo de GBAF">

        <nav class="navigation">
            
            <ul>
                <li> Bienvenue <?php echo htmlspecialchars($_SESSION["nom"]);?></li>
                <li> <a href="deconnexion.php">Deconnexion</a></li>
            </ul>
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
	    <section class="section1">
                <div>
                    <img id="img2" src="assets/images/formation_co.png" alt="logo de l´entreprise formation_co">
                </div>
			       <p>Formation&co est une association française présente sur tout le territoire.
                    Nous proposons à des personnes issues de tout milieu de devenir entrepreneur grâce à un
                     crédit et un accompagnement professionnel et personnalisé.....</p><br>
                    <p>
                        <button> <a href="acteur1.php" target=_blank>Lire la suite </a></button>
                    </p>
                    
                </div>

		</section>
           <!--foreach end  avec ta table acteur-->

		<section class="section1">
			   <div>
                    <img id="img3" src="assets/images/protectpeople.png" alt="logo de l´entreprise protectpeople">
			   </div>
               <p>Protectpeople finance la solidarité nationale.
                    Nous appliquons le principe édifié par la Sécurité sociale française en 1945 : 
                    permettre à chacun de bénéficier d’une protection sociale....</p>

                <p>
                    <button> <a href="acteur2.php" target=_blank>Lire la suite </a></button>
                </p>
		</section>

        <section class="section1">
			   <div>
                    <img id="img4" src="assets/images/CDE.png" alt="logo de l´entreprise CDE">
			   </div>
               <p>La CDE (Chambre Des Entrepreneurs)... </p>
               <p>
               <button> <a href="acteur3.php" target=_blank>Lire la suite </a></button>
               </p>
		</section>

        <section class="section1">
			   <div>
                       <img id="img5" src="assets/images/Dsa_france.png" alt="logo de l´entreprise Dsa_france">
			   </div>
               <p>Dsa France accélère la croissance du territoire et s’engage avec les collectivités territoriales.
                    Nous accompagnons les entreprises dans les étapes clés de leur évolution....</p>
                <p>
                    <button> <a href="acteur4.php" target=_blank>Lire la suite </a></button>
                </p>
		</section>
	   </article>

    </main><hr>


    <footer id="footer1">

            <span> | Mentions légales | Contact | </span>

    </footer>

</body>
</html>