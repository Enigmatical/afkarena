<?php if ($action["disabled"]) { ?>

	<div id="<?php echo $action["id"]; ?>" class="action disabled" data-role="button" style="<?php bg($action["pic"]); ?>">
		<div class="cost">
			<?php echo $action["cost"]; ?>
		</div>
		<div class="name"><?php echo $action["name"]; ?></div>
		<div class="desc"><?php echo $action["desc"]; ?></div>
	</div>
	
<?php } else { ?>

	<a id="<?php echo $action["id"]; ?>" class="action" href="<?php echo $action["href"]; ?>" rel="<?php if ($action["external"]) { echo "external"; } ?>" data-role="button" style="<?php bg($action["pic"]); ?>">
		<div class="cost">
			<?php echo $action["cost"]; ?>
		</div>
		<div class="name"><?php echo $action["name"]; ?></div>
		<div class="desc"><?php echo $action["desc"]; ?></div>
	</a>

<?php } ?>
