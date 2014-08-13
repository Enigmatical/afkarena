function switchStatus(el, tab) {
	$('div.ui-navbar ul li div.ui-btn-active').removeClass('ui-btn-active');
	$(el).addClass('ui-btn-active');
	
	$('div.status_tab').css('display', 'none');
	$('#' + tab + '_tab').css('display', '');
}

function confirm_action(overlay, msg, link)
{
	$('#'+overlay+'_content').find('div.message').html(msg);
	$('#'+overlay+'_content').find('div.yes_btn').bind('click', function () { window.location.href = link; } );
	
	$('#'+overlay+'_overlay').fadeIn(250);
	$('#'+overlay+'_content').fadeIn(250);
}

	function close_overlay(overlay)
	{
		$('#'+overlay+'_overlay').fadeOut(125, function() { $(this).css('display', 'none'); });
		$('#'+overlay+'_content').fadeOut(125, function() { $(this).css('display', 'none'); });
	}
	
function get_job(job)
{
	if ( $('#job_showing').val() != job ) {
		$.get('/hero/details.php?job='+job, function(response) {
			$('#jobs_description').fadeOut(125, function() {
				$(this).html(response);
			});
			$('#jobs_description').fadeIn(125);
			$('#job_showing').val(job);	
			$('#label_m span.ui-btn-text').html('<img id="m_picture" src="/images/heroes/'+job+'-m_large.png" /><br />Male');
			$('#label_f span.ui-btn-text').html('<img id="f_picture" src="/images/heroes/'+job+'-f_large.png" /><br />Female');
		});
	}
}

function show(btn, section)
{
	$('div.ui-btn-active').removeClass('ui-btn-active');
	if (section == "perks") {
		$('#abilities').fadeOut(125, function() { $('#perks').fadeIn(125); });
	} else {
		$('#perks').fadeOut(125, function() { $('#abilities').fadeIn(125); });
	}
	$(btn).addClass('ui-btn-active');
}
	
function submit_createForm()
{
	$('#create_job').val( $('input:radio[name=job]:checked').val() );
	$('#create_gender').val( $('input:radio[name=gender]:checked').val() );
	$('#create_name').val( $('#name').val() );
	
	$('#create_form').submit();
}

function rand (from, to){
	return Math.floor(Math.random() * (to - from + 1) + from);
}

function floatingCombat(page, who, msg, type, critical)
{
	var element = $('<div></div>');
	$(element).addClass('floatingCombat');
	$(element).text(msg);
	
	$(page).append(element);

	var maxFontSize = 20;
	var fontStyle = "normal";
	
	if (critical)
	{
		maxFontSize = 30
		fontStyle = "italic";
	}
	
	if (type == "damage" && critical == true)
	{
		$(element).css('color', 'yellow');
		$(element).css('-webkit-text-stroke', '1px #FFCC33');
	}
	
	if (who == "hero")
	{
		var randomTop = rand(285, 260);
		var randomLeft = rand(-10, 40);
		
		$(element).css('position', 'absolute');
		$(element).css('top', 335);
		$(element).css('left', randomLeft);
		$(element).css('fontStyle', fontStyle);
		$(element).addClass(type);
		
		$(element).animate({
			top: randomTop,
			fontSize: maxFontSize
		}, 250).delay(150).animate({
			top: '+=-5',
			opacity: 0,
			fontSize: 15
		}, 250, function() {
			$(element).remove();
		});
	} else {
	
		var randomTop = rand(175, 200);
		var randomRight	= rand(0, 30)
	
		$(element).css('position', 'absolute');
		$(element).css('top', 125);
		$(element).css('right', randomRight);
		$(element).css('fontStyle', fontStyle);
		$(element).addClass(type);
		
		$(element).animate({
			top: randomTop,
			fontSize: maxFontSize
		}, 250).delay(150).animate({
			top: '+=5',
			opacity: 0,
			fontSize: 15
		}, 250, function() {
			$(element).remove();
		});	
	}
}
