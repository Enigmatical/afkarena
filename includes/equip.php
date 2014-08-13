<?php
	$equipName = "";

	if ($major = $hero->get_EquipBonusName($equip->type, 'major')) {
		$equipName .= "{$major} ";
	}
	
	$equipName .= $hero->get_EquipBaseName($equip->type);
	
	if ($minor = $hero->get_EquipBonusName($equip->type, 'minor')) {
		$equipName .= " <span class=\"size_-1\">of the</span> {$minor}"; 
	}
	
	$details = $hero->detail_Equip($equip->type);
	$rating = $hero->get_EquipRating($equip->type);
?>

<?php if ( empty($equip->link->href) ) { ?>
	<div class="action no-btn" data-role="button" style="<?php bg("{$details["pic"]}"); ?>">
<?php } else { ?>
	<a href="<?php echo $equip->link->href; ?>" rel="<?php echo $equip->link->type; ?>" class="action" data-role="button" style="<?php bg("{$details["pic"]}"); ?>">
<?php } ?>

		<div class="name <?php echo $hero->get_EquipRarity($equip->type); ?>"><?php echo $equipName; ?></div>
<?php if ( $equip->type == "weapon" ) { ?>
		<div class="desc"><?php echo $rating["min"]; ?>&minus;<?php echo $rating["max"]; ?> Damage, +<?php echo $hero->get_EquipBonus('weapon', 'minor'); ?>% EXP</div>
<?php } elseif ( $equip->type == "armor" ) { ?>
		<div class="desc"><?php echo $rating; ?> Armor, +<?php echo $hero->get_EquipBonus('armor', 'minor'); ?>% Health</div>
<?php } elseif ( $equip->type == "trinket" ) { ?>
		<div class="desc"><?php echo $rating; ?> Speed, +<?php echo $hero->get_EquipBonus('trinket', 'minor'); ?>% Gold</div>
<?php } ?>

<?php if ( empty($equip->link->href) ) { ?>
	</div>
<?php } else { ?>
	</a>
<?php } ?>