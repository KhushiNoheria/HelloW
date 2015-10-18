<style>
	.paging_text
	{
		border:1px solid #AAAAAA;
		background: #dddddd;
		font-size:12px;
		font-family:verdana;
		color:#333333;
		margin: 0 3px;
		padding:2px 5px;
		-moz-border-radius:5px; /*  Firefox  */ 
		-webkit-border-radius:5px; /* Safari and chrome */ 
		-khtml-border-radius:5px; /* Linux browsers */ 
		border-radius:5px; /* CSS3 */ 
	}
	.paging_text1
	{
		border:1px solid #AAAAAA;
		background: #99B3FF;
		font-size:12px;
		font-family:verdana;
		color:#333333;
		margin: 0 3px;
		padding:2px 5px;
		-moz-border-radius:5px; /*  Firefox  */ 
		-webkit-border-radius:5px; /* Safari and chrome */ 
		-khtml-border-radius:5px; /* Linux browsers */ 
		border-radius:5px; /* CSS3 */ 
	}
	
</style>
<?php

/*if(Empty($conn))
{
	include($document_root . "/includes/connection.php");
}*/

class Paging 
{
	var $whereClause;	// Part of where clause used in only online query
	var $recsPerPage;	// Number of records per page
	var $showPages;		// How many links to be displayed for paging
	var $orderBy;		// Used in Order By Clause
	var $table;			// Table name to be used in queries
	var $selectColumns;	// Columns to be selected
	var $recordNo;		// current record number
	var $startRow;
	var $primaryColumn = "";// if want to count distinct record then set it with distinct keyword	
		
	var $totalRecords=0;	// Total records found
	var $pageNo;		// current page number
	var $pageFrom;		// first page to be displayed in paging list
	var $path;			// for hyerlink in nextpage and page no.
	var $htmlPageNo	=	false;

//*************** additional variable to store ID **********

	function getTotalRecords()
	{
		if(!empty($this->primaryColumn))
		{
			$query = "SELECT $this->primaryColumn FROM $this->table $this->whereClause";
			//echo $query;
			$total_result = @mysql_num_rows(mysql_query($query));
		}
		else
		{
			$query = "SELECT count(0) FROM $this->table $this->whereClause";
			//echo $query;
			$total_result = @mysql_result(mysql_query($query),0);
		}
		
		$this->totalRecords =	$total_result;
		return $this->totalRecords;
	}

	function setPageNo()
	{
		if($this->recordNo != 0)
		{
			$this->pageNo = floor(($this->recordNo/$this->recsPerPage)+1);
		}
		else
		{
			$this->pageNo = 1;
		}

		$this->pageFrom = ($this->pageNo - $this->pageNo % $this->showPages) + 1;
		$this->recordNo = ($this->pageFrom-1)*$this->recsPerPage;

		// if current page is last page in displayed paging list 
		if($this->pageNo % $this->showPages == 0)
		{
			$this->pageFrom = $this->pageFrom - $this->showPages;
			$this->recordNo = $this->recordNo - ($this->showPages * $this->recsPerPage);
		}
	}

	function activateHtmlPageNo()
	{
			if($this->recordNo>=1)
			{
				$this->recordNo--;
				$this->recordNo *= $this->recsPerPage;
			}
			else
			{
				$this->recordNo = 0;
			}
			$this->startRow = $this->recordNo;
			$this->htmlPageNo = true;
	}

	function getRecords()
	{	
		if(!empty($this->orderBy))
			$this->orderBy = "ORDER BY $this->orderBy";

		$query = "SELECT $this->selectColumns FROM $this->table $this->whereClause $this->orderBy limit $this->startRow,$this->recsPerPage";

		//echo $query;
		$result = mysql_query($query) or die(mysql_error());
		
		if($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
		
	}


	function displayPaging($queryString)
	{	
		$totalPages = $this->getTotalPages();

		if($totalPages > 1)
		{
			// if we don't have much records to be display complete paging list then adjust pageupto
			$pageUpto = 0;
			if(($pageUpto*$this->recsPerPage) > $this->totalRecords)
			{	
				if($this->totalRecords % $this->recsPerPage == 0)
				{
					$pageUpto = floor(($this->totalRecords/$this->recsPerPage));
				}
				else
				{
					$pageUpto = floor(($this->totalRecords/$this->recsPerPage))+1;
				}
			}
			if( $totalPages > $this->showPages)
			{
				if($this->pageNo < floor($this->showPages/2))
				{
					 $pageUpto = $this->pageFrom + $this->showPages-1;
						 
				}
				else
				{
					 $addRight			= floor($this->showPages/2);
					 $subLeft			= $this->showPages - floor($this->showPages/2) - 1;
					 
					 $pageUpto			=  $this->pageNo + $addRight;
					 $this->pageFrom	=  $this->pageNo - $subLeft;	
					 

					 if($pageUpto > $totalPages)
					 {

						$leftOverEnd	=	$pageUpto - $totalPages;
						$this->pageFrom =	$this->pageFrom - $leftOverEnd;
						$pageUpto		=	$totalPages;

					 }
					 if($this->pageFrom < 1)
					{
						$pageUpto		=	$this->showPages;		
						$this->pageFrom	=	1;
					}
				}
			}					 
			else
			{
				$pageUpto		=	$totalPages;		
				$this->pageFrom	=	1;
			}

		//}
		echo "<br>";		
		//echo "<center>";
		
			if(!$this->htmlPageNo)
			{
				
				//echo "<br><br>";
				//echo "Pages: ";
				//echo "<font font-family:verdana;font-size:12;color:#7E7E7E;>Displaying ".$this->pageNo." of $totalPages pages</font> ";
				
				if($pageUpto > $this->showPages)
				{
					echo "<a href='". $this->path . "?recNo=0".$queryString."' title='Go to page ".$totalPages."' class='paging_text'>First</a>&nbsp;";
				}
				
				if($this->pageNo > 1)
				{

					echo "<a  href='". $this->path . "?recNo=".($this->pageNo-2)*$this->recsPerPage . $queryString."' title='Go to page ".($this->pageNo -1)."' class='paging_text'>Previous</a>&nbsp;";	
				}
				else
				{
					echo "<font class='paging_text'>Previous</font>";
				}
				
				
				// display the numbered links in paging list
				for($z=$this->pageFrom; $z<=$pageUpto; $z++)
				{
					$this->recordNo = ($z-1) * $this->recsPerPage;
					// if displaying current page disable link
					if($this->pageNo == $z) 
					{
						echo "&nbsp;<font class='paging_text1'><b>$z</b></font> ";
					}
					else
					{
						echo "&nbsp;<a href='". $this->path . "?recNo=$this->recordNo".$queryString."' title='Go to page ".$z."' class='paging_text'><b>$z</b></a> ";
					}
					
				}
				
				//echo "</center>";
				if($this->pageNo < $totalPages)
				{
					
					echo "<a href='". $this->path . "?recNo=".  ($this->pageNo)*$this->recsPerPage.$queryString."' title='Go to page ".($this->pageNo + 1)."' class='paging_text'>Next</a>";	
					echo "<INPUT TYPE='hidden' name='nxtp' value='".($this->pageNo)*$this->recsPerPage."'>";
				}
				else
				{
					echo "<font class='paging_text'>Next</font>";
				}
				if($totalPages > $pageUpto)
				{
					//echo "ggg-".$this->pageFrom;
					$gotoPage		=	($totalPages-1)*$this->recsPerPage;
					echo "<a href='". $this->path . "?recNo=$gotoPage".$queryString."' title='Go to page ".$totalPages."' class='paging_text'>Last</a>";
				}
				echo "<br>";
			}
			else 
			{
					if($this->pageNo > 1)
					{

						echo "<a  href='". $this->path . "/".($this->pageNo -1).".htm' title='Go to page ".($this->pageNo -1)."' class='paging_text'>Previous</a>&nbsp;";	
					}
					else
					{
						echo "<font class='paging_text'>Previous</font>";
					}

					//echo "<br><br>";
					///echo "Pages : ";
					// display the numbered links in paging list
					for($z=$this->pageFrom; $z<=$pageUpto; $z++)
					{
						$this->recordNo = ($z-1) * $this->recsPerPage;
						// if displaying current page disable link
						if($this->pageNo == $z) 
						{
							echo "&nbsp;<font class='paging_text1'><b>$z</b></font> ";
						}
						else
						{
							echo "&nbsp;<a href='". $this->path . "/$z.htm' title='Go to page ".$z."'><font class='paging_text' size=2><b>$z</b></font></a> ";
						}
						
					}
					if($this->pageNo < $totalPages)
					{
						echo "<a href='". $this->path . "/". ($this->pageNo + 1) .".htm' title='Go to page ".($this->pageNo + 1)."' class='paging_text'>Next</a>";	
					}
					else
					{
						echo "<font class='paging_text'>Next</font>";
					}
					echo "<br>";
			}
			//echo "</center>";	
		}// End of if($totalPages > 1)
	}


	function getTotalPages()
	{
		// get total number of pages
		if($this->totalRecords % $this->recsPerPage == 0)
		{
			$totalPages = floor($this->totalRecords / $this->recsPerPage);
		}
		else
		{
			$totalPages = floor(($this->totalRecords / $this->recsPerPage))+1;
		}
		return $totalPages;
	}
}
?>