<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
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
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" >
</head>
<body>
    <header>
        <span>HEADER</span>
    </header>
        <nav class="navigation">
            <span>NAV</span>
            <ul>
                <li> <a href="#">LIEN 1</a></li>
                <li> <a href="#">LIEN 1</a></li>
                <li> <a href="#">LIEN 1</a></li>
                <li> <a href="#">LIEN 1</a></li>
                <li> <?php echo htmlspecialchars($_SESSION["username"]);?> bienvenue</li>
                <li> <a href="deconnexion.php">Deconnexion</a></li>
            </ul>
        </nav>
    <main>
    <p>MAIN</p>

    <article>
        <span>ARTICLE</span>
        <section>
            <span>SECTION</span>
            <p>HEADER: Article 1</p>
            <div class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae rem magnam cupiditate repellat porro modi 
                nostrum error veritatis eaque reprehenderit voluptates corporis voluptas velit vero maxime, magni, vel natus iusto? 
                Incidunt eius voluptates, in fugiat amet molestiae! Quo eveniet in, distinctio temporibus minima fuga dolorem veritatis, 
                provident et facilis natus sunt necessitatibus ab illo doloremque doloribus eligendi commodi adipisci alias ad itaque! Ad
                , debitis cupiditate in soluta aliquid ipsum optio eveniet earum velit impedit incidunt dolorum. Quasi odio excepturi quam
                 quos officia maiores cumque illo repellat minus sequi, laborum vitae quidem placeat obcaecati ea incidunt debitis magnam
                  repellendus, accusantium dignissimos? Magni accusantium enim numquam iusto, nobis nemo cupiditate ducimus officiis molestias
                   officia aperiam natus repellat dolorem error unde exercitationem voluptatum dignissimos commodi minima? Ab accusantium inventore 
                   eum velit nam magnam sint pariatur exercitationem at, voluptates sed rerum sit doloremque iusto, cupiditate distinctio id hic dicta 
                   atque sapiente! Molestias, possimus suscipit. Numquam, recusandae quas ab esse veniam sit temporibus incidunt iure ducimus alias
                    distinctio voluptate similique fugiat aliquid quis? Eius libero tempora aperiam sed, laboriosam assumenda voluptatibus nesciunt
                     labore optio incidunt consectetur error ea recusandae
                 numquam delectus culpa dolore qui, mollitia officia nihil beatae! Odit non quisquam autem quis libero natus!</div>
            <div class="section-footer">FOOTER</div>
        </section>
        <section>
            <span>SECTION</span>
            <p>HEADER: Article 1</p>

            <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae rem magnam cupiditate repellat porro modi 
                nostrum error veritatis eaque reprehenderit voluptates corporis voluptas velit vero maxime, magni, vel natus iusto? 
                Incidunt eius voluptates, in fugiat amet molestiae! Quo eveniet in, distinctio temporibus minima fuga dolorem veritatis, 
                provident et facilis natus sunt necessitatibus ab illo doloremque doloribus eligendi commodi adipisci alias ad itaque! Ad
                , debitis cupiditate in soluta aliquid ipsum optio eveniet earum velit impedit incidunt dolorum. Quasi odio excepturi quam
                 quos officia maiores cumque illo repellat minus sequi, laborum vitae quidem placeat obcaecati ea incidunt debitis magnam
                  repellendus, accusantium dignissimos? Magni accusantium enim numquam iusto, nobis nemo cupiditate ducimus officiis molestias
                   officia aperiam natus repellat dolorem error unde exercitationem voluptatum dignissimos commodi minima? Ab accusantium inventore 
                   eum velit nam magnam sint pariatur exercitationem at, voluptates sed rerum sit doloremque iusto, cupiditate distinctio id hic dicta 
                   atque sapiente! Molestias, possimus suscipit. Numquam, recusandae quas ab esse veniam sit temporibus incidunt iure ducimus alias
                    distinctio voluptate similique fugiat aliquid quis? Eius libero tempora aperiam sed, laboriosam assumenda voluptatibus nesciunt
                     labore optio incidunt consectetur error ea recusandae
                 numquam delectus culpa dolore qui, mollitia officia nihil beatae! Odit non quisquam autem quis libero natus!</div>
        </section>
    </article>
    <aside>
        <span>SIDEBAR</span>
        <div class="aside1">
            <span>ASIDE 1</span></div>
        <h4>TITTLE 1</h4>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing.</p>
    </aside>

    <aside>
        <div class="aside2">
            <span>ASIDE 2</span></div>
        <h4>TITTLE 2</h4>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing.</p>
    </aside>
    </main>
    <footer>
        <div class="mon-footer">
        <span>FOOTER</span>
        </div>
    </footer>
</body>
</html>