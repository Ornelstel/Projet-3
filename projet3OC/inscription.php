<?php
// Include config file
require_once "cons.php";

// define variable

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST")
{


//username 
if(empty(trim($_POST["username"]))){//si vide alors
    $username_err = "SVP entrer un username";
}elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){//si existe mais mal entré
    $username_err = "le username peut contenir des chiffres des lettres ou des underscores";
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



if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{

    //prepare ma requete d'insertion
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    
    if($stmt = $mysqli->prepare($sql)){
	    
        $stmt->bind_param("ss", $param_username, $param_password);

        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        
        var_dump($stmt->execute());

        if($stmt->execute()){

die;
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
    <link rel="stylesheet" href="assets/css/inscription.css">
    <title>Document</title>
</head>
<body>
    <header>
        <img src="assets/images/GBAF.JPG" alt="logo de GBAF">
        <p>iLe Groupement Banque Assurance Francais (GBAF)</p> 
    </header>
    <h2>Inscription</h2><br><br>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container">
            
            <div class="essaie1">
                <label for="nom">Pseudo:</label><br><br>
                <input type="text" name="username" id="username" placeholder="Votre nom" required><br><br>
                <span><?php echo  $username_err; ?></span>
            </div>

            <div class="essaie4">
                <label for="mot de passe">Mot de passe:</label><br><br>
                <input type="password" name="password" id="password" placeholder="Votre password" required><br><br>
                <span><?php echo  $password_err; ?></span>
            </div>

            <div class="essaie5">
                <label for="mot de passe">Repeter Mot de passe:</label><br><br>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Votre password" required><br><br>
                <span><?php echo  $confirm_password_err; ?></span>
            </div>


            <div class="essaie9">
                <input type="submit" value="Valider" >
             </div>
        </div>
            
    </form>
    
</body>
</html>