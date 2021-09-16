<?php
session_start();
include"header.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/commentaires.css">
</head><br><br>
<body>

        
    
        <form action="" method="POST" class="container">
            <label for="commentaires" class="commentaires">Vous pouvez laisser votre commentaire ici:</label><br><br>
            <textarea name="commentaires" cols="100" rows="20"></textarea><br><br>
            <input type="submit" value="Envoyer" class="button">
            <div class="vote">
           <img  src="assets/images/like.png" alt="J´aime">
           <label>24</label>
           <img src="assets/images/dislike.png" alt="Je n´aime pas">
           <label>24</label>
        </div>
        </form>
   
    <?php
    include "footer.php";
    ?>
</body>
</html>