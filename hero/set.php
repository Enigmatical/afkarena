<?php
	if(!isset($_SESSION)) { session_start(); }
	
	if (!isset($_SESSION["user_id"]))
	{
		header("Location:/");
	}
	
	include "../includes/config.php";
	include "../includes/functions.php";	
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	
	//Decode the Hero ID ("hid")
	$hid = decode( $_GET["hid"] );
	
	//Set Hero ID in SESSION
	$_SESSION["hero_id"] = $hid;
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	if ($hero->get_BattleId())
	{
		header("Location:/battle/engage.php");
		exit;
	}	
	
	if ($hero->get_ExploreId())
	{
		header("Location:/explore/dungeon.php");
		exit;
	}
	
	header("Location:/lobby/main.php");
?>