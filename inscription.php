<?php
// Include config file
require_once "cons.php";

// define variable

$username = $password = $confirm_password = $question = $reponse = $nom = $prenom = "";
$username_err = $password_err = $confirm_password_err = $question_err = $reponse_err = $nom_err = $prenom_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{

//username 
if(empty(trim($_POST["username"]))){//si vide alors
    $username_err = "SVP entrer un username";
}elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){//si le username existe mais mal entré
    $username_err = "le username peut contenir des chiffres, des lettres ou des underscores";
}else{
//preparer requete
$sql = "SELECT id FROM users WHERE username = ?";

if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("s", $param_username);
$param_username = trim($_POST["username"]);

if($stmt->execute()){ 
	
	$stmt->store_result();
	
if($stmt->num_rows == 1){
    $username_err = "username déjà pris";
}else{
    $username = trim($_POST["username"]);
}

}else{
    echo "oops!";
}

//fermer connection
$stmt->close();
}
}


//password
if(empty(trim($_POST["password"]))){
    $password_err = "entrez un mot de passe";
}elseif(strlen(trim($_POST["password"])) < 6){
    $password_err = "password superieur ou egale à 6 caractères";
}else{
    $password = trim($_POST["password"]);
}

//confirmation password
if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = "retapez votre mot de passe";
}else{
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
        $confirm_password_err = "mot de passe différent";
    }
}

//Question secrete
if(empty(trim($_POST["question"]))){
    $question = "Ecrivez votre question secrete";
}else{
    $question=($_POST["question"]);
}

//reponse a la question secrete

if(empty(trim($_POST["reponse"]))){
    $reponse = "Saisissez la reponse a la question secrete";
}else{
    $reponse=($_POST["reponse"]);
}

//nom de l´utilisateur

if(empty(trim($_POST["nom"]))){
    $nom_err = "Saisissez votre nom";
}else{
    $nom=($_POST["nom"]);
}


//prenom de l´utilisateur

if(empty(trim($_POST["prenom"]))){
    $prenom_err = "Saisissez votre prenom";
}else{
    $prenom=($_POST["prenom"]);
}



if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($question_err) && empty($reponse_err) && empty($nom_err) && empty ($prenom_err))

{

    //prepare ma requete d'insertion
    $sql = "INSERT INTO users (username, password, question, reponse, nom, prenom) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    if($stmt = $mysqli->prepare($sql)){
	    
        $stmt->bind_param("ssssss", $param_username, $param_password, $param_question, $param_reponse, $param_nom, $param_prenom);

        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_question=$question;
        $param_reponse=$reponse;
        $param_nom=$nom;
        $param_prenom=$prenom;
        
        //var_dump($stmt->execute());

        if($stmt->execute()){
            //redirection
            header("location: connexion.php");
        } else{
            echo "erreur";
        }

        $stmt->close();

    }
}
$mysqli->close();

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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container">


            <div class="essaie1">
                <label for="nom">Nom:</label><br><br>
                <input type="text" name="nom" id="nom" placeholder="Votre nom"><br><br>
                <span><?php echo  $nom_err; ?></span>
            </div>

            <div class="essaie2">
                <label for="prenom">Prenom:</label><br><br>
                <input type="text" name="prenom" id="prenom" placeholder="Votre prenom"><br><br>
                <span><?php echo  $prenom_err; ?></span>
            </div>
            
            <div class="essaie3">
                <label for="prenom">Pseudo:</label><br><br>
                <input type="text" name="username" id="username" placeholder="Votre pseudo" required><br><br>
                <span><?php echo  $username_err; ?></span>

            <div class="essaie4">
                <label for="password">Mot de passe:</label><br><br>
                <input type="password" name="password" id="password" placeholder="Votre mot de passe" required><br><br>
                <span><?php echo  $password_err; ?></span>
            </div>

            <div class="essaie5">
                <label for="confirm_password">Repeter Mot de passe:</label><br><br>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmez le mot de passe" required><br><br>
                <span><?php echo  $confirm_password_err; ?></span>
            </div>

            
            <div class="essaie6">
            <label for="question">Question secrete:</label><br><br>
                <input type="text" name="question" id="question" placeholder="Question secrete"><br><br>
                <span><?php echo  $question_err; ?></span>
            </div>

            <div class="essaie7">
                <label for="reponse">Reponse question secrete:</label><br><br>
                <input type="text" name="reponse" id="reponse" placeholder="Reponse a la question secrete"><br><br>
                <span><?php echo  $reponse_err; ?></span>
            </div>

            <div class="essaie8">
                <input type="radio" id="politique_confidentialité" required> <label for="politique">J´accepte la politique de confidentialite du site.</label><br><br>
            
             </div>
        
            <div class="essaie9">
                <input id="button" type="submit" value="Valider">
             </div>
            
        </div>
            
    </form>
    
</body>
</html>