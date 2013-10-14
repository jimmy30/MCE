<?php 

/*=================================================================================
		Class Name    : PlaceCastDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with PlaceCast Table
		Created On    : 26-Jun-2006 
=================================================================================*/


	class PlaceCastDAO
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
		var $strPlaceCastAlertFromEmail;
		var $strPlaceCastAlertEmailSubject;
		var $strPlaceCastAlertEmailBody;
		var $helpEmail;

		//// Declaring SMS alert variables for Cusromter registrarion
		var $strPlaceCastSmsAlertFromEmail;
		var $strPlaceCastSmsAlertEmailSubject;
		var $strPlaceCastSmsAlertEmailBody;
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
			
			/// Connect With Database
			$this->objDB=Database::singleton();

			/// site url
			$this->siteUrl=$objProperties->getProperty('site_url');

			/// GEt Paging variables from property file
			$this->recordLimit = $objProperties->getProperty('paging_record_limit');
			$this->pagesLimit = $objProperties->getProperty('paging_pages_limit');
			
			/// Get customer Alert email variables from property file
			$this->strPlaceCastAlertFromEmail=$objProperties->getProperty('placecast_email_alert_from_email');						
			$this->strPlaceCastAlertEmailSubject=$objProperties->getProperty('placecast_email_alert_email_subject');	
			$this->strPlaceCastAlertEmailBody=$objProperties->getProperty('placecast_email_alert_email_body');				

			$this->helpEmail=$objProperties->getProperty('registration_consumer_help_email');	

			/// Get customer SMS Alert email variables from property file
			$this->strPlaceCastSmsAlertFromEmail=$objProperties->getProperty('placecast_sms_alert_from_email');						
			$this->strPlaceCastSmsAlertEmailSubject=$objProperties->getProperty('placecast_sms_alert_email_subject');	
			$this->strPlaceCastSmsAlertEmailBody=$objProperties->getProperty('placecast_sms_alert_email_body');				
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
		Input Parameter : object PlaceCastBO (All fields)
		Returns		  	: none
=================================================================================*/


		function insert($pPlaceCastBO) 
		{
			/// Calling Stored Procedure
			$strQuery = "CALL PLACECAST_INSERT(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiissssddddddddssi",$pPlaceCastBO->getProducerId()
														   ,$pPlaceCastBO->getPlaceCastCountryId()
														   ,$pPlaceCastBO->getPlaceCastStateId()
														   ,$pPlaceCastBO->getPlaceCastName()
														   ,$pPlaceCastBO->getPlaceCastAddress()
														   ,$pPlaceCastBO->getPlaceCastCity()
														   ,$pPlaceCastBO->getPlaceCastZipCode()
														   ,$pPlaceCastBO->getPlaceCastLat1()
														   ,$pPlaceCastBO->getPlaceCastLong1()														   
														   ,$pPlaceCastBO->getPlaceCastLat2()
														   ,$pPlaceCastBO->getPlaceCastLong2()
														   ,$pPlaceCastBO->getPlaceCastLat3()
														   ,$pPlaceCastBO->getPlaceCastLong3()														   
														   ,$pPlaceCastBO->getPlaceCastLat4()
														   ,$pPlaceCastBO->getPlaceCastLong4()														   
														   ,$pPlaceCastBO->getPlaceCastDescription()														   
														   ,$pPlaceCastBO->getPlaceCastCreateDate()
														   ,$pPlaceCastBO->getPlaceCastIsActive());

			$objStatement->execute();
			$strQuery = "CALL CONSUMER_ALERT_BY_COUNTRY_ACTION(".$pPlaceCastBO->getPlaceCastCountryId().",'1')";
			$objStatement=$this->objDB->executeQuery($strQuery);
			$objUtitlity=new utility();
			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
			{ 
				$strEmail=$row[0];
				$strFirstName=$row[1];
				$strLastName=$row[2];
				$strCountryName=$row[3];

				$placeCastPageUrl=$this->siteUrl."/Placecast/Consumer/viewPlaceCast.php";
				$strPageUrl="<a href='$placeCastPageUrl'>$placeCastPageUrl</a>";
				
				
				$this->strPlaceCastAlertEmailBody=str_replace("[FIRST_NAME]",$strFirstName,$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[LAST_NAME]",$strLastName,$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[PLACECAST_NAME]",$pPlaceCastBO->getPlaceCastName(),$this->strPlaceCastAlertEmailBody);				
				$this->strPlaceCastAlertEmailBody=str_replace("[ALERT_ACTION]","added",$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[COUNTRY]",$strCountryName,$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[PAGE_URL]",$strPageUrl,$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[SITE_URL]",$this->siteUrl,$this->strPlaceCastAlertEmailBody);


				$objUtitlity->sendEmail($this->strPlaceCastAlertFromEmail,$strEmail,$this->strPlaceCastAlertEmailSubject,$this->strPlaceCastAlertEmailBody);
			}	

			$this->objDB=Database::singleton();

			$strQuery = "CALL SMS_ALERT_BY_COUNTRY_ACTION(".$pPlaceCastBO->getPlaceCastCountryId().",'1')";
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
				
				$this->strPlaceCastSmsAlertEmailBody=str_replace("[FIRST_NAME]",$strFirstName,$this->strPlaceCastSmsAlertEmailBody);
				$this->strPlaceCastSmsAlertEmailBody=str_replace("[LAST_NAME]",$strLastName,$this->strPlaceCastSmsAlertEmailBody);
				$this->strPlaceCastSmsAlertEmailBody=str_replace("[PLACECAST_NAME]",$pPlaceCastBO->getPlaceCastName(),$this->strPlaceCastSmsAlertEmailBody);				
				$this->strPlaceCastSmsAlertEmailBody=str_replace("[ALERT_ACTION]","added",$this->strPlaceCastSmsAlertEmailBody);
				$this->strPlaceCastSmsAlertEmailBody=str_replace("[COUNTRY]",$strCountryName,$this->strPlaceCastSmsAlertEmailBody);

 // Mail it
mail($RecipientAddress, $this->strPlaceCastSmsAlertEmailSubject, $this->strPlaceCastSmsAlertEmailBody, $this->SMSAlertheaders);
				//$objUtitlity->sendEmail($this->strPlaceCastSmsAlertFromEmail,$RecipientAddress,$this->strPlaceCastSmsAlertEmailSubject,$this->strPlaceCastSmsAlertEmailBody);
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
		Function Name 	: GetListByProducerId
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Get all list against a particular Producer
		Input Parameter : object PlaceCastBO (string ProducerId, integer IsActive)
		Returns		  	: Three dimenssions Array of Objects (All fields)
=================================================================================*/

	   function GetListByProducerId($pIntProducerId,$pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL PLACECAST_LIST_BY_PRODUCER_ID(".$pIntProducerId.",".$pIntStart.",".$pIntNumRows.",".$pIntIsActive.",".$pIntSortListBy.")";
			$objStatement=$this->objDB->executeQuery($strQuery);
		
			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
				{ 
					$objPlaceCastBO=new PlaceCastBO();
					$objPlaceCastBO->setPlaceCastId($row[0]);
					$objPlaceCastBO->setProducerId($row[1]);
					$objPlaceCastBO->setPlaceCastCountryId($row[2]);
					$objPlaceCastBO->setPlaceCastStateId($row[3]);
					$objPlaceCastBO->setPlaceCastName($row[4]);
					$objPlaceCastBO->setPlaceCastAddress($row[5]);
					$objPlaceCastBO->setPlaceCastCity($row[6]);
					$objPlaceCastBO->setPlaceCastZipCode($row[7]);
					$objPlaceCastBO->setPlaceCastLat1($row[8]);
					$objPlaceCastBO->setPlaceCastLong1($row[9]);
					$objPlaceCastBO->setPlaceCastLat2($row[10]);
					$objPlaceCastBO->setPlaceCastLong2($row[11]);
					$objPlaceCastBO->setPlaceCastLat3($row[12]);
					$objPlaceCastBO->setPlaceCastLong3($row[13]);
					$objPlaceCastBO->setPlaceCastLat4($row[14]);
					$objPlaceCastBO->setPlaceCastLong4($row[15]);
					$objPlaceCastBO->setPlaceCastDescription($row[16]);			
					$objPlaceCastBO->setPlaceCastCreateDate($row[17]);
	
					/// set country name 
					$objCountryBO = new CountryBO();
					$objCountryBO->setCountryName($row["CountryName"]);
	
					/// set state name 				
					$objStateBO = new StateBO();
					$objStateBO->setStateName($row["StateName"]);
			
					/// Seting All three objects in single array
					$objObjectArray[0][0][]=$objPlaceCastBO;
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
		Function Name 	: GetListActive
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Get all list of records by IsActive status
		Input Parameter : integer IsActive
		Returns		  	: Three dimenssions Array of Objects (All fields)
=================================================================================*/

	   function GetListActive($pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy)
	   {
			
			/// Calling Stored Procedure	
	   		$strQuery = "CALL PLACECAST_LIST_ACTIVE(".$pIntStart.",".$pIntNumRows.",".$pIntIsActive.",".$pIntSortListBy.")";
			
			$objStatement=$this->objDB->executeQuery($strQuery);
			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
				{ 
				$objPlaceCastBO=new PlaceCastBO();
				$objPlaceCastBO->setPlaceCastId($row[0]);
				$objPlaceCastBO->setProducerId($row[1]);
				$objPlaceCastBO->setPlaceCastCountryId($row[2]);
				$objPlaceCastBO->setPlaceCastStateId($row[3]);
				$objPlaceCastBO->setPlaceCastName($row[4]);
				$objPlaceCastBO->setPlaceCastAddress($row[5]);
				$objPlaceCastBO->setPlaceCastCity($row[6]);
				$objPlaceCastBO->setPlaceCastZipCode($row[7]);
				$objPlaceCastBO->setPlaceCastLat1($row[8]);
				$objPlaceCastBO->setPlaceCastLong1($row[9]);
				$objPlaceCastBO->setPlaceCastLat2($row[10]);
				$objPlaceCastBO->setPlaceCastLong2($row[11]);
				$objPlaceCastBO->setPlaceCastLat3($row[12]);
				$objPlaceCastBO->setPlaceCastLong3($row[13]);
				$objPlaceCastBO->setPlaceCastLat4($row[14]);
				$objPlaceCastBO->setPlaceCastLong4($row[15]);
				$objPlaceCastBO->setPlaceCastDescription($row[16]);			
				$objPlaceCastBO->setPlaceCastCreateDate($row[17]);
				$objPlaceCastBO->setPlaceCastIsActive($row[18]);				

				/// set country name 
				$objCountryBO = new CountryBO();
				$objCountryBO->setCountryName($row["CountryName"]);

				/// set state name 				
				$objStateBO = new StateBO();
				$objStateBO->setStateName($row["StateName"]);
		
				/// Seting All three objects in single array
				$objObjectArray[0][0][]=$objPlaceCastBO;
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
		Function Name 	: AdvanceSearch
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Get all list of records by IsActive status
		Input Parameter : integer IsActive
		Returns		  	: Three dimenssions Array of Objects (All fields)
=================================================================================*/

	   function AdvanceSearch($pIntStart,$pIntNumRows,$query,$arrQueryChecks,$pIntIsActive,$pIntSortListBy)
	   {
			$checkCountry=$arrQueryChecks[0];
			$checkState=$arrQueryChecks[1];
			$checkCity=$arrQueryChecks[2];
			$checkZip=$arrQueryChecks[3];

			/// Calling Stored Procedure	
	   		$strQuery = "CALL PLACECAST_CONSUMER_SEARCH(".$pIntStart.",".$pIntNumRows.",'$query',".$checkCountry.",".$checkState.",".$checkCity.",".$checkZip.",".$pIntIsActive.",".$pIntSortListBy.")";
			
			$objStatement=$this->objDB->executeQuery($strQuery);

			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
				{ 
				$objPlaceCastBO=new PlaceCastBO();
				$objPlaceCastBO->setPlaceCastId($row[0]);
				$objPlaceCastBO->setProducerId($row[1]);
				$objPlaceCastBO->setPlaceCastCountryId($row[2]);
				$objPlaceCastBO->setPlaceCastStateId($row[3]);
				$objPlaceCastBO->setPlaceCastName($row[4]);
				$objPlaceCastBO->setPlaceCastAddress($row[5]);
				$objPlaceCastBO->setPlaceCastCity($row[6]);
				$objPlaceCastBO->setPlaceCastZipCode($row[7]);
				$objPlaceCastBO->setPlaceCastLat1($row[8]);
				$objPlaceCastBO->setPlaceCastLong1($row[9]);
				$objPlaceCastBO->setPlaceCastLat2($row[10]);
				$objPlaceCastBO->setPlaceCastLong2($row[11]);
				$objPlaceCastBO->setPlaceCastLat3($row[12]);
				$objPlaceCastBO->setPlaceCastLong3($row[13]);
				$objPlaceCastBO->setPlaceCastLat4($row[14]);
				$objPlaceCastBO->setPlaceCastLong4($row[15]);
				$objPlaceCastBO->setPlaceCastDescription($row[16]);			
				$objPlaceCastBO->setPlaceCastCreateDate($row[17]);
				$objPlaceCastBO->setPlaceCastIsActive($row[18]);				

				/// set country name 
				$objCountryBO = new CountryBO();
				$objCountryBO->setCountryName($row["CountryName"]);

				/// set state name 				
				$objStateBO = new StateBO();
				$objStateBO->setStateName($row["StateName"]);
		
				/// Seting All three objects in single array
				$objObjectArray[0][0][]=$objPlaceCastBO;
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
		Input Parameter : object PlaceCastBO (integer  ID, integer IsActive)
		Returns		  	: Array of objects (All fields)
=================================================================================*/

	   /// GET PRODUCER RECORD BY EMAIL
	   function selectById($objPlaceCastBO)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL PLACECAST_GET_BY_ID(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ii",$objPlaceCastBO->getPlaceCastId(),$objPlaceCastBO->getPlaceCastIsActive());
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result(
										$pIntPlaceCastId, 
										$pIntProducerId, 
										$pIntCountryId, 
										$pIntStateId, 
										$pChrName, 
										$pChrAddress, 
										$pChrCity, 
										$pChrZipCode, 
										$pDecLat1, 
										$pDecLong1, 
										$pDecLat2, 
										$pDecLong2, 
										$pDecLat3, 
										$pDecLong3, 
										$pDecLat4, 
										$pDecLong4, 
										$pChrDescription,
										$pCreateDate,
										$pIntIsActive,
										$pChrCountryName,
										$pChrStateName
										); 

			$objStatement->fetch();
			
			/// Set results in object	
			$objPlaceCastBO = new PlaceCastBO();
			$objPlaceCastBO->setProducerId($pIntProducerId);
			$objPlaceCastBO->setPlaceCastCountryId($pIntCountryId);
			$objPlaceCastBO->setPlaceCastStateId($pIntStateId);
			$objPlaceCastBO->setPlaceCastName($pChrName);
			$objPlaceCastBO->setPlaceCastAddress($pChrAddress);
			$objPlaceCastBO->setPlaceCastCity($pChrCity);
			$objPlaceCastBO->setPlaceCastZipCode($pChrZipCode);
			$objPlaceCastBO->setPlaceCastLat1($pDecLat1);
			$objPlaceCastBO->setPlaceCastLong1($pDecLong1);
			$objPlaceCastBO->setPlaceCastLat2($pDecLat2);
			$objPlaceCastBO->setPlaceCastLong2($pDecLong2);
			$objPlaceCastBO->setPlaceCastLat3($pDecLat3);
			$objPlaceCastBO->setPlaceCastLong3($pDecLong3);
			$objPlaceCastBO->setPlaceCastLat4($pDecLat4);
			$objPlaceCastBO->setPlaceCastLong4($pDecLong4);
			$objPlaceCastBO->setPlaceCastDescription($pChrDescription);
			
			$objCountryBO = new CountryBO();
			$objCountryBO->setCountryName($pChrCountryName);
			
			$objStateBO = new StateBO();
			$objStateBO->setStateName($pChrStateName);
			
 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			/// set objects in a single array
			$ObjArrayBO[0]=$objPlaceCastBO;
			$ObjArrayBO[1]=$objCountryBO;
			$ObjArrayBO[2]=$objStateBO;						
			
			return $ObjArrayBO;
	   }


/*=================================================================================
		Function Name 	: update
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Update particular record against ID
		Input Parameter : object PlaceCastBO (All fields)
		Returns		  	: none
=================================================================================*/

		function update($pPlaceCastBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL PLACECAST_UPDATE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiissssdddddddds",$pPlaceCastBO->getPlaceCastId()
													   ,$pPlaceCastBO->getPlaceCastCountryId()
													   ,$pPlaceCastBO->getPlaceCastStateId()
													   ,$pPlaceCastBO->getPlaceCastName()
													   ,$pPlaceCastBO->getPlaceCastAddress()
													   ,$pPlaceCastBO->getPlaceCastCity()
													   ,$pPlaceCastBO->getPlaceCastZipCode()
													   ,$pPlaceCastBO->getPlaceCastLat1()
													   ,$pPlaceCastBO->getPlaceCastLong1()														   
													   ,$pPlaceCastBO->getPlaceCastLat2()
													   ,$pPlaceCastBO->getPlaceCastLong2()
													   ,$pPlaceCastBO->getPlaceCastLat3()
													   ,$pPlaceCastBO->getPlaceCastLong3()														   
													   ,$pPlaceCastBO->getPlaceCastLat4()
													   ,$pPlaceCastBO->getPlaceCastLong4()														   
													   ,$pPlaceCastBO->getPlaceCastDescription()														   
														);
			$objStatement->execute();
			
			
			$strQuery = "CALL CONSUMER_ALERT_BY_COUNTRY_ACTION(".$pPlaceCastBO->getPlaceCastCountryId().",'2')";
			$objStatement=$this->objDB->executeQuery($strQuery);
			
			$objUtitlity=new utility();
			/// set results in a object
			while ($row=$objStatement->fetch_array()) 
			{ 
						
				$strEmail=$row[0];
				$strFirstName=$row[1];
				$strLastName=$row[2];
				$strCountryName=$row[3];

				$placeCastPageUrl=$this->siteUrl."/Placecast/Consumer/viewPlaceCast.php";
				$strPageUrl="<a href='$placeCastPageUrl'>$placeCastPageUrl</a>";
				
				
				$this->strPlaceCastAlertEmailBody=str_replace("[FIRST_NAME]",$strFirstName,$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[LAST_NAME]",$strLastName,$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[PLACECAST_NAME]",$pPlaceCastBO->getPlaceCastName(),$this->strPlaceCastAlertEmailBody);				
				$this->strPlaceCastAlertEmailBody=str_replace("[ALERT_ACTION]","modified",$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[COUNTRY]",$strCountryName,$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[PAGE_URL]",$strPageUrl,$this->strPlaceCastAlertEmailBody);
				$this->strPlaceCastAlertEmailBody=str_replace("[SITE_URL]",$this->siteUrl,$this->strPlaceCastAlertEmailBody);


				$objUtitlity->sendEmail($this->strPlaceCastAlertFromEmail,$strEmail,$this->strPlaceCastAlertEmailSubject,$this->strPlaceCastAlertEmailBody);
			}	
			
			$this->objDB=Database::singleton();

			$strQuery = "CALL SMS_ALERT_BY_COUNTRY_ACTION(".$pPlaceCastBO->getPlaceCastCountryId().",'2')";
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

				$this->strPlaceCastSmsAlertEmailBody=str_replace("[FIRST_NAME]",$strFirstName,$this->strPlaceCastSmsAlertEmailBody);
				$this->strPlaceCastSmsAlertEmailBody=str_replace("[LAST_NAME]",$strLastName,$this->strPlaceCastSmsAlertEmailBody);
				$this->strPlaceCastSmsAlertEmailBody=str_replace("[PLACECAST_NAME]",$pPlaceCastBO->getPlaceCastName(),$this->strPlaceCastSmsAlertEmailBody);				
				$this->strPlaceCastSmsAlertEmailBody=str_replace("[ALERT_ACTION]","modified",$this->strPlaceCastSmsAlertEmailBody);
				$this->strPlaceCastSmsAlertEmailBody=str_replace("[COUNTRY]",$strCountryName,$this->strPlaceCastSmsAlertEmailBody);

 // Mail it
mail($RecipientAddress, $this->strPlaceCastSmsAlertEmailSubject, $this->strPlaceCastSmsAlertEmailBody, $this->SMSAlertheaders);
//				$objUtitlity->sendEmail($this->strPlaceCastSmsAlertFromEmail,$RecipientAddress,$this->strPlaceCastSmsAlertEmailSubject,$this->strPlaceCastSmsAlertEmailBody);
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
		Function Name 	: PlaceCastDeleteById
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Delete particular record against ID
		Input Parameter : integer ID
		Returns		  	: none
=================================================================================*/
		function PlaceCastDeleteById($pPlaceCastId)
		{
			$strQuery = "CALL PLACECAST_DELETE_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pPlaceCastId);
			$objStatement->execute();

			$this->intErrorNo=$this->objDB->geterrornumber();
			if ($this->intErrorNo!=0) // Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
			

			/// Get error no from stored procedure

			$objStatement->close(); 
		
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
			$checkCountry=$arrQueryChecks[0];
			$checkState=$arrQueryChecks[1];
			$checkCity=$arrQueryChecks[2];
			$checkZip=$arrQueryChecks[3];

			/// Calling Stored Procedure	
	   		$strQuery = "CALL PLACECAST_SEARCH_RECORD_COUNT('$query',".$checkCountry.",".$checkState.",".$checkCity.",".$checkZip.",".$pIntIsActive.")";
			
			$objStatement=$this->objDB->executeQuery($strQuery);

			$row=$objStatement->fetch_array();
			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
			
			if ($this->intErrorNo!=0) // Error exists
			{
				
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}

			//$objStatement->close();
			return $row[0];
		
		}


/*=================================================================================
		Function Name 	: PlaceCastRecordCount
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/
		function PlaceCastRecordCount($pIntIsActive)
		{
			$strQuery = "CALL PLACECAST_RECORD_COUNT(?)";
			
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

			//$objStatement->close();
			return $numRows;
		
		}

/*=================================================================================
		Function Name 	: PlaceCastRecordCountByCutomer
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records against a particular Producer
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/
		function PlaceCastRecordCountByProducer($pIntProducerId,$pIntIsActive)
		{
			$strQuery = "CALL PLACECAST_RECORD_COUNT_BY_PRODUCER(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ii",$pIntProducerId,$pIntIsActive);
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


		function ToggleIsActive($pIntPlaceCastId,$pIntIsActive)
		{
			$strQuery = "CALL PLACECAST_TOGGLE_IS_ACTIVE(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ii",$pIntPlaceCastId,$pIntIsActive);
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
//////////////////////////////////////////////////////////////////
/******************* temp function ******************************/
//////////////////////////////////////////////////////////////////
		function getWaypointIdByPlaceCast($pIntPlaceCastId)
		{
			$result=$this->objDB->executeQuery("select * from waypoint where PlaceCastId = '".$pIntPlaceCastId."'");		
			return $result;
		}
	}	
?>