<?php
session_start();
if (!isset($_SESSION['uid'])) header("Location: login.php");
?>
