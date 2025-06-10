<?php
session_start();
if ($_GET['action']=='remove') unset($_SESSION['cart'][$_GET['id']]);
if ($_GET['action']=='clear') $_SESSION['cart'] = [];
header("Location:viewCart.php");
