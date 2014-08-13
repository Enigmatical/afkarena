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
		<div class="section" style="<?php bg('general/explore'); ?>">Explore Information</div>
		<div>
			<ul>
				<li>The Explore screen displays the Dungeons available to your Hero, based on his/her <b>Level</b>.</li>
				<li>Choosing a Dungeon will take you to the <em>Entrance</em> screen where you will learn about your current list of <b>Quests</b>.  Pressing <b>Enter</b> from here will begin your Hero's journey into the Dungeon.</li>
			</ul>
			<a href="/help/dig_dungeons.php?" data-role="button">Digging Into Dungeons</a>
			<a href="/help/battling.php?" data-role="button">An Overview of Combat</a>
		</div>
	</div>
	<div data-role="footer">
	</div>
</div>