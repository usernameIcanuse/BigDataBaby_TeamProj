<?php


session_start();

$_SESSION['NAME'] ="";
$_SESSION['TYPE'] ="";
$_SESSION['LOCATION'] ="";

$_SESSION['NAME'] =$_POST['NAME'];
$_SESSION['TYPE'] =$_POST['type'];
$_SESSION['LOCATION'] =$_POST['location'];

header('Location: ./Search.html');
?>