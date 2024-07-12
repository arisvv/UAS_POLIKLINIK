<?php
session_start();
session_unset();
session_destroy();
header("Location: loginUser.php"); 
exit();
?>

