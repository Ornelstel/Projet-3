<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/header.css">
    <title>Document</title>
</head>
<body>
    <header>
        <img id="img1" src="assets/images/GBAF.jpg" alt="logo de GBAF">

        <nav class="navigation">
            
            <ul>
                <li> Bienvenue <?php echo htmlspecialchars($_SESSION["nom"]);?></li>
                <li> <a href="deconnexion.php">Deconnexion</a></li>
            </ul>
        </nav>
    </header> <hr>