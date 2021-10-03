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
    <h2>Modifier votre mot de passe</h2><br><br>
<?php
   // Connexion à la base de données
    require_once "cons.php";
    $displayForm2="display: none";
    $displayForm3="display: none";
    $displayForm="";
    $reponse_server ="";
    if(isset($_POST['username']) && isset($_POST['question']) && isset($_POST['reponse']))
    {
        $username = htmlspecialchars($_POST['username']);
        $question = htmlspecialchars($_POST['question']);
        $reponse = htmlspecialchars($_POST['reponse']);

        $reponse = $bdd->query("SELECT id,password FROM users where username='".$username."' and question='".$question."' and reponse ='".$reponse."'");
        $id=0;
        if($reponse->rowCount()==0){
            $reponse_server ="La Question ou la reponse ne correspondent pas <br><br> ou bien n'existent tout simplement pas";
        }else if($reponse->rowCount()==1){
             while ($donnees = $reponse->fetch()){
                 $displayForm="display: none;";
                 $displayForm2="display: block;";
                 $id=$donnees['id'];
             }
        }
    }else if(isset($_POST['newpassword']) && isset($_POST['id'])){
        $newpassword = htmlspecialchars($_POST['newpassword']);
        $id = htmlspecialchars($_POST['id']);
        $hashed = password_hash($newpassword, PASSWORD_DEFAULT);
        // Insertion du vote à l'aide d'une requête préparée
        $req = $bdd->prepare('UPDATE users set password = ? where id = ?');
        $req->execute(array($hashed,$id));
        $displayForm3="display: block;";
        $displayForm="display: none;";
        $reponse_server = "Votre mot de passe a été actualisé. <br><br> connectez vous a nouveau";
    }

?>
    <form style="<?php echo $displayForm;?>" method="post" action="recuperation_mdp.php">
        <div class="container">

            <div class="essaie1">
                <label for="nom d´utilisateur">Nom d´utilisateur:</label><br><br>
                <input type="text" name="username" id="username" placeholder="Nom d´utilisateur" required><br><br>
            </div>

            <div class="essaie1">
                <label for="question">Question secrete:</label><br><br>
                <input type="text" name="question" id="question" placeholder="Question secrete" required><br>
            </div>

            <div class="essaie3">
                <label for="reponse">Reponse:</label><br><br>
                <input type="text" name="reponse" id="reponse" placeholder="Reponse a la qquestion secrete" required><br><br>
            </div>
            <div class="essaie3">
                <label style="color: red;" for="reponse-server"><?php echo $reponse_server; ?></label>
            </div>
            <div class="essaie3">
                <input type="submit" value="Envoyer" id="button">
             </div>
         </div>
    </form>

    <form style="<?php echo $displayForm2;?>" method="post" action="recuperation_mdp.php">
            <div class="container">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <div class="essaie1">
                    <label for="nom d´utilisateur">Nouveau mot de passe:</label><br><br>
                    <input type="password" name="newpassword" id="newpassword" required><br><br>
                </div>
                <div class="essaie3">
                     <label style="color: red;"for="reponse-server"><?php echo $reponse_server; ?></label>
                </div>

                <div class="essaie3">
                    <input type="submit" value="Envoyer" id="button">
                 </div>
             </div>
    </form>

    <form style="<?php echo $displayForm3;?>" method="post" action="recuperation_mdp.php">
                <div class="container">
                    <div class="essaie3">
                         <label style="color: red;" for="reponse-server"><?php echo $reponse_server; ?></label>
                    </div>

                    <div class="essaie3">
                        <a href="connexion.php">OK</a>
                     </div>
                 </div>  
    </form>
                <div class="button">
                    <a href="connexion.php"> Retour </a>
                 </div>
</body>
</html>