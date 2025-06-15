<?php
session_start();
session_destroy();
header('Location: ../view/V.login.php');
exit();
?>
