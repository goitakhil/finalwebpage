<?php
session_start();

$_SESSION['loggedIn']= false;
unset ($_SESSION['loggedIn']);
session_destroy();
header('Location: index.php');
?>
