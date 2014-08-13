function notoriousName()
{
	$('.monster .top span').animate({ 'color' : 'orange' }, 500).delay(500).animate({ 'color' : '#444444' }, 750, notoriousName);
}

function processBattle()
{
	$.post('attack.php', function(battle) {
		
		var battle = $.parseJSON(battle);
		
		$('#beginQueue').hide();

		$('#beginQueue').remove();
				
		battleMessage('Fight!', '#F34642', '1px #9A3B37', 
			function() 
			{ 
				processRound(battle.rounds[0]);

				var round = 1;
				var times = battle.rounds.length;
				
				$(document).everyTime(2000, function() {
					if (round < battle.rounds.length)
					{
						processRound(battle.rounds[round]);
					} else {
						battleResults(battle);
					}
					round++;
				}, times); 
			}
		);
	});
}

function processRound(round)
{
	var hero = round.hero;
	var monster = round.monster;

	// BATTLE LOG //
	
		$('#battle_log .log_record').each(function(index) {
			$(this).animate({ 'opacity' : 0.5, 'fontSize' : '10px' });
		});
		
		$.each(round.log, function() {
			var backgroundImage = "";
			if (this.icon) { backgroundImage = "background-image: url('../images/" + this.icon + ".png')"; }
			var content = $('<div class="log_record" style="' + backgroundImage + '">' + this.message + '</div>');
			$(content).hide();
			$('#battle_log').prepend(content);
			$(content).show('drop');
			$('#battle_log .log_record').each(function(i) {
				if (i > 4)
				{
					$(this).remove();
				}
			});	
		});
	
	// DAMAGE DISPLAY //
		var times = round.actions.length;
		var action_i = 0;	
		
		if (round.attacker == "hero")
		{		
			if (round.actions.length > 0) {
				$(document).everyTime(250, function() {
					var action = round.actions[action_i];
					$('.glance.monster').effect('shake', { times : 1 }, 50);
					floatingCombat("#battle_engage", "monster", action.damage, "damage", action.critical);
					if (action.notify) { battleMessage(action.notify, '#F34642', '1px #9A3B37'); }
					action_i++;
				}, times);
			}
		} else {
			if (round.actions.length > 0) {
				$(document).everyTime(250, function() {
					var action = round.actions[action_i];
					$('.glance.hero').effect('shake', { times : 1 }, 50);
					floatingCombat("#battle_engage", "hero", action.damage, "damage", action.critical);
					if (action.notify) { battleMessage(action.notify, '#F34642', '1px #9A3B37'); }
					action_i++;
				}, times);
			}
		}
	
	// HEALTH BARS //

		$('#hero_healthbar .fill').animate( { 'width': hero.health.percent + '%' } );
		$('#hero_health').text(hero.health.value);
		
		$('.glance.hero').removeClass('emote-happy emote-normal emote-sad');

		if (hero.health.percent < 25)
		{
			$('.glance.hero').addClass('emote-sad');
		}
		else if (hero.health.percent < 50)
		{
			$('.glance.hero').addClass('emote-normal');
		}
		else 
		{
			$('.glance.hero').addClass('emote-happy');
		}

		$('#monster_healthbar .fill').animate( { 'width': monster.health.percent + '%' } );
		$('#monster_health').text(monster.health.value);
	
	// BUFF / DEBUFFS //
	
		if (hero.augments.buff)
		{
			$('#hero_status .buff').css("background-image", "url('/images/" + hero.augments.buff.icon + ".png')");
			$('#hero_status .buff').text(hero.augments.buff.stacks);
		} else {
			$('#hero_status .buff').attr('style', '');
			$('#hero_status .buff').text('');	
		}
		
		if (hero.augments.debuff)
		{
			$('#hero_status .debuff').css("background-image", "url('/images/" + hero.augments.debuff.icon + ".png')");
			$('#hero_status .debuff').text(hero.augments.debuff.stacks);
		} else {
			$('#hero_status .debuff').attr('style', '');
			$('#hero_status .debuff').text('');
		}

		if (monster.augments.buff)
		{
			$('#monster_status .buff').css("background-image", "url('/images/" + monster.augments.buff.icon + ".png')");
			$('#monster_status .buff').text(monster.augments.buff.stacks);
		} else {
			$('#monster_status .buff').attr('style', '');
			$('#monster_status .buff').text('');	
		}
		
		if (monster.augments.debuff)
		{
			$('#monster_status .debuff').css("background-image", "url('/images/" + monster.augments.debuff.icon + ".png')");
			$('#monster_status .debuff').text(monster.augments.debuff.stacks);
		} else {
			$('#monster_status .debuff').attr('style', '');
			$('#monster_status .debuff').text('');	
		}
}

function battleResults(battle)
{			
	$('#monster_status').hide('fade', 250);
	$('#hero_status div').hide('fade', 250);
	
	if (battle.winner == "hero")
	{
		if (battle.results.exp.gain > 0)
		{
			$('#gained_exp').text(battle.results.exp.gain);
			$('#loot_exp').show();
		}
		
		$('#gained_gold').text(battle.results.gold);
		
		if (battle.results.ore_common > 0)
		{
			$('#gained_common').text(battle.results.ore_common);
			$('#loot_common').show();
		}
		if (battle.results.ore_rare > 0)
		{
			$('#gained_rare').text(battle.results.ore_rare);
			$('#loot_rare').show();
		}
		
		if (battle.results.drops.length > 0)
		{
			$.each(battle.results.drops, function() {
				div = $('<div></div>');
				$(div).addClass('white');
				$(div).css('background-image', 'url(/images/' + this.pic + '.png)');
				$(div).text('+1 ' + this.name + ' (' + this.actual + '/' + this.target + ')');
				$('#results_log .log').append(div);
			});
		}
		
		if (battle.results.complete_quest.length > 0)
		{
			$.each(battle.results.complete_quest, function() {
				var div = $('<div></div>');
					$(div).addClass('log_header white');
					$(div).css('background-image', 'url(/images/quests/' + this.type + '-1.png)');
					$(div).text(this.type.charAt(0).toUpperCase() + this.type.slice(1) + ' Complete!');
				$('#quest_log').append(div);
				
				var LogDiv = $('<div></div>');
					$(LogDiv).addClass('log');
				$('#quest_log').append(LogDiv);
				
				var div = $('<div></div>');
					$(div).addClass('white');
					$(div).css('background-image', 'url(/images/general/exp.png)');
					$(div).text('+' + this.rewards.exp + ' EXP');
				$(LogDiv).append(div);
				
				var div = $('<div></div>');
					$(div).addClass('white');
					$(div).css('background-image', 'url(/images/spoils/gold.png)');
					$(div).text('+' + this.rewards.gold + ' Gold');
				$(LogDiv).append(div);
				
				var div = $('<div></div>');
					$(div).addClass('white');
					$(div).css('background-image', 'url(/images/spoils/iron.png)');
					$(div).text('+' + this.rewards.ore_common + ' Iron Ore');
				$(LogDiv).append(div);
				
				var div = $('<div></div>');
					$(div).addClass('white');
					$(div).css('background-image', 'url(/images/spoils/cobalt.png)');
					$(div).text('+' + this.rewards.ore_rare + ' Cobalt Ore');
				$(LogDiv).append(div);
			});
		}
	
		$('#battle_log').hide('drop', { 'direction' : 'right' }, 250, function() {
			battleMessage('Victory!', '#0D65C5', '1px #4499F3',
				function() {
						
						if (battle.results.levelUp) {
							$('#levelUpButton').show('fade', 250);
						} else {
							$('#victoryButton').show('fade', 250);
						}
						
						if (battle.results.complete_quest.length > 0)
						{
							$('#results_log').show('drop', { 'direction' : 'left' } , 250)
							.delay(2000)
							.hide('drop', { 'direction' : 'right' }, 250, function() {
									$('#quest_log').show('drop', { 'direction' : 'left' }, 250);
								});
						} else {
							$('#results_log').show('drop', { 'direction' : 'left' } , 250);
						}
						
						$('#hero_expbar .fill').animate( { 'width' : battle.results.exp.percent + '%' } );
				}
			);			
		});	
	} else {
		$('#battle_log').hide('drop', { 'direction' : 'right' }, 250, function() {
			battleMessage('Defeat!', '#BC4946', '1px #F34642',
				function() {
						$('#defeatButton').show('fade', 250);
				}
			);
		});
	}
}

function battleMessage(msg, color, stroke, callback)
{
	var battleMessage = $('<div>'+msg+'</div>');
	$(battleMessage).addClass('floatingMessage');
	$(battleMessage).css('position', 'absolute');
	$(battleMessage).css('top', 200);
	$(battleMessage).css('left', 0);
	$(battleMessage).css('opacity', 0);
	$(battleMessage).css('color', color);
	$(battleMessage).css('-webkit-text-stroke', stroke);
	$('#battle_engage').append(battleMessage);
	$(battleMessage).animate({
		'fontSize' : 50,
		'opacity' : 1.0
	}, 250).delay(500).animate({ 'opacity' : 0.0 }, 150, function() { $(battleMessage).remove(); if (callback) { callback(); } });
	
}