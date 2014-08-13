<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	include "../classes/Glance.php";

	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	
	$h = query("SELECT id, name, job, gender, level, score FROM heroes WHERE score > 0 ORDER BY score DESC");
	$heroes = array();
	$i = 0;
	$h_index = 0;
	$hero_Rank = 0;
	
	while($hr = mysql_fetch_assoc($h)) {
		if ($hr["id"] == $hero->ID()) {
			$h_index = $i;
			$hero_Rank = $i + 1;
		}
		array_push($heroes, $hr);
		$i++;
	}
	
	$hero->save();
	
	include "../includes/header.php";
?>

<div id="rank_status" data-role="page">
	<div data-role="header">
		<h1>Ladder</h1>
	</div>
	<div data-role="content">
		<div class="log_header" style="<?php bg('general/hero_wins'); ?>">Standing</div>
		<div class="log dark">
			<div style="<?php bg('general/book'); ?>">Rank<span class="value"><?php echo $hero_Rank == 0 ? "Unranked" : $hero_Rank; ?></span></div>
			<div style="<?php bg('general/hero_attack'); ?>">Score<span class="value"><?php echo $hero->Score(); ?></span></div>
		</div>
		<div class="log_header" style="<?php bg('general/advance'); ?>">Rankings</div>
		<div class="log dark">
			<?php
				for($i = $h_index - 2; $i <= $h_index + 2; $i++) {
					if (isset($heroes[$i])) {
						$h = $heroes[$i];
						if ($i != $h_index) {
							
			?>
							<div style="<?php bg('heroes/' . $h["job"] . '-' . $h["gender"] . '_small'); ?>"><?php echo $i + 1; ?>. <?php echo $h["name"] ?> <span class="value"><?php echo $h["score"]; ?></span></div>
			<?php 
						} else {
			?>
							<div style="<?php bg('heroes/' . $h["job"] . '-' . $h["gender"] . '_small'); ?> background-color: rgba(62, 157, 91, .25);" class="bold"><?php echo $i + 1; ?>. <?php echo $h["name"] ?> <span class="value"><?php echo $h["score"]; ?></span></div>
			<?php		
						}
					}
				}
			?>
		</div>
	</div>
	<div data-role="footer">
	
	</div>
</div>