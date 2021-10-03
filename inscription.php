<?php
if(isset($_SESSION["loggedin"])){
    header("location: desktop.php");
    exit;
}
$erreur = "";
if(isset($_POST['reponse']) && isset($_POST['question']) && isset($_POST['confirm_password']) && isset($_POST['password']) && isset($_POST['username'])&& isset($_POST['nom']) && isset($_POST['prenom'])&& isset($_POST['politique'])){

   $confirm_password = htmlspecialchars($_POST['confirm_password']);
   $password = htmlspecialchars($_POST['password']);
   if($password != $confirm_password){
        $erreur = "Les Mots de passe ne correspondent <br>" ;
   }else{
   // connexion a la base de donnees
   require_once "cons.php";

   $reponse = htmlspecialchars($_POST['reponse']);
   $question = htmlspecialchars($_POST['question']);
   $username = htmlspecialchars($_POST['username']);
   $nom = htmlspecialchars($_POST['nom']);
   $prenom = htmlspecialchars($_POST['prenom']);
   // Vérification de la validité des informations

   // Hachage du mot de passe
   $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);

   // Insertion
   $req = $bdd->prepare('INSERT INTO users(nom, prenom, reponse, username, password, question, created_at) VALUES(:nom, :prenom, :reponse, :username, :password, :question, CURDATE())');
   $req->execute(array(
       'nom' =>  $nom,
       'prenom' =>  $prenom,
       'reponse' =>  $reponse,
       'username' => $username,
       'password' => $pass_hache,
       'question' => $question));
   header("location: connexion.php");
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/inscription.css" type="text/css" >
    <title>Document</title>
</head>
<body>
    <header>
         <div class="img">
             <img src="assets/images/GBAF.JPG" alt="logo de GBAF">
         </div>
        <p>Le Groupement Banque Assurance Francais (GBAF)</p> 
    </header>
    <h2>Inscription</h2><br><br>
    <form method="post" action="inscription.php">
        <div class="container">
            <div class="essaie3">
                <label for="nom">Nom:</label><br><br>
                <input type="text" name="nom" id="nom" placeholder="Votre nom" required><br><br>

            <div class="essaie4">
                <label for="prenom">Prenom:</label><br><br>
                <input type="text" name="prenom" id="prenom" placeholder="Votre prenom" required><br><br>
            </div>
            <div class="essaie3">
                <label for="prenom">Pseudo:</label><br><br>
                <input type="text" name="username" id="username" placeholder="Votre pseudo" required><br><br>

            <div class="essaie4">
                <label for="password">Mot de passe:</label><br><br>
                <input type="password" name="password" id="password" placeholder="Votre mot de passe" required><br><br>
            </div>

            <div class="essaie5">
                <label for="confirm_password">Repeter Mot de passe:</label><br><br>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmez le mot de passe" required><br><br>

            </div>

            <div class="essaie6">
            <label for="question">Question secrete:</label><br><br>
                <input type="text" name="question" id="question" placeholder="Question secrete"><br><br>

            </div>

            <div class="essaie7">
                <label for="reponse">Reponse question secrete:</label><br><br>
                <input type="text" name="reponse" id="reponse" placeholder="Reponse a la question secrete"><br><br>
                <span style="color: red;"><?php echo  $erreur; ?></span>
            </div>

            <div class="essaie8"><br>
                <input type="radio" name="politique" id="politique_confidentialité" required> <label for="politique">J´accepte la politique de confidentialite du site.</label><br><br>
            
             </div>

            <div class="essaie9">
                <input id="button" type="submit" value="Valider">
             </div>
            
        </div>
    </form>
</body>
</html>