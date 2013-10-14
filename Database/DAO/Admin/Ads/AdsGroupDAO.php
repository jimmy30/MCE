<?php
/*=================================================================================
		Class Name    : AdsGroupDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with AdsGroup Table
		Created On    : 21-Sept-2006 
=================================================================================*/
class AdsGroupDAO
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
			/// Loading property file
			$objProperties=new Properties();
			$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
			
			/// Connect With Database
			$this->objDB=Database::singleton();
			
			/// Exception thrown incase of error connecting with DB
			if (mysqli_connect_errno())
			{ 
   				throw new DatabaseConnectivityException();
			}	 
		}
			/*=================================================================================
				Function Name 	: InsertAdsGroup
				Created On    	: 21-Sept-2006 
				Synopsis	  	: Insert record 
				Input Parameter : object AdsGroupBO (All fields)
				Returns		  	: Status
		=================================================================================*/
		function InsertAdsGroup($pObjAdsGroupBO)
		{

			/// Calling Stored Procedure
			$strQuery = "CALL ADDS_GROUP_INSERT(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ii",$pObjAdsGroupBO->getAdsId()
										   ,$pObjAdsGroupBO->getGroupId());
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

		}
}		

?>