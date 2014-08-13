<?php
	/*  
	##########
	#  WORK  #
	##########

	
	$db_host = "localhost";
	$db_name = "afk_arena-dev";
	$db_user = "root";
	$db_pass = "";
	*/
	
	/*
	##########
	#  HOME  #
	##########
	
	$db_host = "localhost";
	$db_name = "afk_arena-dev";
	$db_user = "root";
	$db_pass = "";
	*/
	
	/*
	##########
	#  LIVE  #
	##########
	*/
	
	$db_host = "localhost";
	$db_name = "enigmati_afkarena";
	$db_user = "enigmati_chris";
	$db_pass = "gatorDB313231";
	
	$connect = mysql_connect($db_host, $db_user, $db_pass, true);	
	mysql_select_db($db_name, $connect);
?>