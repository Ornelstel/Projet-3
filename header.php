<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/header.css">
    <title>Document</title>
    <style>
        ul{
            list-style-type: none;
            overflow: hidden;
        }

        li{
            float: left;
            padding: 5px;
        }

        .navigation{
            float: right;
        }
    </style>
</head>
<body>
    <header>
    <img id="img1" src="assets/images/GBAF.JPG" alt="logo de GBAF">
        <nav class="navigation">
            
            <ul>
                <li><a href="compte.php"><img src="assets/images/parametre.png" alt="logo de parametre"></a></li>
                <li> Bienvenue <?php echo htmlspecialchars($_SESSION["username"]);?></li>
                <li> <a href="deconnexion.php">Deconnexion</a></li>
            </ul>
        </nav>
    </header> <hr>
</body> 

<header>
        