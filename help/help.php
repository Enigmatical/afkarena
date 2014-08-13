<?php
	include "../includes/config.php";
	include "../includes/functions.php";
	
	include "../includes/header.php"; 	
?>

<div id="help" data-role="page">
	<div data-role="header">
		<h1>&nbsp;</h1>
	</div>
	<div data-role="content">
		<div class="section" style="<?php bg('general/book'); ?>">Help</div>
		<div>
			<p>This help section is designed to get you up to speed quickly with the general cycle of the Arena so you can begin climbing the ladder to the top.</p>
			<div class="spacer"></div>
			<a href="/help/create_account.php?" data-role="button">Creating Your Account</a>
			<a href="/help/logging_in.php?" data-role="button">Logging Back In</a>
			<a href="/help/first_hero.php?" data-role="button">Creating Your First Hero</a>
			<a href="/help/tour_lobby.php?" data-role="button">A Tour of the Lobby</a>
		</div>
	</div>
	<div data-role="footer">
	</div>
</div>