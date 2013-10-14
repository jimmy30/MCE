<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add Waypoint.
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
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/WaypointDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/WaypointBO.php");

//// Include DO BO class for PlaceCast Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/PlaceCastDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/PlaceCastBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/pclzip.lib.php");	

/// Include XML Encode class
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");	

/// Include Manage Files Class
require_once($_SERVER['DOCUMENT_ROOT']."/ManageFile.php");	


/// Include Utilities Files Class
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utilities.php");

class ViewWaypointService
{

	var $strWaypointContentDirectory;
	
	function __construct()
	{
		/// Loading property file
		$objProperties=new Properties();
		$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
		
		/// Get DB Waypoint Content Directory from property file
		$this->strWaypointContentDirectory = $objProperties->getProperty('waypoint_content_directory');

	}

	/// LIST WAYPOINT BY PRODUCER ID
	function GetListByPlaceCastId($pIntPlaceCastId,$start,$limit,$pIntIsActive,$pIntSortListBy)
	{
		$objWaypointDAO = new WaypointDAO();
		$objWaypointBOAarray=$objWaypointDAO->GetListByPlaceCastId($pIntPlaceCastId,$start,$limit,$pIntIsActive,$pIntSortListBy);

		//// Generating Comobox items
		if ($objWaypointBOAarray!=null)
		{

			$intCount = count($objWaypointBOAarray);

			$strXML='<Waypoints>';
			$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><WaypointList>';
			
			for($i=0; $i<$intCount; $i++)
			{

				$objWaypointBO=$objWaypointBOAarray[$i];
				$objWaypointBO=(object)$objWaypointBO;
				
				$strXML.='<Waypoint>';
				$strXML.='<WaypointId>'.$objWaypointBO->getWaypointId().'</WaypointId>';
				$strXML.='<WaypointName>'.$objWaypointBO->getWaypointName().'</WaypointName>';
				$strXML.='<WaypointAddress>'.$objWaypointBO->getWaypointAddress().'</WaypointAddress>';				
				$strXML.='<WaypointCity>'.$objWaypointBO->getWaypointCity().'</WaypointCity>';
				$strXML.='<WaypointIsActive>'.$objWaypointBO->getWaypointIsActive().'</WaypointIsActive>';			
				$strXML.='</Waypoint>';
			}
			$strXML.='</WaypointList></Waypoints>';

		}
		return $strXML;		
	}	 
	function GetPlaceCastById($pPlaceCastId,$pIsActive)	 
	{
		/// set parameter in an object
		$objPlaceCastBO=new PlaceCastBO();
		$objPlaceCastBO->setPlaceCastId($pPlaceCastId);
		$objPlaceCastBO->setPlaceCastIsActive($pIsActive);		
		
		/// get results in an object
		$objPlaceCastDAO = new PlaceCastDAO();
		$objArrayBO=$objPlaceCastDAO->selectById($objPlaceCastBO);
		$objPlaceCastBO = $objArrayBO[0];
		$objCountryBO = $objArrayBO[1];
		$objStateBO = $objArrayBO[2];		
		

		//// Generating Comobox items
		if ($objPlaceCastBO!=null)
		{

			$intCount = count($objPlaceCastBO);

			$strXML='<PlaceCasts>';
			$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><PlaceCastList>';
			
			$strXML.='<PlaceCast>';
			$strXML.='<PlaceCastId>'.$objPlaceCastBO->getPlaceCastId().'</PlaceCastId>';
			$strXML.='<PlaceCastName>'.$objPlaceCastBO->getPlaceCastName().'</PlaceCastName>';
			$strXML.='<PlaceCastAddress>'.$objPlaceCastBO->getPlaceCastAddress().'</PlaceCastAddress>';				
			$strXML.='<PlaceCastCity>'.$objPlaceCastBO->getPlaceCastCity().'</PlaceCastCity>';								
			$strXML.='<PlaceCastCountryName>'.$objCountryBO->getCountryName().'</PlaceCastCountryName>';
			$strXML.='<PlaceCastStateName>'.$objStateBO->getStateName().'</PlaceCastStateName>';																
			$strXML.='<PlaceCastStateZipCode>'.$objPlaceCastBO->getPlaceCastZipCode().'</PlaceCastStateZipCode>';				
			$strXML.='</PlaceCast>';
			$strXML.='</PlaceCastList></PlaceCasts>';

		}
		return $strXML;		

	}


	/// LIST WAYPOINT Active
	function GetListActive($start,$limit,$pIntIsActive,$pIntSortListBy)
	{
		$objWaypointDAO = new WaypointDAO();
		$objWaypointBOAarray=$objWaypointDAO->GetListActive($start,$limit,$pIntIsActive,$pIntSortListBy);

		//// Generating Comobox items
		if ($objWaypointBOAarray[0][0]!=null)
		{

			$intCount = count($objWaypointBOAarray[0][0]);

			$strXML='<Waypoints>';
			$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><WaypointList>';
			
			for($i=0; $i<$intCount; $i++)
			{

				$objWaypointBO=$objWaypointBOAarray[0][0][$i];
				$objWaypointBO=(object)$objWaypointBO;
				
				$objCountryBO=$objWaypointBOAarray[0][1][$i];
				$objCountryBO=(object)$objCountryBO;
				
				$objStateBO=$objWaypointBOAarray[1][1][$i];
				$objStateBO=(object)$objStateBO;
				
				
				$strXML.='<Waypoint>';
				$strXML.='<WaypointId>'.$objWaypointBO->getWaypointId().'</WaypointId>';
				$strXML.='<WaypointName>'.$objWaypointBO->getWaypointName().'</WaypointName>';
				$strXML.='<WaypointAddress>'.$objWaypointBO->getWaypointAddress().'</WaypointAddress>';				
				$strXML.='<WaypointCity>'.$objWaypointBO->getWaypointCity().'</WaypointCity>';								
				$strXML.='<WaypointCountryName>'.$objCountryBO->getCountryName().'</WaypointCountryName>';
				$strXML.='<WaypointStateName>'.$objStateBO->getStateName().'</WaypointStateName>';																
				$strXML.='<WaypointStateZipCode>'.$objWaypointBO->getWaypointZipCode().'</WaypointStateZipCode>';
				$strXML.='<WaypointCountryId>'.$objWaypointBO->getWaypointCountryId().'</WaypointCountryId>';				
				$strXML.='</Waypoint>';
				
			}
			$strXML.='</WaypointList></Waypoints>';
		}
		return $strXML;
	}	 


	function WaypointDeleteById($pWaypointId,$pPlaceCastId)
	{

		/// Generating XML as response
		$this->strResponse="<Response>";	
		try
		{
			
			
			/// Call Delete waypoint 
			$objWaypointDAO = new WaypointDAO();
			$objWaypointDAO->WaypointDeleteById($pWaypointId);
			/// delete waypoint contents
			$objFile = new ManageFile();
			// To Do..
			$source=$_SERVER['DOCUMENT_ROOT']."/Contents/PlaceCasts/".$pPlaceCastId."/Waypoints/".$pWaypointId;
			RemoveFiles($source);
			
			//$blnStatus=$objFile->deleteContent($pWaypointId,$pPlaceCastId);
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objWaypointDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
			
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}	 

/*=================================================================================
		Function Name 	: WaypointRecordCount
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/

	function WaypointRecordCount($pIntIsActive)
	{
		/// Call procedure
		$objWaypointDAO = new WaypointDAO();
		$numRows=$objWaypointDAO->WaypointRecordCount($pIntIsActive);
		return $numRows;
	}	 

/*=================================================================================
		Function Name 	: WaypointRecordCountByPlaceCast
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/

	function WaypointRecordCountByPlaceCast($pIntPlaceCastId,$pIntIsActive)
	{
		/// Call procedure
		$objWaypointDAO = new WaypointDAO();
		$numRows=$objWaypointDAO->WaypointRecordCountByPlaceCast($pIntPlaceCastId,$pIntIsActive);
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
		$objWaypointDAO = new WaypointDAO();
		$limit = $objWaypointDAO->getPagingLimit();
		
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
		$objWaypointDAO = new WaypointDAO();
		$recordLimit = $objWaypointDAO->getPagingLimit();
		$pagesLimit = $objWaypointDAO->getPagesLimit();
		
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

/*=================================================================================
		Function Name 	: getListWaypointFolder
		Created On    	: 03-Aug-2006 
		Synopsis	  	: get content of Waypoint Folder
		Input Parameter : none
		Returns		  	: string Array 
=================================================================================*/

	function getListWaypointFolder($pIntPlaceCastId)
	{

		// To Do..
			if ($handle = opendir($_SERVER['DOCUMENT_ROOT']."/Contents/PlaceCasts/".$pIntPlaceCastId."/Waypoints")) 
			{
			   while (false !== ($file = readdir($handle))) 
			   {
				   $arrayFolderContent[]=$file;
			   }
			   closedir($handle);
			}
		   return $arrayFolderContent;
	}	 

	function ToggleIsActive($pIntWaypointId,$pIntIsActive)
	{

		$objWaypointDAO = new WaypointDAO();
		$intStatus = $objWaypointDAO ->ToggleIsActive($pIntWaypointId,$pIntIsActive);
		return $intStatus;
	}

	function downloadWayPoint($pIntWaypointId,$pIntPlaceCastId)
	{
		// To Do.......
		$strSourcePath = $_SERVER['DOCUMENT_ROOT'].'/Contents/PlaceCasts/'.$pIntPlaceCastId.'/Waypoints/'.$pIntWaypointId;
		$strFilePath= $_SERVER['DOCUMENT_ROOT'].'/Contents/Waypoints/'.$pIntWaypointId.".zip";
		//$strFilePath= $_SERVER['DOCUMENT_ROOT'].'/Contents/PlaceCasts/'.$pIntPlaceCastId.'/Waypoints/'.$pIntWaypointId.".zip";
	//	return $strSourcePath;
//		return $strFilePath;
		if(file_exists($strFilePath))
		{
			unlink($strFilePath);
		}
		$archive = new PclZip($strFilePath);
		$v_list = $archive->create($strSourcePath,PCLZIP_OPT_REMOVE_ALL_PATH);
		if ($v_list == 0) 
		{
			return $archive->errorInfo(true);
			//die("Error : ".$archive->errorInfo(true));
		}
		else
			return "ok";
	}	 

	/// Mapping functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('GetListByPlaceCastId','GetListActive','WaypointDeleteById','WaypointRecordCount','WaypointRecordCountByPlaceCast','getPagingLimit','paging','getListWaypointFolder','ToggleIsActive','downloadWayPoint','GetPlaceCastById'));

		NAJAX_Client::publicMethods($this, array('GetListByPlaceCastId','GetListActive','WaypointDeleteById','WaypointRecordCount','WaypointRecordCountByPlaceCast','getPagingLimit','paging','getListWaypointFolder','ToggleIsActive','downloadWayPoint','GetPlaceCastById'));
	}

	
}

?>
