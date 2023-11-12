<?php


session_start();

$_SESSION['NAME'] ="";
$_SESSION['TYPE'] ="";
$_SESSION['CODE'] ="";

$_SESSION['NAME'] =$_POST['NAME'];
$_SESSION['TYPE'] =$_POST['type'];

header('Location: ./Search.html');
?>