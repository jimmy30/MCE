<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add PlaceCast.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");

//// Include DO BO class for State Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/StateDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/StateBO.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/PlaceCastDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/PlaceCastBO.php");

//// Include DO BO class for PlacecastDownload Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/PlaceCastDownloadDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/PlaceCastDownloadBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/pclzip.lib.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utilities.php");

/// Include XML Encode class
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");	




class ViewPlaceCastService
{
			
	/// LIST PLACECAST Active
	function AdvanceSearch($start,$limit,$query,$arrQueryChecks,$pIntIsActive,$pIntSortListBy)
	{
		$objPlaceCastDAO = new PlaceCastDAO();
		$objPlaceCastBOAarray=$objPlaceCastDAO->AdvanceSearch($start,$limit,$query,$arrQueryChecks,$pIntIsActive,$pIntSortListBy);

		//// Generating Comobox items
		if ($objPlaceCastBOAarray[0][0]!=null)
		{

			$intCount = count($objPlaceCastBOAarray[0][0]);

			$strXML='<PlaceCasts>';
			$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><PlaceCastList>';
			
			for($i=0; $i<$intCount; $i++)
			{

				$objPlaceCastBO=$objPlaceCastBOAarray[0][0][$i];
				$objPlaceCastBO=(object)$objPlaceCastBO;
				
				$objCountryBO=$objPlaceCastBOAarray[0][1][$i];
				$objCountryBO=(object)$objCountryBO;
				
				$objStateBO=$objPlaceCastBOAarray[1][1][$i];
				$objStateBO=(object)$objStateBO;
				
				$strXML.='<PlaceCast>';
				$strXML.='<PlaceCastId>'.$objPlaceCastBO->getPlaceCastId().'</PlaceCastId>';
				$strXML.='<PlaceCastName>'.$objPlaceCastBO->getPlaceCastName().'</PlaceCastName>';
				$strXML.='<PlaceCastAddress>'.$objPlaceCastBO->getPlaceCastAddress().'</PlaceCastAddress>';				
				$strXML.='<PlaceCastCity>'.$objPlaceCastBO->getPlaceCastCity().'</PlaceCastCity>';								
				$strXML.='<PlaceCastCountryName>'.$objCountryBO->getCountryName().'</PlaceCastCountryName>';
				$strXML.='<PlaceCastStateName>'.$objStateBO->getStateName().'</PlaceCastStateName>';																
				$strXML.='<PlaceCastStateZipCode>'.$objPlaceCastBO->getPlaceCastZipCode().'</PlaceCastStateZipCode>';				
				$strXML.='</PlaceCast>';
				
			}
			$strXML.='</PlaceCastList></PlaceCasts>';
		}
		return $strXML;
	}	 


/*=================================================================================
		Function Name 	: PlaceCastSearchRecordCount
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/

	function PlaceCastSearchRecordCount($query,$arrQueryChecks,$pIntIsActive)
	{
		/// Call procedure
		$objPlaceCastDAO = new PlaceCastDAO();
		$numRows=$objPlaceCastDAO->PlaceCastSearchRecordCount($query,$arrQueryChecks,$pIntIsActive);
		return $numRows;
	}	 


/*=================================================================================
		Function Name 	: getPagingLimit
		Created On    	: 01-Aug-2006 
		Synopsis	  	: set pagming limit values according page no
		Input Parameter : integer page No
		Returns		  	: integer start limit, integer no. of rows
=================================================================================*/

	function getPagingLimit($pIntPageNo)
	{
		$objPlaceCastDAO = new PlaceCastDAO();
		$limit = $objPlaceCastDAO->getPagingLimit();
		
		if($pIntPageNo == 1 || $pIntPageNo==null)
		{
			$startLimit = 0;
		}
		else
		{
			$startLimit = $pIntPageNo * $limit - ($limit); 		
		}
		
		$arrayPagingLimit[0]=$startLimit;
		$arrayPagingLimit[1]=$limit;
		return $arrayPagingLimit;
		
	}	 

/*=================================================================================
		Function Name 	: paging
		Created On    	: 01-Aug-2006 
		Synopsis	  	: generate paging html
		Input Parameter : integer page No, integer total no. of rows
		Returns		  	: string HTML paging
=================================================================================*/

	function paging($pIntPageNo,$intNumRows)
	{
		$objPlaceCastDAO = new PlaceCastDAO();
		$recordLimit = $objPlaceCastDAO->getPagingLimit();
		$pagesLimit = $objPlaceCastDAO->getPagesLimit();
		
		$intNumPages = ceil($intNumRows / $recordLimit);

		$intStartPage=1;
		$intEndPage=$intNumPages;

		if($intNumPages>$pagesLimit)
		{
			$intEndPage=$pagesLimit;
			$intMidPageValue=ceil($pagesLimit/2);
			
			if($pIntPageNo>$intMidPageValue)
			{
				$intStartPage=$pIntPageNo-$intMidPageValue+1;
				$intEndPage=$pIntPageNo+$intMidPageValue-1;
				if(($pIntPageNo-1)>($intNumPages-$intMidPageValue))
				{
					$intStartPage=$intNumPages-$pagesLimit+1;
					$intEndPage=$intNumPages;
				}
			}
		}
		
		if($intNumRows>=$recordLimit) 
		{
			$stringHtml="";
			if($pIntPageNo <= 1) 
			{
				$stringHtml.="<img border=0 align=middle src=/ImageFiles/common/paging/pre.gif>";
			}
			else
			{
				$pvs = $pIntPageNo -1;
				$stringHtml.="<a class=links href=# onclick=GoToPage(". $pvs .")><img border=0 align=middle src=/ImageFiles/common/paging/pre.gif></a>";
			}
				 
			for($_i = $intStartPage ; $_i <= $intEndPage ; $_i++)
			{
				if($_i == $pIntPageNo) 
				{
					$stringHtml.= "&nbsp;<font color=black>".$_i."</font>&nbsp;&nbsp;";
				}
				else 
				{
					$stringHtml.= "&nbsp;<a href=# onclick=GoToPage('".$_i."') class=LinkSmall>".$_i."</a>&nbsp;&nbsp;";
				}
			}
			
			if($pIntPageNo >= $intNumPages)
			{
				$stringHtml.= "<img border=0 align=middle src=/ImageFiles/common/paging/next.gif><br>(Total Pages:".$intNumPages.")";
			}
			else
			{
				$nxt = $pIntPageNo + 1;
				$stringHtml.= "<a class=links href=# onclick=GoToPage('". $nxt ."')><img border=0 align=middle src=/ImageFiles/common/paging/next.gif></a><br>(Total Pages:".$intNumPages.")";
			}
		}
		return $stringHtml;
	}	 
	function getListPlaceCastFolder($pIntPlaceCastId)
	{
		if (is_dir($_SERVER['DOCUMENT_ROOT'].'/Contents/PlaceCasts/'.$pIntPlaceCastId))
		{
			return $pIntPlaceCastId;
		}
	}
	function downloadPlaceCast($pIntPlaceCastId,$pConsumerId,$pPlaceCastDownloadCreateDate,$pPlaceCastDownloadIsActive)
	{
		 
		/*
		$objPlaceCastDAO = new PlaceCastDAO();
		$result=$objPlaceCastDAO->getWaypointIdByPlaceCast($pIntPlaceCastId);

		mkdir($_SERVER['DOCUMENT_ROOT'].'/Temp/'.$pIntPlaceCastId);
		
		while($objRow=$result->fetch_assoc( )) 
		{

			$strSourcePath = $_SERVER['DOCUMENT_ROOT'].'/Contents/PlaceCastsc/'.$objRow["WaypointId"];
			$strDestinationPath = $_SERVER['DOCUMENT_ROOT'].'/Temp/'.$pIntPlaceCastId.'/'.$objRow["WaypointId"];
			copydirr($strSourcePath,$strDestinationPath ,0777,true);
		}
		*/
		// To Do......
		//$strSourcePath = $_SERVER['DOCUMENT_ROOT'].'/Contents/PlaceCasts/'.$pIntPlaceCastId.'/Waypoints';		
		$strSourcePath = $_SERVER['DOCUMENT_ROOT'].'/Contents/PlaceCasts/'.$pIntPlaceCastId;		
		
		$checkFilePath=$_SERVER['DOCUMENT_ROOT'].'/Contents/PlaceCasts/'.$pIntPlaceCastId.'.zip';
		$strDestinationPath=$_SERVER['DOCUMENT_ROOT'].'/Contents/PlaceCasts/'.$pIntPlaceCastId.'.zip';
		if(file_exists($checkFilePath))
		{
			unlink($checkFilePath);
		}
		$archive = new PclZip($strDestinationPath);
		$v_list = $archive->create($strSourcePath,PCLZIP_OPT_REMOVE_ALL_PATH);
		if ($v_list == 0) 
		{
			return "error";
			//die("Error : ".$archive->errorInfo(true));
		}
		else
		{
			try
			{
				$objPlaceCastDownloadBO = new PlaceCastDownloadBO();
				$objPlaceCastDownloadBO->setConsumerId($pConsumerId);
				$objPlaceCastDownloadBO->setPlaceCastId($pIntPlaceCastId);
				$objPlaceCastDownloadBO->setPlaceCastDownloadCreateDate($pPlaceCastDownloadCreateDate);
				$objPlaceCastDownloadBO->setPlaceCastDownloadIsActive($pPlaceCastDownloadIsActive);
				
				$objPlaceCastDownloadDAO = new PlaceCastDownloadDAO();
				$objPlaceCastDownloadDAO->insert($objPlaceCastDownloadBO);
			}
			catch(Exception $e)
				{
					return "exception";				
				}
			return "ok";
		}
		
	}
	
	
	/// Mapping functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('AdvanceSearch','PlaceCastSearchRecordCount','getPagingLimit','paging','downloadPlaceCast','getListPlaceCastFolder'));

		NAJAX_Client::publicMethods($this, array('AdvanceSearch','PlaceCastSearchRecordCount','getPagingLimit','paging','downloadPlaceCast','getListPlaceCastFolder'));
	}

	
}

?>
