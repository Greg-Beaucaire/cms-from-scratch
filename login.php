<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Title -->
    <meta name="description" content="Page de login">
    <title>Login - Admin</title>
    <meta charset="UTF-8"/>
    <!-- Robots -->
    <meta name="robots" content="no-index, no-follow">
    <!-- Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <!-- Links -->
    <link rel="stylesheet" type="text/css" href="src/css/login.css"/>
</head>
<body>
    <?php
        include('src/php/connectDB.php');
        @ini_set("session.cookie_httponly", 1);
        @ini_set("session.cookie_samesite", "Strict");
        session_name("session_capu_la_stacked_666");
        session_start();

        if (isset($_POST['loginCheck'])){
            $login = $_POST['login'];
            $mdp = $_POST['mdp'];
            $mdp = hash('sha1', $mdp);

            try{
                $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
                $requete = "SELECT * FROM user";
                $prepare = $pdo->prepare($requete);
                $prepare->execute();
                $user = $prepare->fetch();
                if($mdp == $user['password']){
                    $_SESSION['login'] = $login;
                    header("Location: admin.php");
                } else {
                    ?>
                    <form action="login.php" method="post">
                        <label for="login">Login</label>
                        <input type="text" id="login" name="login" required>
                        <label for="mdp">Password</label>
                        <input type="password" id="mdp" name="mdp" required>
                        <input type="submit" value="Connect" name="loginCheck">
                        <label style="font-size: 2rem; margin-top: 4rem;">Login ou password erroné</label>
                    </form>
                    <?php
                }
                
            }
            catch (PDOException $e){
                exit("❌🙀❌ OOPS :\n" . $e->getMessage());
            }
        } else {
            ?>
            <form action="login.php" method="post">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required>
                <label for="mdp">Password</label>
                <input type="password" id="mdp" name="mdp" required>
                <input type="submit" value="Connect" name="loginCheck">
            </form>
            <?php
        }
    ?>
</body>
</html>