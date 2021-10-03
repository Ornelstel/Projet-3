<?php
session_start();
if(!isset($_SESSION["loggedin"])){
  header("location: connexion.php");
  exit;
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
//connection a la base de donnees
require_once "cons.php";
if(isset($_GET['id_acteur']) || isset($_GET['valeurVote'])){
   $id_acteur = htmlspecialchars($_GET['id_acteur']);
   $afficheFormulaire1 = "";
   $afficheFormulaire2 = "";
   $statutVote = "";
   $statutCommentaire = "Commenter";
   $desactiverLien = "";
   $desactiverLienCommentaire = "";

   // verifie si l#utilisateur a deja vote;
   $reponse = $bdd->query('SELECT vote FROM vote where vote.id_acteur ='.$id_acteur.' and vote.id_user='.$_SESSION['id']);
   $rows = $reponse->rowCount();
   $donnees = $reponse->fetch();

   if ($rows >0) {
        $statutVote = "déjà voté";
        $desactiverLien = "pointer-events: none; cursor: default;";
   }else if(isset($_GET['valeurVote'])){
        $valeurVote = htmlspecialchars($_GET['valeurVote']);
        if($rows == 0){
        // Insertion du vote à l'aide d'une requête préparée
        $req = $bdd->prepare('INSERT INTO vote (id_user, id_acteur, vote) VALUES(?, ?, ?)');
        $req->execute(array($_SESSION['id'], $id_acteur, $valeurVote));
        $statutVote = "déjà voté";
        $desactiverLien = "pointer-events: none; cursor: default;";
        }
   }
   //verifie si l#utilisateur a deja commenté
   $reponse = $bdd->query('SELECT post FROM post where post.id_acteur ='.$id_acteur.' and post.id_user='.$_SESSION['id']);
   $rows = $reponse->rowCount();
   $donnees = $reponse->fetch();

   if ($rows >0 ) {
       $statutCommentaire = "déjà commenté";
       $afficheFormulaire1 = "display: none;";
       $desactiverLienCommentaire = "pointer-events: none; cursor: default;";

   }else {
       $afficheFormulaire2 = "display: none;";
       if(isset($_POST['commentaire'])){
           $post = htmlspecialchars($_POST['commentaire']);
           if($rows == 0){
                 $req = $bdd->prepare('INSERT INTO post (id_user, id_acteur, date_add, post) VALUES(?, ?, ?, ?)');
                 date_default_timezone_set('Europe/Paris');
                 $date =  date('Y-m-d H:i:s');
                 $req->execute(array($_SESSION['id'], $id_acteur, $date, $post));
                 $statutCommentaire = "déjà commenté";
                 $afficheFormulaire1 = "display: none;";
                 $afficheFormulaire2 = "display: block;";
                 $desactiverLienCommentaire = "pointer-events: none; cursor: default;";
           }

       }
   }
     // requete pour compter les commentaires;
     $resultat = $bdd->query('SELECT * FROM post where id_acteur ='.$id_acteur.' ORDER BY date_add DESC');
     $totalCommentaire = $resultat->rowCount();

     $reponse = $bdd->query('SELECT * FROM acteur where id_acteur ='.$id_acteur);

     //Affichage l'acteur correspondant.
     while ($donnees = $reponse->fetch())
     {   //compter les like pour un acteur
         $select = $bdd->query('SELECT vote FROM vote where vote = 1 and id_acteur='.$id_acteur);
         $like = $select->rowCount();
         // compter les dislike pour un acteur
         $select = $bdd->query('SELECT vote FROM vote where vote = 0 and id_acteur='.$id_acteur);
         $dislike = $select->rowCount();
?>
     <article>
        <section id="section1">
            <div id=img1>
                <img src="assets/images/<?php echo $donnees['logo']?>" alt="Logo de l´entreprise formation&co" style="width:100%">
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
               <div class="textarea">
                   <div class="comment">
                        <textarea class="textinput" name="commentaire" placeholder="Votre commentaire...." form="usrform"></textarea>
                   </div>
               </div>
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

           //Afficher tous les commentaires
      while($donnees = $resultat->fetch()){
          $res= $bdd->query('SELECT vote.vote, users.prenom FROM vote join users on users.id=vote.id_user where vote.id_acteur='.$donnees['id_acteur'].' and users.id='.$donnees['id_user']);
          $info = $res->fetch();
          $vote = $info['vote'];

          if($res->rowCount() == 0){
             $vote = -1;
          }
               if($vote==0){
?>
                   <div style="border: 2px solid red;  border-radius: 5px;">
                   <img src="assets/images/dislike.png" alt="logo de l´entreprise formation_co">
<?php
               }
               else if($vote==1){
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
          <p for="date">Posté le :  <?php echo $donnees['date_add']; ?> et commenté par <span style="font-weight:bold"><?php echo $info['prenom']; ?></span>
          </p>
          <p for"commentaire"><?php echo $donnees['post']; ?></p>
          </div>
          <br>
<?php
$res->closeCursor();
}
?>
         </fieldset>
</article>

<div class="button">
    <a href="desktop.php"> Retour </a>
</div>
<?php

}
}
$reponse->closeCursor();
?>
</body>
</html>