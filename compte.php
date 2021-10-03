<?php
session_start();
if(isset($_GET['username'])){
    $username = htmlspecialchars($_GET['username']);
    require_once "cons.php";
    $req = $bdd->prepare('UPDATE users set username = ? where id = ?');
    $req->execute(array($username,$_SESSION['id']));
    $_SESSION['username'] = $username;
}

if(isset($_GET['question'])){
    $question = htmlspecialchars($_GET['question']);
    require_once "cons.php";
    $req = $bdd->prepare('UPDATE users set question = ? where id = ?');
    $req->execute(array($username,$_SESSION['id']));
    $_SESSION['question'] = $question;
}

if(isset($_GET['reponse'])){
    $reponse = htmlspecialchars($_GET['reponse']);
    require_once "cons.php";
    $req = $bdd->prepare('UPDATE users set reponse = ? where id = ?');
    $req->execute(array($reponse,$_SESSION['id']));
    $_SESSION['reponse'] = $reponse;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/acteur.css">
    <title>Document</title>
</head>
<body>
    <?php
        include "header.php";
    ?>
    <article style="text-align: center">
            <section id="section1"><br>
            <form method="get" action="compte.php">
                <label>Votre pseudo:</label><br>
                <input name="username" value="<?php echo $_SESSION['username'];?>"><input type="submit" value="Modifier" id="button"><br>
                <label>Votre question:</label><br>
                <input name="question" value="<?php echo $_SESSION['question'];?>"><input type="submit" value="Modifier" id="button"><br>
                <label>Votre Reponse:</label><br>
                <input name="reponse" value="<?php echo $_SESSION['reponse'];?>"><input type="submit" value="Modifier" id="button"><br><br>
               <input type="submit" value="Tout Modifier" id="button">
               <p></p>
            </form>
            </section>
    </article>

    <div class="button">
    <a href="desktop.php"> Retour </a>
</div>
</body>