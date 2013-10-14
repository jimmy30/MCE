<?php
/*=================================================================================
		Class Name    : AdsDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with Ads,Page,Groups Tables
		Created On    : 19-Sept-2006 
=================================================================================*/
class AdsDAO
{
		//// Declaring DB connection and objects and variables
		var $objDB;
				
		/// Declaring paging variables
		var $recordLimit;
		var $pagesLimit;

		/// Declaring Error handling variables
		var $strErrorMessage;
		var $intErrorNo;
		
		/*=================================================================================
				Function Name : Custoructor
				Synopsis	  : Loading and get values from property file 
								and establishing DB connection 
				Created On    : 19-Sept-2006 
		=================================================================================*/

		function __construct()
		{
			
			
			// Loading property file
			$objProperties=new Properties();
			$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
			
			
			/// GEt Paging variables from property file
			$this->recordLimit = $objProperties->getProperty('ads_paging_record_limit');
			$this->pagesLimit = $objProperties->getProperty('ads_paging_pages_limit');
			
			/// Connect With Database
			$this->objDB=Database::singleton();
			
			// Exception thrown incase of error connecting with DB
			if (mysqli_connect_errno())
			{ 
   				throw new DatabaseConnectivityException();
			}
			
		}
		
		
		/*=================================================================================
				Function Name 	: InsertAds
				Created On    	: 21-Sept-2006 
				Synopsis	  	: Insert record 
				Input Parameter : object AdsBO (All fields)
				Returns		  	: Status
		=================================================================================*/
		function InsertAds($pObjAdsBO)
		{

			//$this->test();
			
			/// Calling Stored Procedure
			$strQuery = "CALL ADDs_INSERT(?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("isssssiss",$pObjAdsBO->getAdsId()
											   ,$pObjAdsBO->getAdsName()
											   ,$pObjAdsBO->getAdsDescription()
											   ,$pObjAdsBO->getImagePath()
											   ,$pObjAdsBO->getExpiryDate()											   
											   ,$pObjAdsBO->getCreateDate()
											   ,$pObjAdsBO->getActive()
											   ,$pObjAdsBO->getAdSize()
											   ,$pObjAdsBO->getSinffet());
			
			$objStatement->execute();
			$objStatement->bind_result($intStatus);
			$objStatement->fetch();			

			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
			
			if ($this->intErrorNo!=0) // Error exists
			{
				
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}
			$objStatement->close();
			return $intStatus;
		}
		
		/*=================================================================================
				Function Name 	: GetListPageGroup
				Created On    	: 20-Sept-2006 
				Synopsis	  	: Get all list of pages and groups
				Input Parameter : none
				Returns		  	: 
		=================================================================================*/
		function GetListPageGroup()
		{
			/// Calling Stored Procedure	
	   		$strQuery = "CALL PAGEGROUP_LIST()";
			$objStatement=$this->objDB->executeQuery($strQuery);
			while ($row=$objStatement->fetch_array()) 
			{ 
				$objAdstBO=new AdsBO();
				$objAdstBO->setPageId($row[0]);
				$objAdstBO->setPageName($row[1]);
				$objAdstBO->setGroupId($row[2]);
				$objAdstBO->setGroupName($row[3]);
				$objObjectArray[0][]=$objAdstBO;

    		} 

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$objStatement->close(); 
			return $objObjectArray;
		
		}
		/*=================================================================================
		Function Name 	: GetAddsList
		Created On    	: 22-Sept-2006 
		Synopsis	  	: Get all list of Adds
		Input Parameter : (StartIndex,EndIndex,Sort Order(1=desc,0=Asec))
		Returns		  	: Array of Object (All fields)
		=================================================================================*/

	   function GetAddsList($pIntStart,$pIntNumRows,$pIntSortListBy)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL GET_ADDS_LIST(".$pIntStart.",".$pIntNumRows.",".$pIntSortListBy.")";
			$objStatement=$this->objDB->executeQuery($strQuery);

			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
			{ 
				$objAdsBO=new AdsBO();
				$objAdsBO->setAdsId($row[0]);
				$objAdsBO->setAdsName($row[1]);
				$objAdsBO->setImagePath($row[2]);
				$objAdsBO->setExpiryDate($row[3]);
				$objAdsBO->setCreatedDate($row[4]);
				$objAdsBO->setActive($row[5]);
				$objAdsBO->setAdSize($row[6]);
				$objAdsBO->setSniffet($row[7]);
				$objObjectArray[0][]=$objAdsBO;

			} 
			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$objStatement->close(); 
			return $objObjectArray;
	   }

		/*=================================================================================
				Function Name 	: GetMaxId
				Created On    	: 21-Sept-2006 
				Synopsis	  	: Get max id of Ads table
				Input Parameter : none
				Returns		  	: max id
		=================================================================================*/
		function GetMaxId($pObjAdsBO)
		{
			/// Calling Stored Procedure	
	   		$strQuery = "CALL GET_ADDS_MAX_ID()";
			$objStatement=$this->objDB->executeQuery($strQuery);
			while ($row=$objStatement->fetch_array()) 
			{ 
	
				$pObjAdsBO->setAdsId($row[0]);

    		} 

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$objStatement->close(); 
			return $pObjAdsBO;
		
		}
		
		/*=================================================================================
		Function Name 	: getPagingLimit
		Created On    	: 22-Sept-2006 
		Synopsis	  	: get paging limit value form property file
		Input Parameter : none
		Returns		  	: integer record limit
		=================================================================================*/
		function getPagingLimit()
		{
			return $this->recordLimit;
		}

		/*=================================================================================
		Function Name 	: getPagesLimit
		Created On    	: 22-Sept-2006 
		Synopsis	  	: get pages limit value form property file
		Input Parameter : none
		Returns		  	: integer pages limt
		=================================================================================*/
		function getPagesLimit()
		{
			return $this->pagesLimit;
		}
		/*=================================================================================
		Function Name 	: AlertRecordCountByConsumer
		Created On    	: 22-Sept-2006 
		Synopsis	  	: count total no. of records
		Input Parameter : 
		Returns		  	: integer count
	=================================================================================*/
		function AddsRecords()
		{
			$strQuery = "CALL ADDS_RECORD_COUNT()";
			$objStatement=$this->objDB->executePrepare($strQuery);
			//$objStatement->bind_param();
			$objStatement->execute();
			
			$objStatement->bind_result($numRows);
			$objStatement->fetch();			
			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}

			$objStatement->close();
			return $numRows;
		
		}
		/*=================================================================================
		Function Name 	: AddsDeleteById
		Created On    	: 22-Sept-2006 
		Synopsis	  	: Delete add recrord against add id.
		Input Parameter : integer Add id
		Returns		  	: 
	=================================================================================*/
		function AddsDeleteById($pIntAddId)
		{
			
			$strQuery = "CALL ADD_DELETE_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pIntAddId);
			$objStatement->execute();
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}

			$objStatement->close(); 
		}
		/*=================================================================================
		Function Name 	: GetAddsById
		Created On    	: 25-Sept-2006 
		Synopsis	  	: Get all add information against add id
		Input Parameter : integer Add id
		Returns		  	: Adds BO object.
		=================================================================================*/
		function GetAddsById($pAddsId)
		{

			/// Calling Stored Procedure	
	   		$strQuery = "CALL GET_ADDS_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			
			$objStatement->bind_param("i",$pAddsId);
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result(
										$pIntAddsId, 
										$pStrAddName, 
										$pStrAddDescription, 
										$pStrAddImage,
										$pDteExpireDate,
										$pDteCreateDate,
										$pIntIsActive,
										$pStrAdSize,
										$pStrSniffet
										); 

			$objStatement->fetch();
			
		
			/// set results in a object

				$objAdsBO=new AdsBO();

				$objAdsBO->setAdsId($pIntAddsId);
				$objAdsBO->setAdsName($pStrAddName);
				$objAdsBO->setAdsDescription($pStrAddDescription);
				$objAdsBO->setImagePath($pStrAddImage);
				$objAdsBO->setExpiryDate($pDteExpireDate);
				$objAdsBO->setCreatedDate($pDteCreateDate);
				$objAdsBO->setActive($pIntIsActive);
				$objAdsBO->setAdSize($pStrAdSize);
				$objAdsBO->setSniffet($pStrSniffet);
				

				
			

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$objStatement->close(); 
	
			return $objAdsBO;
		}
		/*=================================================================================
		Function Name 	: GetGroupsByAddId
		Created On    	: 25-Sept-2006 
		Synopsis	  	: Get GroupId and Group Name against add id
		Input Parameter : integer Add id
		Returns		  	: Adds BO object (GroupId, GroupName).
		=================================================================================*/
		function GetGroupsByAddId($pIntAddId)
		{

			$strQuery = "CALL GET_GROUP_BY_ADDID(".$pIntAddId.")";
			$objStatement=$this->objDB->executeQuery($strQuery);
			while ($row=$objStatement->fetch_array()) 
			{ 
				$objAdsBO=new AdsBO();
				$objAdsBO->setGroupId($row[0]);
				$objAdsBO->setGroupName($row[1]);
				$objObjectArray[0][]=$objAdsBO;

    		} 

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$objStatement->close(); 
			return $objObjectArray;
		}
		
		/*=================================================================================
		Function Name 	: GetImageList
		Created On    	: 28-Sept-2006 
		Synopsis	  	: Get ImageList against page name
		Input Parameter : string Page name
		Returns		  	: Adds BO object 
		=================================================================================*/
		function GetImageList($pStrPageName)
		{


			$strQuery = "CALL GET_IMAGE_LIST_BY_PAGE('".$pStrPageName."')";

			$objStatement=$this->objDB->executeQuery($strQuery);
			while ($row=$objStatement->fetch_array()) 
			{ 
				$objAdsBO=new AdsBO();
				$objAdsBO->setAdsId($row[0]);
				$objAdsBO->setImagePath($row[1]);
				$objAdsBO->setGroupId($row[1]);
				$objObjectArray[0][]=$objAdsBO;

    		} 

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$objStatement->close(); 
			return $objObjectArray;
		}
		/*=================================================================================
		Function Name 	: GetSniffetList
		Created On    	: 07-Nov-2006 
		Synopsis	  	: Get SniffetList against page name
		Input Parameter : string Page name
		Returns		  	: Adds BO object 
		=================================================================================*/
		function GetSniffetList($pStrPageName)
		{


			$strQuery = "CALL GET_SNIFFED_LIST_BY_PAGE('".$pStrPageName."')";

			$objStatement=$this->objDB->executeQuery($strQuery);
			while ($row=$objStatement->fetch_array()) 
			{ 
				$objAdsBO=new AdsBO();
				$objAdsBO->setAdsId($row[0]);
				$objAdsBO->setSniffet($row[1]);
				$objAdsBO->setGroupId($row[2]);
				$objAdsBO->setAdSize($row[3]);
				$objObjectArray[0][]=$objAdsBO;

    		} 

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$objStatement->close(); 
			return $objObjectArray;
		}
		/*=================================================================================
		Function Name 	: UpdateAdds
		Created On    	: 26-Sept-2006 
		Synopsis	  	: Update Adds information against AddsId.
		Input Parameter : AddsId,AddName,Description,Image,ExpireDate,IsActive
		Returns		  	: Adds BO object (GroupId, GroupName).
		=================================================================================*/
		function UpdateAdds($pObjAddsBO,$pIntStatus)
		{

			/// Calling Stored Procedure	
			$strQuery = "CALL UPDATE_ADD_BY_ID(?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("issssiiss",$pObjAddsBO->getAdsId()
											   ,$pObjAddsBO->getAdsName()
											   ,$pObjAddsBO->getAdsDescription()
											   ,$pObjAddsBO->getImagePath()
											   ,$pObjAddsBO->getExpiryDate()
											   ,$pObjAddsBO->getActive()
											   ,$pIntStatus
											   ,$pObjAddsBO->getAdSize()
											   ,$pObjAddsBO->getSinffet());
			$objStatement->execute();
			$objStatement->bind_result($intStatus);
			$objStatement->fetch();			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
			
			if ($this->intErrorNo!=0) // Error exists
			{
				
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}
			$objStatement->close(); 
			return $intStatus;
		}
			
		/*=================================================================================
		Function Name 	: UpdateAddsGroup
		Created On    	: 29-Sept-2006 
		Synopsis	  	: Update Adds and Group information against AddsId,GroupsId.
		Input Parameter : AddsId,GroupId and Group status
		Returns		  	: 
		=================================================================================*/
		function UpdateAddsGroup($objAddsGroupBO,$pIntGroupStatus)
		{

			/// Calling Stored Procedure	
			$strQuery = "CALL UPDATE_ADDSGROUP_BY_ADD_ID(?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iii",$objAddsGroupBO->getAdsId()
										   ,$objAddsGroupBO->getGroupId()
										   ,$pIntGroupStatus
											);
			$objStatement->execute();
			$objStatement->bind_result($intStatus);
			$objStatement->fetch();			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
			
			if ($this->intErrorNo!=0) // Error exists
			{
				
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}
			$objStatement->close(); 
			return $intStatus;
		}		
}
?>
