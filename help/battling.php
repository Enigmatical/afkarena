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
		<div class="section" style="<?php bg('general/battle'); ?>">An Overview of Combat</div>
		<div>
			<ul>
				<li><em>Battling</em> in <b>AFK Arena</b> is an automatic process in which your Hero will takes turns exchanging attacks with a Monster until either one runs out of <b>Health</b>.</li>
				<li>During combat, <b>Abilities</b> can become activated resulting in either the Hero or the Monster gaining a buff or suffering a debuff, which will be displayed with an icon as well as a number for the amount of <b>stacks</b>.</li>
				<li>After combat, if the Hero is <em>Victorious</em>, he/she will be rewarded with <b>EXP</b>, <b>Gold</b>, and possibly one or more <b>Ores</b>.</li>
				<li>The Hero may also be rewarded with <b>Quest Items</b>, if needed.</li>
				<li>If the Hero is <em>Defeated</em>, he/she will regain consciousness in the <em>Lobby</em> with <b>25% Health</b>.</li>
				<li>The Hero will also have lost a significant amount of Loot obtained during that venture into the Dungeon.</li>
				<li>There are no other penalties for being <em>Defeated</em> <b>at this time</b>.
			</ul>
		</div>
	</div>
	<div data-role="footer">
	</div>
</div>