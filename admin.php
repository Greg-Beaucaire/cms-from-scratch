<!-- PHP / Check User TYPE -->
<?php
// Initialiser la session
@ini_set("session.cookie_httponly", 1);
@ini_set("session.cookie_samesite", "Strict");
session_name("session_capu_la_stacked_666");
session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit();
}
//PREVISUALISATION
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
    <meta name="description" content="Page d'admin">
    <title>Page Admin</title>
    <meta charset="UTF-8"/>
    <!-- Robots -->
    <meta name="robots" content="no-index, no-follow">
    <!-- Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <!-- Links -->
    <link rel="stylesheet" type="text/css" href="src/css/admin.css"/>
</head>
<style>
    #previsualisation {
        background-color: <?php echo($resFront['background_color']);?>;
        color: <?php echo($resFront['font_color']);?>;
    }
</style>

<body>
    <!-- NAV BAR -->
    <nav id="hero_menu">
        <a href="index.php">Landing-Page</a>
        <a href="src/php/logout.php">Déconnexion</a>
    </nav>

    <?php
    // PAR ICI QU ON BOURRE LA DB
    // COLORS
    if(isset($_POST['colorForm'])){
        $backgroundColor = $_POST['background_color'];
        $fontColor = $_POST['font_color'];
        $linkColor = $_POST['link_color'];
        $hoverLinkColor = $_POST['hover_link_color'];

        try {
        $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
        $requete = "UPDATE `front_table` SET `background_color` = :background_color, `font_color` = :font_color, `link_color` = :link_color, `hover_link_color` = :hover_link_color";
        $prepare = $pdo->prepare($requete);
        $prepare->execute(array(
            ':background_color' => $backgroundColor,
            ':font_color' => $fontColor,
            ':link_color' => $linkColor,
            ':hover_link_color' => $hoverLinkColor
        ));
        $res = $prepare->rowCount();
    
        if ($res == 1) {
            echo "<p>Les couleurs ont été modifiées</p>";
            header("Location: admin.php");
        }
        } catch (PDOException $e) {
        exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        }
    }

    //CONTENT
    if(isset($_POST['contenuForm'])) {
        $intro = $_POST['intro'];
        $title = $_POST['titre'];
        $description = $_POST['description'];
        try {
        $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
        $requete = "UPDATE `front_table` SET `intro` = :intro, `title` = :title, `description` = :description;";
        $prepare = $pdo->prepare($requete);
        $prepare->execute(array(
            ':intro' => $intro,
            ':title' => $title,
            ':description' => $description
        ));
        $res = $prepare->rowCount();
    
        if ($res == 1) {
            header("Location: admin.php");
        }
        } catch (PDOException $e) {
        exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        }
    }

    //AJOUT LIEN
    if (isset($_POST['addLienForm'])) {
        $text = $_POST['text_lien'];
        $href = $_POST['url_lien'];
        try {
        $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
        $requete = "INSERT INTO `link` (`text`, `href`)
                    VALUES (:text, :href);";
        $prepare = $pdo->prepare($requete);
        $prepare->execute(array(
            ':text' => $text,
            ':href' => $href
        ));
        $res = $prepare->rowCount();
    
        if ($res == 1) {
            header("Location: admin.php");
        }
        } catch (PDOException $e) {
        exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        }
    }

    //MOD LIEN
    if (isset($_POST['modLienFormFinal'])) {
        $url = $_POST['urlMod'];
        $id = $_POST['idMod'];
        $text = $_POST['textMod'];
        try {
        $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
        $requete = "UPDATE `link` SET `href` = :href, `text` = :text WHERE `id` = :id;";
        $prepare = $pdo->prepare($requete);
        $prepare->execute(array(
            ':href' => $url,
            ':text' => $text,
            ':id' => $id
        ));
        $res = $prepare->rowCount();
    
        if ($res == 1) {
            header("Location: admin.php");
        }
        } catch (PDOException $e) {
        exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        }
    }

    //DELETE
    if (isset($_POST['suprLienForm'])) {
        $id = $_POST['supr_lien_id'];
        try {
        $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
        $requete = "DELETE FROM `link` WHERE `id` = :id;";
        $prepare = $pdo->prepare($requete);
        $prepare->execute(array(
            ':id' => $id
        ));
        header("Location: admin.php");
        } catch (PDOException $e) {
        exit("❌🙀❌ OOPS :\n" . $e->getMessage());
        }
    }
    //FIN DU BOURRAGE DE DB
    ?>

    <!-- PREVISUALISATION -->
    <div id="previsualisation">
        <div id="pres">
            <p><?php echo($resFront['intro']);?></p>
        </div>
        <div id="link__container">
            <?php 
                foreach($resLink as $key => $value) {
                ?>
                <div class="link__div">
                        <a target="blank" href="<?php echo($value["href"]);?>"><?php echo($value["text"]);?></a>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>

    <!-- PARTIE ADMIN -->
    <div id="panel_admin">
        <section>
            <h2>Couleurs</h2>
            <span class="line_section_panel"></span>
            <form action="admin.php" method="POST">
                <label for="background_color">Background-color</label>
                <input type="color" name="background_color" id="background_color" value="<?php echo($resFront['background_color']);?>">
                <label for="font_color">Font-color</label>
                <input type="color" name="font_color" id="font_color" value="<?php echo($resFront['font_color']);?>">
                <label for="link_color">Link-color</label>
                <input type="color" name="link_color" id="link_color" value="<?php echo($resFront['link_color']);?>">
                <label for="hover_link_color">Link-color on hover</label>
                <input type="color" name="hover_link_color" id="hover_link_color" value="<?php echo($resFront['hover_link_color']);?>">
                <input type="submit" name="colorForm" value="GO">
            </form>
        </section>
        <section>
            <h2>Contenu</h2>
            <span class="line_section_panel"></span>
            <form action="admin.php" method="POST">
                <label for="intro">Introduction</label>
                <input type="text" id="intro" name="intro" value="<?php echo($resFront['intro']);?>">
                <label for="titre">Titre de la page</label>
                <input type="text" id="titre" name="titre" value="<?php echo($resFront['title']);?>">
                <label for="description">Description (meta)</label>
                <input type="text" id="description" name="description" value="<?php echo($resFront['description']);?>">
                <input type="submit" name="contenuForm" value="GO">
            </form>
        </section>
        <section>
            <h2>Ajouter un lien</h2>
            <span class="line_section_panel"></span>
            <form action="admin.php" method="POST">
                <label for="url_lien">URL du lien</label>
                <input type="text" id="url_lien" name="url_lien">
                <label for="text_lien">Texte du lien</label>
                <input type="text" id="text_lien" name="text_lien">
                <input type="submit" value="GO" name="addLienForm">
            </form>
            <h2>Supprimer un lien</h2>
            <span class="line_section_panel"></span>
            <form action="admin.php" method="POST">
                <label for="supr_lien_id">Choisir le lien à supprimer</label>
                <select type="text" id="supr_lien_id" name="supr_lien_id">
                <?php
                    foreach($resLink as $key => $value){
                        echo("<option value='".$value['id']."'>".$value['text']."</option>");
                    }
                ?>
                </select>
                <input type="submit" value="GO" name="suprLienForm">
            </form>
            <h2>Modifier un lien</h2>
            <span class="line_section_panel"></span>
            <form action="admin.php" method="POST">
                <label for="mod_lien_id">Choisir le lien à modifier</label>
                <select name="mod_lien_id" id="mod_lien_id">
                    <?php
                    foreach($resLink as $key => $value){
                        echo("<option value='".$value['id']."'>".$value['text']."</option>");
                    }
                    ?>
                </select>
                <input type="submit" name="modLienForm" value="GO">
            </form>
            <?php
                if (isset($_POST['modLienForm'])) {
                    $id = $_POST['mod_lien_id'];
                    try {
                        $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                        $requete = "SELECT * FROM `link` WHERE id = :id;";
                        $prepare = $pdo->prepare($requete);
                        $prepare->execute(array(
                        ':id' => $id
                        ));
                        $resModLien = $prepare->fetch();
                    } catch (PDOException $e) {
                        exit("❌🙀❌ OOPS :\n" . $e->getMessage());
                        echo('<a href="index.html">Dégage</a>');
                    }
            ?>
                <form action="admin.php" method="POST">
                    <label for="urlMod">URL</label>
                    <input type="text" name="urlMod" id="urlMod" value="<?php echo($resModLien['href']);?>" required>
                    <label for="textMod">Texte du lien</label>
                    <input type="text" name="textMod" id="textMod" value="<?php echo($resModLien['text']);?>" required>
                    <input type="hidden" name="idMod" id="idMod" value="<?php echo($resModLien['id']);?>">
                    <input type="submit" name="modLienFormFinal" value="GO">
                </form>
            <?php
                }
            ?>
        </section>
    </div>
    <script src="src/js/app.js"></script>
</body>
</html>