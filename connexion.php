<?php

if(isset($_SESSION["loggedin"]) == true){
  header("location: desktop.php"); 
  exit; 
}
$erreur="";
if(isset($_POST['password']) && isset($_POST['username'])){
        //connection a la base de donnees
        require_once "cons.php";
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        //  Récupération de l'utilisateur et de son pass hashé
        $req = $bdd->prepare('SELECT id, password,question,reponse FROM users WHERE username = :username');
        $req->execute(array(
            'username' => $username));
        $resultat = $req->fetch();

        // Comparaison du pass envoyé via le formulaire avec la base
        $isPasswordCorrect = password_verify($password, $resultat['password']);

        if (!$resultat)
        {
            $erreur ='Mauvais identifiant ou mot de passe !<br>';
        }
        else
        {
            if ($isPasswordCorrect) {
                //initialiser la section
                session_start();
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;
                $_SESSION['reponse'] = $resultat['reponse'];
                $_SESSION['question'] = $resultat['question'];
                header("location: desktop.php");
            }
            else {
                $erreur = 'Mauvais identifiant ou mot de passe !<br>';
            }
        }
        $req->closeCursor();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/connexion.css" type="text/css">
    <title>Document</title>
</head>
<body>
<header>
         <div class="img">
             <img src="assets/images/GBAF.JPG" alt="logo de GBAF">
         </div>
        <p>Le Groupement Banque Assurance Francais (GBAF)</p> 
    </header>
    <h2>Connexion</h2><br><br>
    <form method="post" action="connexion.php">
        <div class="container">
            
            <div class="essaie1">
                <label for="nom d´utilisateur">Nom d´utilisateur:</label><br><br>
                <input type="text" name="username" id="username" placeholder="Nom d´utilisateur" required><br><br>

            </div>

            <div class="essaie2">
                <label for="password">Mot de passe:</label><br><br>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required><br><br>
                <span style="color: red"><?php echo  $erreur ?></span>
            </div>

            <div class="essaie3">
                <input type="submit" value="Connexion" id="button">
             </div>

        </div>
        <div class="essaie2"><br>
        <label for="inscription"> Vous n'avez pas de compte? <a href="inscription.php"> Inscrivez vous ici</a><br><br>
        Mot de passe oublié? Recuperez le <a href="recuperation_mdp.php">Ici</a><br></label>

        </div>
    </form>
         
</body>
</html>