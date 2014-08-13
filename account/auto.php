<?php
	include "../includes/functions.php";

	if(!isset($_SESSION)) { session_start(); }
	$userid = decode($_GET["u"]);
	$_SESSION["user_id"] = $userid;
	header("Location:/account/main.php");
?>