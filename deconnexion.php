<?php
// La session
session_start();
// Fin de session
session_destroy();
header ('Location: index.php');
exit();
?>