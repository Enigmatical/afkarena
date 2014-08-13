<?php
	include "../includes/config.php";
	include "../includes/functions.php";
	
	include "../includes/header.php"; 	
?>

<div id="help" data-role="page">
	<div data-role="header">
		<h1>&nbsp;</h1>
	</div>
	<div data-role="content" style="">
		<div class="section" style="<?php bg('general/day'); ?>">A Tour of the Lobby</div>
		<div>
			<ul>
				<li>Choose a Hero from the <em>Heroes</em> screen.  In most cases, you will be taken directly to the <em>Lobby</em> unless that Hero was previously in a Dungeon or in the middle of a Battle.</li>
				<li>From the <em>Lobby</em>, you can choose to Explore, Train, Forge, Mend, or view the Status of your Hero.</li>
				<li>The <em>Lobby</em> also introduces the <b>Glance</b> window which provides quick details about your Hero depending on the situation, whether in the <em>Lobby</em> or <em>Dungeon</em> or in the middle of a <em>Battle</em>.  The <b>red bar</b> represents your Hero's current <b>Health</b>.  The <b>blue bar</b> represents your Hero's current <b>EXP</b>.  Below these bars are totals for (from left to right) <b>Gold</b>, <b>Training Vouchers</b>, <b>Iron Ore</b>, and <b>Cobalt Ore</b>.</li>
				<li>The <b>Boards</b> button allows you to view the current <em>Leaderboards</em> for all Heroes and also for a specific Job.</li>
				<li>The <b>Ladder</b> button allows you to view your Hero's overall <b>Rank</b> as well as his/her <b>Score</b>.  You can also view how your Hero stacks up against other nearby Heroes, showing how close he/she is to achieving the next <b>Rank</b> and climbing one more step towards the top.</li>
			</ul>
			<a href="explore.php?" data-role="button">Explore Information</a>
			<a href="train.php?" data-role="button">Train Information</a>
			<a href="forge.php?" data-role="button">Forge Information</a>
			<a href="mend.php?" data-role="button">Mend Information</a>
			<a href="status.php?" data-role="button">Status Information</a>
		</div>
		<div class="spacer"></div>
	</div>
	<div data-role="footer">
	</div>
</div>