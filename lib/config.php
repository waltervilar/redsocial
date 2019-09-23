<?php
$host = "localhost";
$dbuser = "root";
$dbpwd = "";
$db = "redsocial";
$connect_error = 'Sorry, we\'re experiencing connection issues.';

$connect = mysqli_connect($host, $dbuser, $dbpwd,$db);
	if(!$connect)
		echo ("No se ha conectado a la base de datos");
	else
		$select = mysqli_select_db ($connect,'redsocial') or die($connect_error) ;
?>