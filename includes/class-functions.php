<?php
	function eq_MaxHealth($v) {
		return (.0151 * pow($v, 2)) + (12.8078 * $v) + 27.1771;
	}
	
	function eq_MaxExp($v) {
		return ((5.4091 * pow($v, 2)) + (-41.8206 * $v) + 286.4115) * 1.25;
	}
	
	function eq_MonsterExp($v) {
		return ((5 * $v) + 45) * .50;
	}
	
	function eq_Stat($v) {
		return ((.0098 * pow($v, 2)) + (2.0736 * $v) + 10.4223) / 5;
	}
	
	function eq_Average($v) {
		return (.0098 * pow($v, 2)) + (2.0736 * $v) + 10.4223;
	}
?>