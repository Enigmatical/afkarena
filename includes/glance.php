<?php if ( empty($glance->link->href) ) { ?>
	<div id="<?php echo $glance->id; ?>" class="glance <?php echo $glance->type; ?> emote-<?php echo $glance->emote; ?> no-btn" data-role="button" style="<?php bg($glance->pic); ?>">
<?php } else { ?>
	<a id="<?php echo $glance->id; ?>" class="glance <?php echo $glance->type; ?> emote-<?php echo $glance->emote; ?>" href="<?php echo $glance->link->href; ?>" rel="<?php echo $glance->link->type; ?>" data-role="button" style="<?php bg($glance->pic); ?>">
<?php } ?>

	<div class="content <?php echo $glance->layout; ?>">
		<div class="top">
			
			<?php //FORMATTED NAME STRING (HERO) ?>
			<?php if ($glance->type == "hero" && $glance->top == "name") { ?>
					<span id="hero_name" class="bold size_1"><?php echo $hero->Name(); ?></span><span class="size_-1">, Level</span>
					<span class="bold size_1"><?php echo $hero->Level(); ?></span>
					<span class="size_-1"><?php echo ucfirst( $hero->Job() ); ?></span>
			
			<?php //FORMATTED NAME STRING (MONSTER) ?>
			<?php } elseif ($glance->type == "monster" && $glance->top == "name") { ?>
					<span id="monster_name" class="bold size_1 monster-rank_<?php echo $monster->Rank(); ?>"><?php echo $monster->get_FullName(); ?></span><span class="size_-1">, Level</span>
					<span class="bold size_1"><?php echo $monster->Level(); ?></span>
					<span class="size_-1"><?php echo $monster->Type(); ?></span>
			
			<?php //FORMATTED NAME STRING (SHOPKEEPER) ?>
			<?php } elseif ($glance->type == "shopkeeper") { ?>
					<?php switch($glance->top) {
							case "trainer":
								echo '<span class="bold size_1">Gwinn</span><span class="size_-1">, Arena Trainer</span>';
								break;
							case "smith":
								echo '<span class="bold size_1">Mason</span><span class="size_-1">, Arena Smith</span>';
								break;
							case "nurse":
								echo '<span class="bold size_1">Alysia</span><span class="size_-1">, Arena Nurse</span>';
								break;
						} ?>
			
			<?php //DIRECT INPUT ?>
			<?php } else { ?>
					<?php echo $glance->top; ?>
			<?php } ?>
		
		</div>
		<div class="middle">
		
			<?php //2-BARS, LARGE HEALTH, SMALL EXP (HERO) ?>
			<?php if ($glance->type == "hero" && $glance->middle == "health/exp") { ?>
					<div id="hero_healthbar" class="bar lg" bar-type="health">
						<div class="fill" style="width: <?php echo $glance->bars->health->stop; ?>%;"></div>
					</div>
					<div id="hero_expbar" class="bar sm" bar-type="exp">
						<div class="fill" style="width: <?php echo $glance->bars->experience->stop; ?>%;"></div>
					</div>

			<?php //1-BAR, LARGE HEALTH (HERO) ?>
			<?php } elseif ($glance->type == "hero" && $glance->middle == "health") { ?>
					<div id="hero_healthbar" class="bar lg" bar-type="health" bar-anim="<?php echo $glance->bars->anim; ?>" bar-start="<?php echo $glance->bars->health->start; ?>%" bar-stop="<?php echo $glance->bars->health->stop; ?>%">
						<div class="fill" style="width: <?php echo $glance->bars->health->stop; ?>%;"></div>
					</div>

			
			<?php //1-BAR, LARGE HEALTH (MONSTER) ?>
			<?php } elseif ($glance->type == "monster" && $glance->middle == "health") { ?>
					<div id="monster_healthbar" class="bar lg" bar-type="health" bar-anim="<?php echo $glance->bars->anim; ?>" bar-start="<?php echo $glance->bars->health->start; ?>%" bar-stop="<?php echo $glance->bars->health->stop; ?>%">
						<div class="fill" style="width: <?php echo $glance->bars->health->stop; ?>%;"></div>
					</div>
					
			<?php //DIALOGUE (SHOPKEEPER) ?>
			<?php } elseif ($glance->type == "shopkeeper") { ?>
						<div class="dialogue"><?php echo $glance->middle; ?></div>
			<?php //DIRECT INPUT ?>
			<?php } else { ?>
					<?php echo $glance->middle; ?>
			<?php } ?>
		
		</div>
		<div class="bottom">
		
			<?php //STRENGTH (HERO) ?>
			<?php if ($glance->type == "hero" && $glance->bottom == "strength") { ?>
					<div class="left_col stats" style="width: 25%;">
						<div id="hero_health" class="icon-health"><a href="#" style="text-decoration: none; color: #444;"><?php disp($hero->Health(), 9999); ?></a></div>
					</div>
					<div class="right_col stats" style="width: 75%;">
						<div id="hero_armor" class="icon-armor"><a href="#" style="text-decoration: none; color: #444;"><?php disp($hero->get_EquipRating('armor'), 999); ?></a></div>					
						<div id="hero_speed" class="icon-speed"><a href="#" style="text-decoration: none; color: #444;"><?php disp($hero->get_EquipRating('trinket'), 999); ?></a></div>
						<div id="hero_power" class="icon-power"><a href="#" style="text-decoration: none; color: #444;">
							<?php
								$rating = $hero->get_EquipRating('weapon');
								disp($rating["min"], 9999);
								echo '&minus;';
								disp($rating["max"], 9999);
							?>
						</a></div>
					</div>
			
			<?php //STRENGTH (MONSTER) ?>
			<?php } elseif ($glance->type == "monster" && $glance->bottom == "strength") { ?>
			
					<div class="left_col stats" style="width: 75%;">
						<div id="monster_power" class="icon-power"><a href="#" style="text-decoration: none; color: #444;"><?php disp($monster->min_damage, 999); ?>&minus;<?php disp($monster->max_damage, 999); ?></a></div>
					</div>
					<div class="right_col stats" style="width: 25%;">
						<div id="monster_health" class="icon-health"><a href="#" style="text-decoration: none; color: #444;"><?php disp($monster->Health(), 9999); ?></a></div>
					</div>
					
			<?php //CURRENCY (HERO) ?>
			<?php } elseif ($glance->type == "hero" && $glance->bottom == "currency") { ?>
					<div class="left_col spoils">
						<div class="gold"><a href="#" style="text-decoration: none; color: #444;"><?php disp($hero->Loot('gold'), 99999); ?></a></div>
						<div class="vouchers"><a href="#" style="text-decoration: none; color: #444;"><?php disp($hero->Loot('vouchers'), 99); ?></a></div>
					</div>
					<div class="right_col spoils">
						<div class="ore_rare"><a href="#" style="text-decoration: none; color: #444;"><?php disp($hero->Loot('ore_rare'), 999); ?></a></div>
						<div class="ore_common"><a href="#" style="text-decoration: none; color: #444;"><?php disp($hero->Loot('ore_common'), 999); ?></a></div>
					</div>
			
			<?php //DIRECT INPUT ?>
			<?php } else { ?>
					<?php echo $glance->bottom; ?>
			<?php } ?>
			
		</div>
	</div>
	
<?php if ( empty($glance->link->href) ) { ?>
	</div>
<?php } else { ?>
	</a>
<?php } ?>