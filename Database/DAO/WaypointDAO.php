<?php 

/*=================================================================================
		Class Name    : WaypointDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with Waypoint Table
		Created On    : 26-Jun-2006 
=================================================================================*/

	class WaypointDAO
	{
		//// Declaring DB connection and objects and variables
		var $objDB;

		/// site url
		var $siteUrl;

		/// Declaring paging variables
		var $recordLimit;
		var $pagesLimit;

		/// Declaring Error handling variables
		var $strErrorMessage;
		var $intErrorNo;
		//// Declaring Email variables for Cusromter registrarion
		var $strWaypointAlertFromEmail;
		var $strWaypointAlertEmailSubject;
		var $strWaypointAlertEmailBody;
		var $helpEmail;
		
		//// Declaring SMS alert variables for Cusromter registrarion
		var $strWaypointSmsAlertFromEmail;
		var $strWaypointSmsAlertEmailSubject;
		var $strWaypointSmsAlertEmailBody;
		var $SMSAlertheaders;
		
		
/*=================================================================================
		Function Name : Custoructor
		Synopsis	  : Loading and get values from property file 
						and establishing DB connection 
		Created On    : 26-Jun-2006 
=================================================================================*/

		function __construct()
		{
			/// Loading property file
			$objProperties=new Properties();
			$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
			$this->objDB=Database::singleton();
		
			/// site url
			$this->siteUrl=$objProperties->getProperty('site_url');

			/// GEt Paging variables from property file
			$this->recordLimit = $objProperties->getProperty('paging_record_limit');
			$this->pagesLimit = $objProperties->getProperty('paging_pages_limit');
			
			/// Get customer registration email variables from property file
			$this->strWaypointAlertFromEmail=$objProperties->getProperty('waypoint_email_alert_from_email');						
			$this->strWaypointAlertEmailSubject=$objProperties->getProperty('waypoint_email_alert_email_subject');	
			$this->strWaypointAlertEmailBody=$objProperties->getProperty('waypoint_email_alert_email_body');				
			$this->helpEmail=$objProperties->getProperty('registration_consumer_help_email');	
			

			/// Get customer SMS Alert email variables from property file
			$this->strWaypointSmsAlertFromEmail=$objProperties->getProperty('waypoint_sms_alert_from_email');						
			$this->strWaypointSmsAlertEmailSubject=$objProperties->getProperty('waypoint_sms_alert_email_subject');	
			$this->strWaypointSmsAlertEmailBody=$objProperties->getProperty('waypoint_sms_alert_email_body');				
			$this->SMSAlertheaders = 'From: info@mce.com' . "\r\n" .'Reply-To: info@mce.com' . "\r\n";

			/// Exception thrown incase of error connecting with DB
			if (mysqli_connect_errno())
			{ 
   				throw new DatabaseConnectivityException();
			}	 
		}
		
/*=================================================================================
		Function Name 	: insert
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Insert record 
		Input Parameter : object WaypointBO (All fields)
		Returns		  	: none
=================================================================================*/


		function insert($pWaypointBO,$pIntPlaceCastCountryId) 
		{
			/// Calling Stored Procedure
			$strQuery = "CALL WAYPOINT_INSERT(?,?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("isssddssid",$pWaypointBO->getPlaceCastId()
														   ,$pWaypointBO->getWaypointName()
														   ,$pWaypointBO->getWaypointAddress()
														   ,$pWaypointBO->getWaypointCity()
														   ,$pWaypointBO->getWaypointLat1()
														   ,$pWaypointBO->getWaypointLong1()														
														   ,$pWaypointBO->getWaypointDescription()													
														   ,$pWaypointBO->getWaypointCreateDate()
														   ,$pWaypointBO->getWaypointIsActive()
														   ,$pWaypointBO->getWaypointRadius());

			$objStatement->execute();
			$this->SendEmailAlert($pIntPlaceCastCountryId,$pWaypointBO->getPlaceCastId(),$pWaypointBO->getWaypointName());
			
			$this->objDB=Database::singleton();
						
			$this->SendSmsAlert($pIntPlaceCastCountryId,$pWaypointBO->getPlaceCastId(),$pWaypointBO->getWaypointName());
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
		Function Name 	: sendEmailAlert
		Created On    	: 14-Sept-2006 
		Synopsis	  	: 
		Input Parameter : 
		Returns		  	: 
=================================================================================*/
function SendEmailAlert($pIntCountryId,$pPlaceCastId,$pWaypointName)
{
			$strQuery = "CALL CONSUMER_ALERT_BY_COUNTRY_ACTION(".$pIntCountryId.",'1')";
			$objStatement=$this->objDB->executeQuery($strQuery);
			$objUtitlity=new utility();
			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
			{ 
				$strEmail=$row[0];
				$strFirstName=$row[1];
				$strLastName=$row[2];
				$strCountryName=$row[3];

				$waypointPageUrl=$this->siteUrl."/Waypoint/Consumer/viewWaypoint.php?id=$pPlaceCastId";
				$strPageUrl="<a href='$waypointPageUrl'>$waypointPageUrl</a>";
				
				
				$this->strWaypointAlertEmailBody=str_replace("[FIRST_NAME]",$strFirstName,$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[LAST_NAME]",$strLastName,$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[WAYPOINT_NAME]",$pWaypointName,$this->strWaypointAlertEmailBody);				
				$this->strWaypointAlertEmailBody=str_replace("[ALERT_ACTION]","modified",$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[COUNTRY]",$strCountryName,$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[PAGE_URL]",$strPageUrl,$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[SITE_URL]",$this->siteUrl,$this->strWaypointAlertEmailBody);


				$objUtitlity->sendEmail($this->strWaypointAlertFromEmail,$strEmail,$this->strWaypointAlertEmailSubject,$this->strWaypointAlertEmailBody);
			}	

}
	   
/*=================================================================================
		Function Name 	: SendSmsAlert
		Created On    	: 14-Sept-2006 
		Synopsis	  	: 
		Input Parameter : 
		Returns		  	: 
=================================================================================*/
function SendSmsAlert($pIntCountryId,$pPlaceCastId,$pWaypointName)
{
			$strQuery = "CALL SMS_ALERT_BY_COUNTRY_ACTION(".$pIntCountryId.",'1')";
			$objStatement=$this->objDB->executeQuery($strQuery);
			$objUtitlity=new utility();
			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
			{ 
				$strEmail=$row[0];
				$strFirstName=$row[1];
				$strLastName=$row[2];
				$strCountryName=$row[3];
				$strMobile=$row[4];
				$strCellularProvider=$row[5];
				
				$RecipientAddress=$strMobile."@".$strCellularProvider;

			
				$this->strWaypointSmsAlertEmailBody=str_replace("[FIRST_NAME]",$strFirstName,$this->strWaypointSmsAlertEmailBody);
				$this->strWaypointSmsAlertEmailBody=str_replace("[LAST_NAME]",$strLastName,$this->strWaypointSmsAlertEmailBody);
				$this->strWaypointSmsAlertEmailBody=str_replace("[WAYPOINT_NAME]",$pWaypointName,$this->strWaypointSmsAlertEmailBody);				
				$this->strWaypointSmsAlertEmailBody=str_replace("[ALERT_ACTION]","added",$this->strWaypointSmsAlertEmailBody);
				$this->strWaypointSmsAlertEmailBody=str_replace("[COUNTRY]",$strCountryName,$this->strWaypointSmsAlertEmailBody);

 // Mail it
mail($RecipientAddress, $this->strWaypointSmsAlertEmailSubject, $this->strWaypointSmsAlertEmailBody, $this->SMSAlertheaders);

				//$objUtitlity->sendEmail($this->strWaypointSmsAlertFromEmail,$RecipientAddress,$this->strWaypointSmsAlertEmailSubject,$this->strWaypointSmsAlertEmailBody);
			}	

}
	   


/*=================================================================================
		Function Name 	: GetListByPlaceCastId
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Get all list against a particular placeCast Id
		Input Parameter : object WaypointBO (string PlaceCastId, integer IsActive)
		Returns		  	: Three dimenssions Array of Objects (All fields)
=================================================================================*/

	   function GetListByPlaceCastId($pIntPlaceCastId,$pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL WAYPOINT_LIST_BY_PLACECAST_ID(".$pIntPlaceCastId.",".$pIntStart.",".$pIntNumRows.",".$pIntIsActive.",".$pIntSortListBy.")";
			$objStatement=$this->objDB->executeQuery($strQuery);
		
			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
				{ 
				$objWaypointBO=new WaypointBO();
				$objWaypointBO->setWaypointId($row[0]);
				$objWaypointBO->setPlaceCastId($row[1]);
				$objWaypointBO->setWaypointName($row[2]);
				$objWaypointBO->setWaypointAddress($row[3]);
				$objWaypointBO->setWaypointCity($row[4]);
				$objWaypointBO->setWaypointLat1($row[5]);
				$objWaypointBO->setWaypointLong1($row[6]);
				$objWaypointBO->setWaypointDescription($row[7]);			
				$objWaypointBO->setWaypointCreateDate($row[8]);
				$objWaypointBO->setWaypointIsActive($row[9]);				

				/// Seting All three objects in single array
				$objObjectArray[]=$objWaypointBO;

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
		Function Name 	: GetListActive
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Get all list of records by IsActive status
		Input Parameter : integer IsActive
		Returns		  	: Three dimenssions Array of Objects (All fields)
=================================================================================*/

	   function GetListActive($pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL WAYPOINT_LIST_ACTIVE(".$pIntStart.",".$pIntNumRows.",".$pIntIsActive.",".$pIntSortListBy.")";
			$objStatement=$this->objDB->executeQuery($strQuery);

			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
				{ 
				$objWaypointBO=new WaypointBO();
				$objWaypointBO->setWaypointId($row[0]);
				$objWaypointBO->setPlaceCastId($row[1]);
				$objWaypointBO->setWaypointCountryId($row[2]);
				$objWaypointBO->setWaypointStateId($row[3]);
				$objWaypointBO->setWaypointName($row[4]);
				$objWaypointBO->setWaypointAddress($row[5]);
				$objWaypointBO->setWaypointCity($row[6]);
				$objWaypointBO->setWaypointZipCode($row[7]);
				$objWaypointBO->setWaypointLat1($row[8]);
				$objWaypointBO->setWaypointLong1($row[9]);
				$objWaypointBO->setWaypointDescription($row[16]);			
				$objWaypointBO->setWaypointCreateDate($row[17]);

				/// set country name 
				$objCountryBO = new CountryBO();
				$objCountryBO->setCountryName($row["CountryName"]);

				/// set state name 				
				$objStateBO = new StateBO();
				$objStateBO->setStateName($row["StateName"]);
		
				/// Seting All three objects in single array
				$objObjectArray[0][0][]=$objWaypointBO;
				$objObjectArray[0][1][]=$objCountryBO;
				$objObjectArray[1][1][]=$objStateBO;

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
		Function Name 	: selectById
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Get a record for particular ID
		Input Parameter : object WaypointBO (integer  ID, integer IsActive)
		Returns		  	: Array of objects (All fields)
=================================================================================*/

	   /// GET CUSTOMER RECORD BY EMAIL
	   function selectById($objWaypointBO)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL WAYPOINT_GET_BY_ID(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ii",$objWaypointBO->getWaypointId(),$objWaypointBO->getWaypointIsActive());
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result(
										$pIntWaypointId, 
										$pIntPlaceCastId, 
										$pChrName, 
										$pChrAddress, 
										$pChrCity,
										$pDecLat1, 
										$pDecLong1, 
										$pChrDescription,
										$pCreateDate,
										$pIntIsActive,
										$pDecRadius
										); 

			$objStatement->fetch();
			
			/// Set results in object	
			$objWaypointBO = new WaypointBO();
			$objWaypointBO->setPlaceCastId($pIntPlaceCastId);
			$objWaypointBO->setWaypointName($pChrName);
			$objWaypointBO->setWaypointAddress($pChrAddress);
			$objWaypointBO->setWaypointCity($pChrCity);
			$objWaypointBO->setWaypointLat1($pDecLat1);
			$objWaypointBO->setWaypointLong1($pDecLong1);
			$objWaypointBO->setWaypointDescription($pChrDescription);
			$objWaypointBO->setWaypointRadius($pDecRadius);
			
 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			
			return $objWaypointBO;
	   }


/*=================================================================================
		Function Name 	: update
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Update particular record against ID
		Input Parameter : object WaypointBO (All fields)
		Returns		  	: none
=================================================================================*/

		function update($pWaypointBO,$pPlaceCastId,$pPlaceCastCountryId)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL WAYPOINT_UPDATE(?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("isssddsd",$pWaypointBO->getWaypointId()
													   ,$pWaypointBO->getWaypointName()
													   ,$pWaypointBO->getWaypointAddress()
													   ,$pWaypointBO->getWaypointCity()
													   ,$pWaypointBO->getWaypointLat1()
													   ,$pWaypointBO->getWaypointLong1()
													   ,$pWaypointBO->getWaypointDescription()
														,$pWaypointBO->getWaypointRadius());
			$objStatement->execute();
			
			$strQuery = "CALL CONSUMER_ALERT_BY_COUNTRY_ACTION(".$pPlaceCastCountryId.",'2')";
			$objStatement=$this->objDB->executeQuery($strQuery);
			$objUtitlity=new utility();
			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
			{ 
				$strEmail=$row[0];
				$strFirstName=$row[1];
				$strLastName=$row[2];
				$strCountryName=$row[3];

				$waypointPageUrl=$this->siteUrl."/Waypoint/Consumer/viewWaypoint.php?id=$pPlaceCastId";
				$strPageUrl="<a href='$waypointPageUrl'>$waypointPageUrl</a>";
				
				
				$this->strWaypointAlertEmailBody=str_replace("[FIRST_NAME]",$strFirstName,$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[LAST_NAME]",$strLastName,$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[WAYPOINT_NAME]",$pWaypointBO->getWaypointName(),$this->strWaypointAlertEmailBody);				
				$this->strWaypointAlertEmailBody=str_replace("[ALERT_ACTION]","modified",$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[COUNTRY]",$strCountryName,$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[PAGE_URL]",$strPageUrl,$this->strWaypointAlertEmailBody);
				$this->strWaypointAlertEmailBody=str_replace("[SITE_URL]",$this->siteUrl,$this->strWaypointAlertEmailBody);


				$objUtitlity->sendEmail($this->strWaypointAlertFromEmail,$strEmail,$this->strWaypointAlertEmailSubject,$this->strWaypointAlertEmailBody);
			}	

			$this->objDB=Database::singleton();
			
			$strQuery = "CALL SMS_ALERT_BY_COUNTRY_ACTION(".$pPlaceCastCountryId.",'2')";
			$objStatement=$this->objDB->executeQuery($strQuery);
			$objUtitlity=new utility();
			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
			{ 
				$strEmail=$row[0];
				$strFirstName=$row[1];
				$strLastName=$row[2];
				$strCountryName=$row[3];
				$strMobile=$row[4];
				$strCellularProvider=$row[5];
				
				$RecipientAddress=$strMobile."@".$strCellularProvider;
				
				$this->strWaypointSmsAlertEmailBody=str_replace("[FIRST_NAME]",$strFirstName,$this->strWaypointSmsAlertEmailBody);
				$this->strWaypointSmsAlertEmailBody=str_replace("[LAST_NAME]",$strLastName,$this->strWaypointSmsAlertEmailBody);
				$this->strWaypointSmsAlertEmailBody=str_replace("[WAYPOINT_NAME]",$pWaypointName,$this->strWaypointSmsAlertEmailBody);				
				$this->strWaypointSmsAlertEmailBody=str_replace("[ALERT_ACTION]","modified",$this->strWaypointSmsAlertEmailBody);
				$this->strWaypointSmsAlertEmailBody=str_replace("[COUNTRY]",$strCountryName,$this->strWaypointSmsAlertEmailBody);

 // Mail it
mail($RecipientAddress, $this->strWaypointSmsAlertEmailSubject, $this->strWaypointSmsAlertEmailBody, $this->SMSAlertheaders);
//$objUtitlity->sendEmail($this->strWaypointSmsAlertFromEmail,$RecipientAddress,$this->strWaypointSmsAlertEmailSubject,$this->strWaypointSmsAlertEmailBody);
			}	

			
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
		Function Name 	: WaypointDeleteById
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Delete particular record against ID
		Input Parameter : integer ID
		Returns		  	: none
=================================================================================*/
		function WaypointDeleteById($pWaypointId)
		{
			$strQuery = "CALL WAYPOINT_DELETE_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pWaypointId);
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
		Function Name 	: WaypointRecordCount
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/
		function WaypointRecordCount($pIntIsActive)
		{
			$strQuery = "CALL WAYPOINT_RECORD_COUNT(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pIntIsActive);
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
		Function Name 	: WaypointRecordCountByPlaceCast
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records against a particular PlaceCast
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/
		function WaypointRecordCountByPlaceCast($pIntPlaceCastId,$pIntIsActive)
		{
			$strQuery = "CALL WAYPOINT_RECORD_COUNT_BY_PLACECAST(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ii",$pIntPlaceCastId,$pIntIsActive);
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
		Function Name 	: getPagingLimit
		Created On    	: 01-Aug-2006 
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
		Created On    	: 01-Aug-2006 
		Synopsis	  	: get pages limit value form property file
		Input Parameter : none
		Returns		  	: integer pages limt
=================================================================================*/
		function getPagesLimit()
		{
			return $this->pagesLimit;
		}

		function ToggleIsActive($pIntWaypointId,$pIntIsActive)
		{
			$strQuery = "CALL WAYPOINT_TOGGLE_IS_ACTIVE(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ii",$pIntWaypointId,$pIntIsActive);
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