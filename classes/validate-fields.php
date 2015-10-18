<?php
	/* This class is used to validate forms fields and return error message and also highlight caption of fields */

	class validate
	{
		var $errorsArray		=	array();
		var $dataValid			=	true;
		var $extension			=	"";

		/* Data Type codes 
			N	-	Numeric
			A	-	Alphanumeric
			L	-	Letters only with space
			F   -	Float
			D	-	Date
			E	-	Email
			W	-	Url
			I	-	Image/File
			C	-	Comparision
			LEN -   Length
		*/
	
		function checkField($fieldValue, $dataType = "", $errorMessage="", $optionalData = array())
		{	
			$isDataValid = true;
			if($this->isNotEmpty($fieldValue))
			{
				switch($dataType)
				{	
					case "N":
						$isDataValid	= $this->isNumeric($fieldValue);
						break;
					case "A":
						$isDataValid	= $this->isAlphaNumeric($fieldValue);
						break;
					case "L":
						$isDataValid	= $this->isLetters($fieldValue);
						break;
					case "D":
						$isDataValid	= $this->isDate($fieldValue,$optionalData['month'],$optionalData['day'],$optionalData['year']);
						break;
					case "E":
						$isDataValid	=	$this->isEmail($fieldValue);
						break;
					case "W":
						$isDataValid	=	$this->isURL($fieldValue);
						break;
					case "C":
						$isDataValid	=	!($this->isTrue($fieldValue, $optionalData));
						break;
					case "I":
						$isDataValid	=	$this->isValidFile($fieldValue, $optionalData);
						break;
					case "LEN":
						$isDataValid	=	$this->checkLength($fieldValue,$optionalData);
						break;
				}
			}
			else
			{
				$isDataValid = false;
			}

			if(!$isDataValid)
			{
				$this->dataValid	=	false;
				$this->errorsArray[]	=	"<font color='#920607' style='font-size:11px;font-family:helvetica;'>$errorMessage</font>";
			}
			
		}// end of function get validated fields
		
		function setError($errorMessage)
		{
				$this->dataValid	=	false;
				$this->errorsArray[]	=	"<font color='#920607' style='font-size:11px;font-family:helvetica;'>$errorMessage</font>";
		}

		function getErrors()
		{
			$errorMessage = "<table style='border:1px solid #e4e4e4;width:100%'>";
			foreach($this->errorsArray as $value)
			{
				$errorMessage .= "<tr><td><font color='#bebebe'>&#8226;</font></td><td>$value</td></tr>";
			}

			$errorMessage .= "</table><br>";
			return $errorMessage;
		}
		function isDataValid()
		{
			return $this->dataValid;
		}

		function checkLength($value, $lengthArray)
		{			
			$minLength = $lengthArray[0];
			$maxLength = $lengthArray[1];
			
			if(Empty($minLength))
				{
					if(strlen($value) > $maxLength)
						return false;
					else
						return true;
				}
			elseif(Empty($maxLength))
				{
					if(strlen($value) < $minLength)
						return false;
					else
						return true;
				}
			elseif(strlen($value) < $minLength || strlen($value) > $maxLength)
				{
					return false;
				}
			
			return true;
		} // end of function check length

		function isNumeric($value)
		{
			if(is_numeric($value))
			{
				return true; 
			}
			else
			{
				return false;
			}
		} // end of function is NAN


		function isEmail($mail) 
		{
			if(!@eregi("^[-_\.0-9a-z]+@([0-9a-z][-_0-9a-z\.]+)\.([a-z]{2,4}$)", $mail))
			{
				return false;
			}
			else
			{
				return true;
			}
		} // end of function check email

		function isURL($url = "")
		{
			if(!preg_match("/^http/i", $url))
			{
				$url="http://" . $url;
			}
			$pat_url='/^(?:(?:http|https?):\/\/)?(?:[a-z0-9](?:[-a-z0-9]*[a-z0-9])?\.)+(?:com|edu|biz|org|gov|int|info|mil|net|name|museum|coop|aero|[a-z][a-z])\b(?:\d+)?(?:\/[^;"\'<>()\[\]{}\s\x7f-\xff]*(?:[.,?]+[^;"\'<>()\[\]{}\s\x7f-\xff]+)*)?/i';

			if(preg_match($pat_url, $url))
			{
				return true;
			}
			else
			{
				return false;
			}
		}// end of function is URL

		function isNotEmpty($value)
		{
			if(!is_array($value))
				$value = trim($value);
			else{
				return true;
			}

			if(empty($value))
			{
				return false;
			}
			else
			{
				return true;
			}
		}

		function isDate($fieldName,$month,$day,$year)
		{
			if(checkdate($month,$day,$year))
			{
				return true;
			}
			else
			{
				return false;
			}
		}// end of check is date//

		function isAlphaNumeric($str, $spaceAllowed=true)
		{
			if($spaceAllowed)
				$space = "";
			else
				$space = " ";

			$allowed_chars = array("@","'",'"',"*","<",">",";",$space);

			for($x=0;$x<strlen($str);$x++)
			{
				$char = substr($str,$x,1);
				if(in_array($char,$allowed_chars))
				{
					return false;
				}
			}
			return true;
		} // end of function isAlphaNumeric



		function isLetters($str)
		{
			$str = eregi_replace("([A-Z[:space:]]+)","",$str);
			if(empty($str))
			{
				return true;
			}
			else
			{
				return false;
			}
		} // end of function 

		function getExtension()
		{
			return $this->extension;
		}
		function isValidFile($fieldName, $optionalData)
		{	
			//NOTE:- If you make changes in this array simultaneouly make changes in WIC\CLASSES\fileuploadclass.PHP also.
			$FILE_TYPES		= array(	
				"image/jpeg"				=>	"jpg",
				"image/pjpeg"				=>	"jpg",
				"image/gif"					=>	"gif",
				"image/x-png"				=>	"png",
				"application/pdf"			=>  "pdf", 
				"application/msword"		=>	"doc",
				"text/plain"				=>	"htm",
				"text/html"					=>	"htm",
				"application/octet-stream"	=>"txt" //for tab separated file
				  );
			//global $FILE_TYPES;

			if(in_array($fieldName['type'],array_keys($FILE_TYPES)))
			{
				$userFileType		=	$FILE_TYPES[$fieldName['type']];
				$fileSize			=	$fieldName['size'];
				
				$requiredFileType	=	$optionalData[0];
				$requiredFileSize	=	$optionalData[1];
				$requiredFileTypes	=	explode("|", $requiredFileType);
				
				$fileValid = true;
			
				if($fileSize > $requiredFileSize)
				{
					$fileValid = false;
				}
			}
			else
			{
				$fileValid = false;
			}
			if($fileValid)
			{
				if(!in_array($userFileType, $requiredFileTypes))
				{
					$fileValid = false;
				}
				else
				{
					$this->extension	=	$userFileType;
				}
			}
			return $fileValid;
		}// end of function isValidImage

		function isTrue($fieldName, $optionalData)
		{
			$value1		=	$optionalData[0];
			$operator	=	$optionalData[1];
			$value2		=	$optionalData[2];

			switch($operator)
			{
				case "==":
					if($value1 == $value2)
						return true; 
					else 
						return false;
					break;

				case "!=":
					if($value1 != $value2)
						return true; 
					else 
						return false;
					break;

				case "===":
					if($value1 === $value2)
						return true; 
					else 
						return false;
					break;
						
				case "<>":
					if($value1 <> $value2)
						return true; 
					else 
						return false;
					break;

				case "<=":
					if($value1 <= $value2)
						return true; 
					else 
						return false;
					break;

				case ">=":
					if($value1 >= $value2)
						return true; 
					else 
						return false;
					break;
				case "<":
					if($value1 < $value2)
						return true; 
					else 
						return false;
					break;
				case ">":
					if($value1 > $value2)
						return true; 
					else 
						return false;
					break;
				default:
					return false;

			}
		} // end of function isTrue
}


class field
{
	var $caption		=	"";
	var $fieldName		=	"";
	var $fieldValue		=	"";
	var $dataType		=	"";
	var $errorMessage	=	"";
	var $optionalData	=	array(); 
	// in case of images, comparison and strings only

	function field($caption,$fieldName,$fieldValue,$dataType=false,$errorMessage="",$optionalData=array())
	{
		$this->caption		=	$caption;
		$this->fieldName	=	$fieldName;
		$this->fieldValue	=	$fieldValue;
		$this->dataType		=	$dataType;
		$this->errorMessage	=	$errorMessage;

		$this->optionalData	=	$optionalData;
		

		$optionalArrayLength	=	count($optionalData);

		if($dataType == "I" && $optionalArrayLength !=2)
		{
			echo "Data provided for image field ($fieldName) is not valid";
			die();
		}

		if($dataType == "C" && $optionalArrayLength !=3)
		{
			echo "Data supplied for comparison is not valid";
			die();
		}
	}

}
?>
