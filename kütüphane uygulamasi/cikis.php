<?php
session_start();
unset($_SESSION["kullaniciID"]);
header('Location: ansiklopedi.php');
exit;
?>