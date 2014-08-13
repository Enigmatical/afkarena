<?php
	class Glance
	{
		public 	$id,		    //Unique ID of the Glance (user-defined or auto-generated)
				$type,		    //Type of Glance:  Hero, Monster, or Shopkeeper
				$layout,	    //Layout of the Glance (three-general, three-battle, or two-general)
				$pic,		    //Picture used with Glance (images/glance/)
				$emote,		    //Emotion of Picture (Normal, Happy, Sad)
				$link,		    //If Glance is a link, the link location (internal or external)
				$bars,		    //Bars displayed in the Glance (Health and Experience)
				$top,		    //Content displayed in Top section
				$middle,	    //Content displayed in Middle section
				$bottom;	    //Content displayed in Bottom section

		function __construct() 
		{
			$this->id = "glance-" . rand(1, 999) . time();
			$this->type = "";
			$this->layout = "three-general";
			
			$this->pic = "";
			$this->emote = "normal";

            $this->link = new stdClass();
			$this->link->type = "";
			$this->link->href = "";

            $this->bars = new stdClass();
			$this->bars->anim = "static";

            $this->bars->health = new stdClass();
			$this->bars->health->start = 0;
			$this->bars->health->stop = 0;

            $this->bars->experience = new stdClass();
			$this->bars->experience->start = 0;
			$this->bars->experience->stop = 0;
			
			$this->top = "";
			$this->middle = "";
			$this->bottom = "";
		}
		
		function general($hero)
		{
			$this->type = "hero";
			$this->pic = "glance/heroes/{$hero->Job()}-{$hero->Gender()}";
			$this->emote = $hero->Emote();
			$this->top = "name";
			$this->middle = "health/exp";
			$this->bottom = "currency";
			$this->bars->health->stop = $hero->Health('percent');
			$this->bars->experience->stop = $hero->Exp('percent');
		}
		
		function hero($hero)
		{
			$this->type = "hero";
			$this->pic = "glance/heroes/{$hero->Job()}-{$hero->Gender()}";
			$this->emote = $hero->Emote();
			$this->top = "name";
			$this->middle = "health/exp";
			$this->bottom = "strength";
			$this->bars->health->stop = $hero->Health('percent');
			$this->bars->experience->stop = $hero->Exp('percent');
		}
		
		function monster($monster)
		{
			$this->type = "monster";
			$this->pic = $monster->pic;
			$this->top = "name";
			$this->middle = "health";
			$this->bottom = "strength";
			$this->bars->health->stop = $monster->Health('percent');
		}
		
		function shopkeeper($shopkeeper, $dialogue)
		{
			$this->type = "shopkeeper";
			$this->layout = "two-general";
			$this->pic = "glance/shopkeepers/{$shopkeeper}";
			$this->emote = "happy";
			$this->top = $shopkeeper;
			$this->middle = $dialogue;
		}
	}
?>