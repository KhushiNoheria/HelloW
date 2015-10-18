<?php
	ob_start();
	session_start();
	error_reporting(E_ALL);
	include("../root.php");
	include(SITE_ROOT			.	"/classes/pagingclass.php");//DEFINING PAGING CLASS
	$pagingObj					=   new Paging();//DEFINING PAGING CLASS OBJECT
?>
<!DOCTYPE html>
<html>
<head>
<title>Registration Admin Area</title>
<style>
	.text1
	{
		font-family:Tahoma, Arial, Verdana, Helvetica, sans-serif;
		color:#333333;
		font-size:16px;
		text-decoration:none;
	}
	.text2
	{
		color:#ff0000;
		font-family:verdana;
		font-size:12px;
		text-decoration:none;
	}

	.smalltext1
	{
		color:#000000;
		font-family:verdana;
		font-size:14px;
		text-decoration:none;
		font-weight:bold;
	}

	.smalltext2
	{
		color:#000000;
		font-family:verdana;
		font-size:16px;
		text-decoration:none;
		font-weight:none;
	}

	.rwcolor1
	{
		background-color: #FFFFFF;
	}

	.rwcolor2
	{
		background-color: #DAEEF3;
	}
	

</style>
</head>
<body>
<center>
	<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" style="border:2px solid #bebebe;">
		<tr>
			<td colspan="10" class="text1" align="center"><b>VIEW REGISTERED USERS</b></td>
		</tr>
		<tr>
			<td height="10"></td>
		</tr>
		<?php
			if(isset($_REQUEST['recNo']))
			{
				$recNo					=	(int)$_REQUEST['recNo'];
			}
			if(empty($recNo))
			{
				$recNo					=	0;
			}
			$whereClause			  =	"";
			$orderBy				  = "userId DESC";
			$queryString			  =	"";

			$start					  =	0;
			$recsPerPage	          =	10;	//	How many records per page
			$showPages		          =	10;	//	How many pages to show	
			$pagingObj->recordNo	  =	$recNo;
			$pagingObj->startRow	  =	$recNo;
			$pagingObj->whereClause   =	$whereClause;
			$pagingObj->recsPerPage   =	$recsPerPage;
			$pagingObj->showPages	  =	$showPages;
			$pagingObj->orderBy		  =	$orderBy;
			$pagingObj->table		  =	"users";
			$pagingObj->selectColumns = "*";

			$pagingObj->path		  = SITE_URL_ADMIN."/index.php";
			$totalRecords = $pagingObj->getTotalRecords();
			if($totalRecords && $recNo <= $totalRecords)
			{
				$pagingObj->setPageNo();
				$recordSet				= $pagingObj->getRecords();

				$i						= $recNo;
		?>
		<tr>
			<td width="13%" class="smalltext1">&nbsp;<b>First Name</b></td>
			<td width="13%" class="smalltext1"><b>Last Name</b></td>
			<td width="15%" class="smalltext1"><b>Address1</b></td>
			<td width="15%" class="smalltext1"><b>Address2</b></td>
			<td width="12%" class="smalltext1"><b>City</b></td>
			<td width="4%" class="smalltext1"><b>State</b></td>
			<td width="8%" class="smalltext1"><b>Zip</b></td>
			<td width="6%" class="smalltext1"><b>Country</b></td>
			<td class="smalltext1">Date</td>
		</tr>
		<tr>
			<td colspan='10'>
				<hr size='1' width='100%' color='#428484'>
			</td>
		</tr>
		<?php
				while($row				=   mysql_fetch_assoc($recordSet))
				{
					$i++;
					$userId				=	$row['userId'];
					$firstname			=	stripslashes($row['firstname']);
					$lastname			=	stripslashes($row['lastname']);
					$registeredOn		=	$row['registeredOn'];
					$address1			=	stripslashes($row['address1']);
					$address2			=	stripslashes($row['address2']);
					$city				=	stripslashes($row['city']);
					$state				=	stripslashes($row['state']);
					$zipcode			=	stripslashes($row['zipcode']);
					$registeredTime		=	$row['registeredTime'];

					
					$bgColor					=	"class='rwcolor1'";
					if($i%2==0)
					{
						$bgColor				=   "class='rwcolor2'";
					}
			?>
			<tr <?php echo $bgColor;?> height="30">
				<td class="smalltext2" valign="top">&nbsp;<?php echo $firstname;?></td>
				<td class="smalltext2" valign="top"><?php echo $lastname;?></td>
				<td class="smalltext2" valign="top"><?php echo $address1;?></td>
				<td class="smalltext2" valign="top"><?php echo $address2;?></td>
				<td class="smalltext2" valign="top"><?php echo $city;?></td>
				<td class="smalltext2" valign="top"><?php echo $state;?></td>
				<td class="smalltext2" valign="top"><?php echo $zipcode;?></td>
				<td class="smalltext2" valign="top">US</td>
				<td class="smalltext2" valign="top"><?php echo $registeredOn." ".$registeredTime;?></td>

			</tr>
			<?php		
				}
				echo "<tr><td height='10'></td></tr><tr><td align='right' colspan='15'>";
				$pagingObj->displayPaging($queryString);
				echo "&nbsp;&nbsp;</td></tr>";	
			}
			else{
				echo "<tr><td colspan='10' class='text2' align='center'>Sorry No Record Found</td></tr>";
			}
		?>
	</table>
</center>
</body>
</html>


