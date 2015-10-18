<?php
	ob_start();
	session_start();
	error_reporting(E_ALL);
	include("root.php");
	include(SITE_ROOT	.	"/classes/validate-fields.php");//INPUT VALIDATION CLASS
	$validator		=	new validate();//CREATING VALIDATION OBJECT

	$titleText		=	"Register Yourself";

	$firstname		=	"";
	$lastname		=	"";
	$address1		=	"";
	$address2		=	"";
	$city			=	"";
	$state			=	"";
	$zipcode		=	"";
	$form			=	SITE_ROOT."/forms/registration.php";//FIRST REGISTRATION FORM
	$form1			=	SITE_ROOT."/forms/registration-confirm.php";//CONFIRM FIRST REGISTRATION FORM
	$errorMsg		=	"";


?>  
<!-- *********************** START HTML DECLARATION *********************************-->
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $titleText;?></title>
	<META NAME="Keywords" CONTENT="registration">
	<META NAME="Description" CONTENT="This is a simple registration form">
	<meta name="robots" content="noindex, nofollow">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL?>/javascript/registration.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL?>/javascript/jquery.validate.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>/css/style1.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>/css/bootstrap.css">

<!-- *********************** END HTML DECLARATION *********************************-->
</head>
<body>
<div id="page-wrap">
<div id="content">

<?php
	///////////////////////// SHOWING SUCCESS RESULT AFTER VERIFICATION IN SESSION ////////////////
	if(isset($_SESSION['success'])){
		echo "<center><font style='font-size:16px;font-family:verdana;font-weight:bold'>You have successfully registered.</font></center><br />";
		unset($_SESSION['success']);
	}
	///////////////////////// SUBMITTING CONFIRM FORM AFTER CONFIRMING ////////////////
	if(isset($_REQUEST['formSubmittedConfirm'])){
		extract($_REQUEST);
		
		$t_firstname	=	addslashes(trim($firstname));
		$t_lastname		=	addslashes(trim($lastname));
		$t_address1		=	addslashes(trim($address1));
		$t_address2		=	addslashes(trim($address2));
		$t_city			=	addslashes(trim($city));
		$t_state		=	addslashes(trim($state));
		$t_zipcode		=	addslashes(trim($zipcode));
		$zipcount		=	strlen($zipcode);

		if($isBackedClick == 1){
			include($form);
		}
		else{

			$validator ->checkField($firstname,"","Please enter your first name.");

			$validator ->checkField($lastname,"","Please enter your last name.");

			$validator ->checkField($address1,"","Please enter your address1.");
		
			$validator ->checkField($city,"","Please enter your first city.");

			$validator ->checkField($state,"","Please select your state.");

			$validator ->checkField($zipcode,"","Please enter your zip code.");

			if(!empty($zipcode) && ($zipcount != 5 && $zipcount != 9)){
				$validator->setError("Please enter your zip code with 5 or 9 digits.");
			}
			
			$errorMsg	 =	$validator ->getErrors();
			$dataValid	 =	$validator ->isDataValid();
			if($dataValid){
				
				//ADDING IN DATABASE
				$query	 =	"INSERT INTO users SET firstname='$firstname',lastname='$lastname',address1='$address1',address2='$address2',city='$city',state='$state',zipcode=$zipcode,visitorIP='".VISITOR_IP_ADDRESS."',registeredOn='".CURRENT_DATE_CUSTOMER_ZONE."',registeredTime='".CURRENT_TIME_CUSTOMER_ZONE."'";
				mysql_query($query);

				$_SESSION['success'] = 1;

				ob_clean();
				header("Location: ".SITE_URL);
				exit();
			}
			else{
				include($form);
			}
		}
	}
	else{

		///////////////////////// SUBMITTING FIRST FORM ////////////////
		if(isset($_REQUEST['formSubmitted'])){
			extract($_REQUEST);
				
			$t_firstname	=	addslashes(trim($firstname));
			$t_lastname		=	addslashes(trim($lastname));
			$t_address1		=	addslashes(trim($address1));
			$t_address2		=	addslashes(trim($address2));
			$t_city			=	addslashes(trim($city));
			$t_state		=	addslashes(trim($state));
			$t_zipcode		=	addslashes(trim($zipcode));
			$zipcount		=	strlen($zipcode);

			$validator ->checkField($firstname,"","Please enter your first name.");

			$validator ->checkField($lastname,"","Please enter your last name.");

			$validator ->checkField($address1,"","Please enter your address1.");

			$validator ->checkField($city,"","Please enter your first city.");

			$validator ->checkField($state,"","Please select your state.");

			$validator ->checkField($zipcode,"","Please enter your zip code.");

			if(!empty($zipcode) && ($zipcount != 5 && $zipcount != 9)){
				$validator->setError("Please enter your zip code with 5 or 9 digits.");
			}
			
			$errorMsg	 =	$validator ->getErrors();
			$dataValid	 =	$validator ->isDataValid();
			if($dataValid){
				
				include($form1);
			}
			else{
				include($form);
			}
		}
		else{
			include($form);
		}
	}
?>
</div>

</div>
</div> <!-- end page wrap -->
<footer>
    <center>&copy; Copyright <?php echo date('Y');?> Registration Project. All rights reserved.</center>
</footer>

</body>
</html>