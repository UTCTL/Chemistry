<?php
class textFunctions
{
	function truncate($string, $length){
		if(!$string){
			$string = "";
		}
		
		if(!$length){
			$length = 0;
		}
		
		return substr_replace($string, '', $length);
	}
	
}

?>