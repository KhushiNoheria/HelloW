<?php
    //MAKING CONSTANT FOR SITE PATH AND URL
	if(strstr($_SERVER['HTTP_HOST'],'assaminfo.com'))
	{
		define("SITE_ROOT"		,	$_SERVER['DOCUMENT_ROOT']."/registration_project");
		define("SITE_URL"		,	"http://www.assaminfo.com/registration_project");
	}
	else
	{
		define("SITE_ROOT"		,	$_SERVER['DOCUMENT_ROOT']."/assaminfo/registration_project");
		define("SITE_URL"		,	"http://localhost/assaminfo/registration_project");
	}
	//MAKING CONSTANT FOR GETTING VISITOR IP ADDRESS
	if(isset($_SERVER['REMOTE_ADDR']))
	{
		define("VISITOR_IP_ADDRESS"	,	$_SERVER['REMOTE_ADDR']);
	}
	else
	{
		define("VISITOR_IP_ADDRESS"	,	"");
	}
	//MAKING CONSTANT FOR SITE ADMIN PATH AND URL
	define("SITE_ROOT_ADMIN"		,	SITE_ROOT."/admin");
	define("SITE_URL_ADMIN"			,	SITE_URL."/admin");

	$today_day						=	gmdate("d");
	$today_month					=	gmdate("m");
	$today_year						=	gmdate("Y");

	$now_hours						=	gmdate("G");
	$now_minutes					=	gmdate("i");
	$now_seconds					=	gmdate("s");

	$nowUsaHours					=	$now_hours-4;
	$nowUsaMinutes				    =	$now_minutes;

	$nowUsaTimeStamp				=	mktime($nowUsaHours, $nowUsaMinutes, $now_seconds, $today_month, $today_day, $today_year);

	$nowTimeUsa						=	date('H:i:s',$nowUsaTimeStamp);
	$nowDateUsa						=	date('Y-m-d',$nowUsaTimeStamp);

	define("CURRENT_DATE_CUSTOMER_ZONE"	,	$nowDateUsa);
	define("CURRENT_TIME_CUSTOMER_ZONE"	,	$nowTimeUsa);
	
	include(SITE_ROOT			. "/includes/common-functions.php");//SOME COMMON FUNCTION INCLUDED
	include(SITE_ROOT			. "/includes/common-array.php");//SOME COMMON ARRAY INCLUDED
    include(SITE_ROOT			. "/includes/connection.php");//MAKING DB CONNECTION
?>