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
		<div class="section" style="<?php bg('general/forge'); ?>">Forge Information</div>
		<div>
			<ul>
				<li>The <em>Forge</em> screen presents you with your Hero's current equipment:  <b>Weapon</b>, <b>Armor</b>, and <b>Trinket</b>.  Each piece of equipment affects one of your Hero's primary stats:  <b>Power</b>, <b>Armor</b>, and <b>Speed</b>, respectively.  Equipment also has secondary increases that are percentage based.</li>
				<li>Pressing one of the Equipment buttons will display the <em>Forge Options</em> for that item as well as the costs.  </li>
				<li>The <em>Forge Options</em> are further split into three sections:  <b>Forge</b>, <b>Minor Enchant</b>, and <b>Major Enchant</b>.  Each item requires a certain number of enchantments before it can be upgraded.  Enchantments cost Ore.  Minor Enchants cost common <b>Iron Ore</b> (gained from exploring and battle) while Major Enchants costs rare <b>Cobalt Ore</b> (mainly gained from completing Quests).  After the number of needed Enchantments has been fulfilled, the item will be ready to be upgraded which will cost a significant amount of <b>Gold</b>.</li>
				<li>There are <b>five upgrades</b> available for each item.</li>
			</ul>
		</div>
	</div>
	<div data-role="footer">
	</div>
</div>