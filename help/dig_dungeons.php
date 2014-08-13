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
		<div class="section" style="<?php bg('general/minion'); ?>">Digging Into Dungeons</div>
		<div>
			<ul>
				<li>After choosing a specific Dungeon, you will be taken to the <em>Entrance</em> screen.  This screen allows you to review your Hero's current <b>Quests</b>.  You can also review the details and progress of each <b>Quest</b> by pressing the <b>Quest Log</b> button at the bottom.  Press <b>Enter</b> to advance to the first floor of the <em>Dungeon</em>.</li>
				<li><b>Quests</b> are your Hero's primary means to gather <b>EXP</b>, <b>Gold</b>, and <b>Ores</b>.  They are divided into <b>Ranks</b> (10 for each Dungeon) and each <b>Quest Rank</b> consists of three types of Quests:  <b>Gather</b>, <b>Mark</b>, and <b>Depth</b>.<ul>
				<li><b>Gather Quests</b> require your Hero to obtain certain items off the Monsters he/she defeats.</li>
				<li><b>Mark Quests</b> require your Hero to search for a <em>Unique, Nefarious Monster</em> and defeat it.  <em>Nefarious Monsters</em> are located at certain depths in the Dungeon.</li>
				<li><b>Depth Quests</b> require your Hero to reach a certain number of <em>Floors</em> deep in a Dungeon and <b><em>escape successfully</em></b>.</li></ul></li>
				<li>Exploring Dungeons consist of two buttons:  <b>Advance</b> or <b>Retreat</b>.  Each time your Hero advances the <b>Floor Counter</b> increases by <b>1</b> and a random event can occur whether that be <em>encountering a Monster</em>, <em>stumbling upon a treasure chest</em>, <em>getting caught in a trap</em>, or <em>simply nothing at all</em>.  Each time your Hero retreats, the <b>Floor Counter</b> decreases by <b>5</b> and a random event can also occur, but is limited to <em>Monster Encounters</em> and <em> Dangerous Traps</em>.</li>
				<li>To Escape a Dungeon, the <b>Floor Counter</b> must be less than <b>5</b>.</li>
				<li>Successfully escaping a Dungeon will reward the Hero will all loot acquired in that session.  However, if the Hero is defeated, he/she will only recieve <b><em>partial</em></b> rewards <b>(50% Gold, 25% Ore)</b>.</li>
				<li>In later Dungeons, an additional event called a <em>Streak</em>.  <em>Streaks</em> consist of a series of <b>Floors</b> that increase the odds of <em>getting more treasure (Green)</em> or <em>encounter much tougher monsters (Red)</em>.  Retreating during a <em>Streak</em> immediately cancels the effect.</li>
			</ul>
			<div class="spacer"></div>
		</div>
	</div>
	<div data-role="footer">
	</div>
</div>