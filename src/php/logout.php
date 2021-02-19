<?php
@ini_set("session.cookie_httponly", 1);
@ini_set("session.cookie_samesite", "Strict");
session_name("session_capu_la_stacked_666");
session_start();
session_destroy();
unset($_SESSION['login']);

if (!empty($_SESSION)) $_SESSION = [];
if (isset($_COOKIE[session_name()])) setcookie(session_name(), "", time()-1, "/");

header('location: ../../index.php');
?>