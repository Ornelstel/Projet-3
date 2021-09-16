<?php
session_start();
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
    <header>
        <img src="assets/images/GBAF.JPG" alt="logo de l´entreprise GBAF">
    </header><hr>
<?php

if(isset($_GET['id_acteur']) || isset($_GET['valeurVote'])){
   $id_acteur = htmlspecialchars($_GET['id_acteur']);
   $afficheFormulaire1 = "";
   $afficheFormulaire2 = "";
   $statutVote = "";
   $statutCommentaire = "Commenter";
   $desactiverLien = "";
   $desactiverLienCommentaire = "";

   // verifie si l#utilisateur a deja vote;
   $reponse = $bdd->query('SELECT vote FROM vote where id_acteur='.$id_acteur.' and id_user='.$_SESSION['id']);
   if ($reponse->rowCount() > 0) {
        $statutVote = "déjà voté";
        $desactiverLien = "pointer-events: none; cursor: default;";
   }else if(isset($_GET['valeurVote'])){
        $valeurVote = htmlspecialchars($_GET['valeurVote']);
        // Insertion du vote à l'aide d'une requête préparée
        $req = $bdd->prepare('INSERT INTO vote (id_user, id_acteur, vote) VALUES(?, ?, ?)');
        $req->execute(array($_SESSION['id'], $id_acteur, $valeurVote));
        $statutVote = "déjà voté";
        $desactiverLien = "pointer-events: none; cursor: default;";
   }
   $reponse = $bdd->query('SELECT post FROM post where id_acteur='.$id_acteur.' and id_user='.$_SESSION['id']);
   if ($reponse->rowCount() > 0) {
       $statutCommentaire = "déjà commenté";
       $afficheFormulaire1 = "display: none;";
       $desactiverLienCommentaire = "pointer-events: none; cursor: default;";

   }else {

       $afficheFormulaire2 = "display: none;";
       if(isset($_POST['commentaire'])){
           $post = htmlspecialchars($_POST['commentaire']);
           $req = $bdd->prepare('INSERT INTO post (id_user, id_acteur, date_add, post) VALUES(?, ?, ?, ?)');
           $date =  date('Y-m-d H:i:s');
           $req->execute(array($_SESSION['id'], $id_acteur, $date, $post));
           $statutCommentaire = "déjà commenté";
           $afficheFormulaire1 = "display: none;";
           $afficheFormulaire2 = "display: block;";
           $desactiverLienCommentaire = "pointer-events: none; cursor: default;";
       }
   }
    // compter les commentaires;
    $reponse = $bdd->query('SELECT post FROM post where id_acteur='.$id_acteur);
    $totalCommentaire = $reponse->rowCount();


$reponse = $bdd->query('SELECT * FROM acteur where id_acteur='.$id_acteur);

//Affichage l'acteur correspondant.
while ($donnees = $reponse->fetch())
{
$select = $bdd->query('SELECT vote FROM  vote where vote = 1 and id_acteur='.$id_acteur.' and id_user='.$_SESSION['id']);
$like = $select->rowCount();

$select = $bdd->query('SELECT vote FROM  vote where vote = 0 and id_acteur='.$id_acteur.' and id_user='.$_SESSION['id']);
$dislike = $select->rowCount();
?>
<article>
        <section id="section1">
            <div id=img1>
                <img src="assets/images/<?php echo $donnees['logo']?>" alt="Logo de l´entreprise formation&co">
            </div>
            <p><?php echo $donnees['description']?></p>
        </section>
        </hr>
        <div id="conteneur">
           <div>
              <a style="<?php echo $desactiverLien; ?>" href="acteur.php?id_acteur=<?php echo $donnees['id_acteur']?>&valeurVote=1">
              <img  src="assets/images/like.png" alt="logo de l´entreprise formation_co"></a>
              <label><?php echo $like; ?></label>
              <a style="<?php echo $desactiverLien; ?>" href="acteur.php?id_acteur=<?php echo $donnees['id_acteur']?>&valeurVote=0">
              <img src="assets/images/dislike.png" alt="logo de l´entreprise formation_co"></a>
              <label><?php echo $dislike; ?></label>
              <label><?php echo $statutVote?></label>
           </div>
           <div style="<?php echo $afficheFormulaire1 ?>">
               <label>Commentaire</label>
               <form action="acteur.php?id_acteur=<?php echo $donnees['id_acteur']?>" id="usrform" method="post">
                 <textarea rows="6" cols="100" name="commentaire" placeholder="Votre commentaire...." form="usrform"></textarea>
                 <br>
                 <input type="submit">
               </form>
           </div>
           <div style="<?php echo $afficheFormulaire2; ?>" >
                <a style="<?php echo $desactiverLienCommentaire; ?>"href="acteur.php?id=<?php echo $donnees['id_acteur']?>">
                <img  src="assets/images/commentaire.png" alt="logo de pour commenter"></a>
                <label><?php echo $statutCommentaire?></label>
           </div>

          <div>
               <label><?php echo $totalCommentaire." "; ?>COMMENTAIRE(S)</label>
          </div>
        </div>
        <fieldset>
        <legend>Commentaires:</legend>
<?php
       $resultat = $bdd->query('SELECT * FROM post where id_acteur ='.$id_acteur.' ORDER BY date_add DESC');

       //Afficher tous les commentaires
       while ($donnee = $resultat->fetch())
       {
          $res= $bdd->query('SELECT vote FROM vote where id_acteur='.$id_acteur.' and id_user='.$donnee['id_user']);
          if($res->rowCount() == 0){
             $res= $bdd->query('SELECT -1 as vote  FROM vote where id_acteur='.$id_acteur);
?>
<?php
          }
?>
<?php
          while ($info = $res->fetch()){
               if($info['vote']==0){
?>
                   <div style="border: 2px solid red;  border-radius: 5px;">
                   <img src="assets/images/dislike.png" alt="logo de l´entreprise formation_co">
<?php
               }
               else if($info['vote']==1){
?>
                  <div style="border: 2px solid green;  border-radius: 5px;">
                  <img src="assets/images/like.png" alt="logo de l´entreprise formation_co">
<?php
               }else{
?>
                   <div style="border: 2px solid black;  border-radius: 5px;">
                   <img src="assets/images/vierge.png" alt="logo de l´entreprise formation_co">
<?php
               }
?>
          <p for="date">Posté le :  <?php echo $donnee['date_add']; ?>
          </p>
          <p for"commentaire"><?php echo $donnee['post']; ?></p>
          </div>
          <br>
<?php
       }
    }
?>
         </fieldset>
</article>
<?php
$reponse->closeCursor();
}
}
?>
</body>
</html>