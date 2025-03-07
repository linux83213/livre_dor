<?php
session_unset();
session_destroy();
header("Location: ./files/login.php");
exit();
?>