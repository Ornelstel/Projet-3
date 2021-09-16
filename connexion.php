<?php
//initialise la session
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: desktop.php"); 
  exit; 
}

require_once "cons.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //check username
    if(empty(trim($_POST["username"]))){
        $username_err = "entrer un username";
    }else{
        $username = trim($_POST["username"]);
    }

    //check mot de passe
    if(empty(trim($_POST["password"]))){
        $password_err = "entrer un mot de passe";
    }else{
        $password = trim($_POST["password"]);
    }


    if(empty($username_err) && empty($password_err)){
        //prepare ma requete
        $sql = "SELECT id, nom, username, password FROM users WHERE username = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            $param_username = $username;

            if($stmt->execute()){                
            $stmt->store_result();

// var_dump($user);
// die;

            if($stmt->num_rows == 1){
                
                $stmt->bind_result($id, $nom, $username, $hashed_password);
                if($stmt->fetch()){
                    if(password_verify($password, $hashed_password)){
                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["nom"] = $nom;

                        header("location: desktop.php");
                    }else{
                        $login_err = "login invalide";
                    }
                
                }
             } else{
                        $login_err = "login invalide";
                }
            }else{
                echo "oops! erreur";
            }

                $stmt->close();
            }  
    }
    $mysqli->close();
}

?>



<?php



    if(isset($_POST['password'], $_POST['pseudo'])){
        $stmt=$dbb->prepare('SELECT password from users WHERE pseudo = ?');
        $stmt->execute([$_POST['pseudo']]);
        $hashedpassword=$stmt->fetchColumn();

        if(password_verify($_POST['password'], $hashedpassword)){
            echo 'Connexion reussie';
        }
        else{
            echo 'Mot de passe incorrect';
        }
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container">
            
            <div class="essaie1">
                <label for="nom d´utilisateur">Nom d´utilisateur:</label><br><br>
                <input type="text" name="username" id="username" placeholder="Nom d´utilisateur" required><br><br>
                <span><?php echo  $username_err; ?></span>
            </div>

            <div class="essaie2">
                <label for="password">Mot de passe:</label><br><br>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required><br><br>
                <span><?php echo  $password_err; ?></span>
            </div>

            <div class="essaie3">
                <input type="submit" value="Connexion" id="button">
             </div>
         </div>
         Vous n'avez pas de compte? <a href="inscription"> Inscrivez vous ici</a><br><br>
         Mot de passe oublié? Créer un nouveau <a href="recuperation_mdp.php">Ici</a><br>

         </form>
         
</body>
</html>