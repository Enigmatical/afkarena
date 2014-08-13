<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	
	//Decode the Hero ID (hid)
	$hid = decode( $_GET["hid"] );
	
	query("DELETE FROM heroes WHERE id = '{$hid}'");
	query("DELETE FROM explore WHERE hero_id = '{$hid}'");
	query("DELETE FROM battle WHERE hero_id = '{$hid}'");
	
	header("Location:/account/main.php");
?>