<?php
//initialise la session
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php"); 
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
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            $param_username = $username;

            if($stmt->execute()){                
            $stmt->store_result();

            if($stmt->num_rows == 1){
                
                $stmt->bind_result($id, $username, $hashed_password);
                if($stmt->fetch()){
                    if(password_verify($password, $hashed_password)){
                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        header("location: index.php");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/connexion.css" type="text/css" >
    <title>Document</title>
</head>
<body>
    <h2>Connexion</h2><br><br>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container">
            
            <div class="essaie1">
                <label for="nom d´utilisateur">Nom d´utilisateur:</label><br><br>
                <input type="text" name="username" id="username" placeholder="Nom d´utilisateur" required><br><br>
                <span><?php echo  $username_err; ?></span>
            </div>

            <div class="essaie2">
                <label for="mdp">Mot de passe:</label><br><br>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required><br><br>
                <span><?php echo  $password_err; ?></span>
            </div>

            <div class="essaie3">
                <input type="submit" value="Login">
             </div>
         </div>
         Vous n'avez pas de compte?<a href="inscription">inscription</a>
         </form>
         
</body>
</html>