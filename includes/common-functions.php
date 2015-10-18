<?php
	function wrap($text,$length=13)
	{
		return wordwrap($text,$length, "\n", 1);
	}

	

	function pr($string)
	{
		print_r('<pre>');
		print_r($string);
		print_r('</pre>');
	}

	function mysqlRealEscape($string)
	{
		return mysql_real_escape_string($string);
	}

	function getNumberOnly($string)
	{
		$number = preg_replace("/[^0-9]/", '', $string);
		return $number;
	}

	

	
	function br()
	{
		echo "<br>";
	}

	function subString($string,$length="10")
	{
		return substr($string,0,$length);
	}

	//Function show Date Format
	function showDate($date)
	{
		if($date != '0000-00-00')
		{
			return date("M d, Y",strtotime($date));
		}
		else
		{
			return false;
		}
	}

	
	/* Function to get substring of a string*/
	function getSubstring($name,$subStr)
	{
		if(strlen($name)>$subStr)
		{
			$name = substr($name,0,$subStr)."...";
		}
		return $name;
	}
	function htmlEntity($text)
	{
		return stripslashes(htmlentities($text,ENT_QUOTES));
	}
	
?>