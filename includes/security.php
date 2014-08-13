<?php
	if(!isset($_SESSION)) { session_start(); }
	
	if (!isset($_SESSION["hero_id"]))
	{
		if (isset($_SESSION["user_id"]))
		{
			header("Location:/account/main.php");
		} else {
			header("Location:/");
		}
	}
?>