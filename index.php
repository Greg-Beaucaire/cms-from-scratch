<?php
    //CONNEXION A LA DB
    include('src/php/connectDB.php');
    //RECUPERATION DES TABLES
    try {
        $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
        $requete = "SELECT * FROM `front_table`;";
        $prepare = $pdo->prepare($requete);
        $prepare->execute();
        $resFront = $prepare->fetch();
    } catch (PDOException $e) {
        exit("❌🙀❌ OOPS :\n" . $e->getMessage());
    }

    try {
        $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
        $requete = "SELECT * FROM `link`;";
        $prepare = $pdo->prepare($requete);
        $prepare->execute();
        $resLink = $prepare->fetchAll();
    } catch (PDOException $e) {
        exit("❌🙀❌ OOPS :\n" . $e->getMessage());
    }
      
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Title -->
    <meta name="description" content="<?php echo($resFront['description']);?>">
    <title>
        <?php echo($resFront['title']);?>
    </title>
    <meta charset="UTF-8"/>
    <!-- Robots -->
    <meta name="robots" content="index, follow">
    <!-- Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <!-- Links -->
    <link rel="stylesheet" type="text/css" href="src/css/style.css"/>
</head>

<!-- Balise de style pour récupérer les variables -->
<style>
    body {
        background-color: <?php echo($resFront['background_color']);?>;
        color: <?php echo($resFront['font_color']);?>;
    }
    body a {
        color: <?php echo($resFront['link_color']);?>;
    }
    body a:hover {
        color: <?php echo($resFront['hover_link_color']);?>;
    }
</style>

<body>
    <div id="pres">
        <p><?php echo($resFront['intro']);?></p>
    </div>
    <div id="link__container">
        <?php 
            foreach($resLink as $key => $value) {
               ?>
               <div class="link__div">
                    <a href="<?php echo($value["href"]);?>" target="blank"><?php echo($value["text"]);?></a>
                </div>
                <?php
            }
        ?>
    </div>
</body>
</html>