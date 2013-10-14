<?php 

/*=================================================================================
		Class Name    : ConsumerDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with Consumer Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class ConsumerDAO
	{
		
		//// Declaring DB connection and objects and variables
		var $objDB;
				
		/// Declaring Error handling variables
		var $strErrorMessage;
		var $strEmailErrorMessage;
		var $intErrorNo;
		
		//// Declaring common variables
		var $siteUrl;
		var $helpEmail;
		
		//// Declaring Email variables for Cusromter registrarion
		var $strRegistrationFromEmail;
		var $strRegistrationEmailSubject;
		var $strRegistrationEmailBody;

/*=================================================================================
		Function Name : Custoructor
		Synopsis	  : Loading and get values from property file 
						and establishing DB connection 
		Created On    : 01-Jun-2006 
=================================================================================*/

		function __construct()
		{
			/// Loading property file
			$objProperties=new Properties();
			$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
			
			/// Connect With Database
			$this->objDB=Database::singleton();
			
			/// Get common variables from property file
			$this->siteUrl=$objProperties->getProperty('site_url');
			$this->helpEmail=$objProperties->getProperty('registration_consumer_help_email');			
			
			/// Get customer registration email variables from property file
			$this->strRegistrationFromEmail=$objProperties->getProperty('registration_consumer_from_email');						
			$this->strRegistrationEmailSubject=$objProperties->getProperty('registraion_consumer_email_subject');	
			$this->strRegistrationEmailBody=$objProperties->getProperty('registraion_consumer_email_body');				

			/// Exception thrown incase of error connecting with DB
			if (mysqli_connect_errno())
			{ 
   				throw new DatabaseConnectivityException();
			}	 
		}
		
/*=================================================================================
		Function Name 	: insert
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Insert Consumer record and send email to customer registration
		Input Parameter : Object ConsumerBO (All customer fields)
		Returns		  	: none
=================================================================================*/

		function insert($pConsumerBO,$pEmailCheck) 
		{
			$this->objDB->startTransaction(FALSE);

			/// Calling Stored Procedure
			$strQuery = "CALL CONSUMER_INSERT(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiiisssssssssssisisi",$pConsumerBO->getConsumerCountryId()
														   ,$pConsumerBO->getConsumerStateId()
														   ,$pConsumerBO->getConsumerAccountType()
														   ,$pConsumerBO->getConsumerSecretQuestion()
														   ,$pConsumerBO->getConsumerEmail()
														   ,$pConsumerBO->getConsumerPassword()
														   ,$pConsumerBO->getConsumerFristName()
														   ,$pConsumerBO->getConsumerLastName()
														   ,$pConsumerBO->getConsumerAddress()
														   ,$pConsumerBO->getConsumerCity()
														   ,$pConsumerBO->getConsumerZipCode()
														   ,$pConsumerBO->getConsumerTelephone1()
														   ,$pConsumerBO->getConsumerDateOfBirth()
														   ,$pConsumerBO->getConsumerAnswer()
														   ,$pConsumerBO->getConsumerActivationCode()
														   ,$pConsumerBO->getConsumerIsVerified()
														   ,$pConsumerBO->getConsumerCreateDate()
														   ,$pConsumerBO->getConsumerIsActive()
														   ,$pConsumerBO->getMobileNumber()
														   ,$pConsumerBO->getCellularId());
			$objStatement->execute();
	
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
			
			if($this->intErrorNo==0) /// Error does not exists
			{
				/// Set activation page URL
				$pageRegistrationActivation=$this->siteUrl.clsConstants::PAGE_CONSUMER_REGISTRATION_ACTIVATION;

				/// Generating Email body for customer registration
				$this->strRegistrationEmailBody=str_replace("[ACTIVATION_PAGE]",$pageRegistrationActivation,$this->strRegistrationEmailBody);
				$this->strRegistrationEmailBody=str_replace("[ACTIVATION_CODE]",$pConsumerBO->getConsumerActivationCode(),$this->strRegistrationEmailBody);
				$this->strRegistrationEmailBody=str_replace("[EMAIL]",$pConsumerBO->getConsumerEmail(),$this->strRegistrationEmailBody);				
				$this->strRegistrationEmailBody=str_replace("[PASSWORD]",$pConsumerBO->getConsumerPassword(),$this->strRegistrationEmailBody);								
				$this->strRegistrationEmailBody=str_replace("[FIRST_NAME]",$pConsumerBO->getConsumerFristName(),$this->strRegistrationEmailBody);
				$this->strRegistrationEmailBody=str_replace("[LAST_NAME]",$pConsumerBO->getConsumerLastName(),$this->strRegistrationEmailBody);				
				$this->strRegistrationEmailBody=str_replace("[SITE_URL]",$this->siteUrl,$this->strRegistrationEmailBody);				
				$this->strRegistrationEmailBody=str_replace("[CONSUMER_REGISTRATION_HELP_EMAIL]",$this->helpEmail,$this->strRegistrationEmailBody);								

			if($pEmailCheck!=1)
			{
				/// Sending Registration Email to Consumer
				$objUtitlity=new utility();
				$objUtitlity->sendEmail($this->strRegistrationFromEmail,$pConsumerBO->getConsumerEmail(),$this->strRegistrationEmailSubject,$this->strRegistrationEmailBody);
			}
			
			}	
			$this->objDB->commitTransaction();
			
			
			if ($this->intErrorNo!=0) // Error exists
			{
				
				$this->objDB->rollBackTransaction(); 
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}

			$objStatement->close(); 
	   }

/*=================================================================================
		Function Name 	: activation
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Activate customer when information is matched
		Input Parameter : Object ConsumerBO (string Email, string Activation code)
		Returns		  	: integer Status
=================================================================================*/

		function activation($pConsumerBO)
		{
			/// Calling Stored Procedure		
			$strQuery = "CALL CONSUMER_ACTIVATE_CODE_UPDATE(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ss",$pConsumerBO->getConsumerEmail(), $pConsumerBO->getConsumerActivationCode());
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result($intStatus);
			$objStatement->fetch();
  			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exits
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $intStatus;
	   }


/*=================================================================================
		Function Name 	: SignIn
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Check Consumer Authentication
		Input Parameter : Object ConsumerBO (string Email, string Password)
		Returns		  	: Object ConsumerBO (Integer Id, String Email,
						  String FirstName, String LastName)
=================================================================================*/

		function SignIn($pConsumerBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL CONSUMER_LOGIN(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ss",$pConsumerBO->getConsumerEmail(), $pConsumerBO->getConsumerPassword());
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result($pConsumerId, $pEmail, $pFirstName, $pLastName);
			$objStatement->fetch();
  			
			/// Set results in object
			$objConsumerBO=new ConsumerBO(); 
			$objConsumerBO->setConsumerId($pConsumerId);
			$objConsumerBO->setConsumerEmail($pEmail);
			$objConsumerBO->setConsumerFristName($pFirstName);
			$objConsumerBO->setConsumerLastName($pLastName);

			/// Get error no from stored procedure			
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exits
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $objConsumerBO;
	   }

/*=================================================================================
		Function Name 	: ForgetPassword
		Created On    	: 01-Jun-2006 
		Synopsis	  	: check information correct or not
		Input Parameter : Object ConsumerBO (string Email, integer SecretQuestion, 
						  string Answer)
		Returns		  	: Array (string FirstName, String LastName,
						  String Email, String Password)
=================================================================================*/

		function ForgetPassword($pConsumerBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL CONSUMER_LIST_ANSWER_BY_EMAIL(?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("sis",$pConsumerBO->getConsumerEmail(), $pConsumerBO->getConsumerSecretQuestion(), $pConsumerBO->getConsumerAnswer());
			$objStatement->execute();

			/// Get results from Stored Procedurs			
			$objStatement->bind_result($pFirstName,$pLastName,$pEmail,$pPassword);
			$objStatement->fetch();
  			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exists
			{

				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}
		
			$objStatement->close(); 
			
			/// Set results in an array
			$arrValue[0]=$pFirstName;
			$arrValue[1]=$pLastName;
			$arrValue[2]=$pEmail;
			$arrValue[3]=$pPassword;
			return $arrValue;
			
	   }


/*=================================================================================
		Function Name 	: select
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Get a particular Consumer record
		Input Parameter : Object ConsumerBO (string Email)
		Returns		  	: object ConsumerBO(All fields)
=================================================================================*/

	   function select($objConsumerBO)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL CONSUMER_LIST_BY_EMAIL(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("s",$objConsumerBO->getConsumerEmail());
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result(
										$pConsumerId, 
										$pCountryId, 
										$pStateId, 
										$pAccountType, 
										$pQuestionId, 
										$pEmail, 
										$pPassword, 
										$pFirstName, 
										$pLastName, 
										$pAddress, 
										$pCity, 
										$pZipCode, 
										$pTelephone1, 
										$pDateOfBirth, 
										$pAnswer, 
										$pActivationCode, 
										$pIsVarified, 
										$pCreateDate, 
										$pIsActive,
										$pMobile,
										$pCellularId
										); 

			$objStatement->fetch();
			/// Set results in object	
			$objConsumerBO=new ConsumerBO(); 
			
			$objConsumerBO->setConsumerId($pConsumerId);
			$objConsumerBO->setConsumerCountryId($pCountryId);
			$objConsumerBO->setConsumerStateId($pStateId);
			$objConsumerBO->setConsumerAccountType($pAccountType);
			$objConsumerBO->setConsumerSecretQuestion($pQuestionId);
			$objConsumerBO->setConsumerEmail($pEmail);
			$objConsumerBO->setConsumerPassword($pPassword);
			$objConsumerBO->setConsumerFristName($pFirstName);
			$objConsumerBO->setConsumerLastName($pLastName);
			$objConsumerBO->setConsumerAddress($pAddress);
			$objConsumerBO->setConsumerCity($pCity);
			$objConsumerBO->setConsumerZipCode($pZipCode);
			$objConsumerBO->setConsumerTelephone1($pTelephone1);
			$objConsumerBO->setConsumerDateOfBirth($pDateOfBirth);
			$objConsumerBO->setConsumerAnswer($pAnswer);
			$objConsumerBO->setConsumerActivationCode($pActivationCode);
			$objConsumerBO->setConsumerIsVerified($pIsVarified);
			$objConsumerBO->setConsumerCreateDate($pCreateDate);
			$objConsumerBO->setMobileNumber($pMobile);
			$objConsumerBO->setCellularId($pCellularId);
 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $objConsumerBO;
	   }


/*=================================================================================
		Function Name 	: ConsumerGetById
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Get a particular Consumer record
		Input Parameter : Object ConsumerBO (string Consumer Id)
		Returns		  	: Array of objects ConsumerBO(All fields)
=================================================================================*/

	   function ConsumerGetById($pConsumerId)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL CONSUMER_GET_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pConsumerId);
			$objStatement->execute();
			/// Get results from Stored Procedurs
			$objStatement->bind_result(
										$pConsumerId, 
										$pCountryId, 
										$pStateId, 
										$pAccountTypeId, 
										$pQuestionId, 
										$pEmail, 
										$pPassword, 
										$pFirstName, 
										$pLastName, 
										$pAddress, 
										$pCity, 
										$pZipCode, 
										$pTelephone1, 
										$pDateOfBirth, 
										$pAnswer, 
										$pActivationCode, 
										$pIsVarified, 
										$pCreateDate, 
										$pIsActive,
										$pMobile,
										$pCellularId,										
										$pCountryName,
										$pStateName,
										$pQuestionName,
										$pAccountType
										); 

			$objStatement->fetch();
			
			/// Set results in object	
			$objConsumerBO=new ConsumerBO(); 
			$objConsumerBO->setConsumerId($pConsumerId);
			$objConsumerBO->setConsumerCountryId($pCountryId);
			$objConsumerBO->setConsumerStateId($pStateId);
			$objConsumerBO->setConsumerAccountType($pAccountTypeId);
			$objConsumerBO->setConsumerSecretQuestion($pQuestionId);
			$objConsumerBO->setConsumerEmail($pEmail);
			$objConsumerBO->setConsumerPassword($pPassword);
			$objConsumerBO->setConsumerFristName($pFirstName);
			$objConsumerBO->setConsumerLastName($pLastName);
			$objConsumerBO->setConsumerAddress($pAddress);
			$objConsumerBO->setConsumerCity($pCity);
			$objConsumerBO->setConsumerZipCode($pZipCode);
			$objConsumerBO->setConsumerTelephone1($pTelephone1);
			$objConsumerBO->setConsumerDateOfBirth($pDateOfBirth);
			$objConsumerBO->setConsumerAnswer($pAnswer);
			$objConsumerBO->setConsumerActivationCode($pActivationCode);
			$objConsumerBO->setConsumerIsVerified($pIsVarified);
			$objConsumerBO->setConsumerCreateDate($pCreateDate);
			$objConsumerBO->setConsumerIsActive($pIsActive);
			$objConsumerBO->setMobileNumber($pMobile);
			$objConsumerBO->setCellularId($pCellularId);
			
			$objCountryBO=new CountryBO();
			$objCountryBO->setCountryName($pCountryName);
			
			$objStateBO=new StateBO();
			$objStateBO->setStateName($pStateName);
			
			$objSecretQuestionBO=new SecretQuestionBO();
			$objSecretQuestionBO->setSecretQuestionName($pQuestionName);
			
			$objAccountTypeBO=new AccountTypeBO();
			$objAccountTypeBO->setAccountTypeName($pAccountType);
			
			$objArrayConsumer[0]=$objConsumerBO;
			$objArrayConsumer[1]=$objCountryBO;
			$objArrayConsumer[2]=$objStateBO;
			$objArrayConsumer[3]=$objSecretQuestionBO;
			$objArrayConsumer[4]=$objAccountTypeBO;
			
 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $objArrayConsumer;
	   }


/*=================================================================================
		Function Name 	: ConsumerListByStatus
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Get a All Consumer record
		Input Parameter : Object ConsumerBO (int Start limit, int No of Rows, int status, int sort by)
		Returns		  	: Array of object ConsumerBO(All fields)
=================================================================================*/

	   function ConsumerListByStatus($pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL CONSUMER_LIST_BY_STATUS(".$pIntStart.",".$pIntNumRows.",".$pIntIsActive.",".$pIntSortListBy.")";
			$objStatement=$this->objDB->executeQuery($strQuery);

			/// Set results in object	
			while ($row=$objStatement->fetch_array()) 

			{
				$objConsumerBO=new ConsumerBO(); 
				$objConsumerBO->setConsumerId($row[0]);
				$objConsumerBO->setConsumerCountryId($row[1]);
				$objConsumerBO->setConsumerStateId($row[2]);
				$objConsumerBO->setConsumerAccountType($row[3]);
				$objConsumerBO->setConsumerSecretQuestion($row[4]);
				$objConsumerBO->setConsumerEmail($row[5]);
				$objConsumerBO->setConsumerPassword($row[6]);
				$objConsumerBO->setConsumerFristName($row[7]);
				$objConsumerBO->setConsumerLastName($row[8]);
				$objConsumerBO->setConsumerAddress($row[9]);
				$objConsumerBO->setConsumerCity($row[10]);
				$objConsumerBO->setConsumerZipCode($row[11]);
				$objConsumerBO->setConsumerTelephone1($row[12]);
				$objConsumerBO->setConsumerDateOfBirth($row[13]);
				$objConsumerBO->setConsumerAnswer($row[14]);
				$objConsumerBO->setConsumerActivationCode($row[15]);
				$objConsumerBO->setConsumerIsVerified($row[16]);
				$objConsumerBO->setConsumerCreateDate($row[17]);
				$objConsumerBO->setConsumerIsActive($row[18]);
				$objArrayConsumerBO[]=$objConsumerBO;
			}
			 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();

			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $objArrayConsumerBO;
	   }




/*=================================================================================
		Function Name 	: update
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Update record for particular customer
		Input Parameter : Object ConsumerBO (All fields)
		Returns		  	: none
=================================================================================*/

		function update($pConsumerBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL CONSUMER_UPDATE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("siiiisssssssssi",$pConsumerBO->getConsumerEmail()
														   ,$pConsumerBO->getConsumerCountryId()
														   ,$pConsumerBO->getConsumerStateId()
														   ,$pConsumerBO->getConsumerAccountType()
														   ,$pConsumerBO->getConsumerSecretQuestion()
														   ,$pConsumerBO->getConsumerFristName()
														   ,$pConsumerBO->getConsumerLastName()
														   ,$pConsumerBO->getConsumerAddress()
														   ,$pConsumerBO->getConsumerCity()
														   ,$pConsumerBO->getConsumerZipCode()
														   ,$pConsumerBO->getConsumerTelephone1()
														   ,$pConsumerBO->getConsumerDateOfBirth()
														   ,$pConsumerBO->getConsumerAnswer()
														   ,$pConsumerBO->getMobileNumber()
														   ,$pConsumerBO->getCellularId()
														   );
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
		Function Name 	: UpdateConsumer
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Update record for particular ID
		Input Parameter : Object ConsumerBO (All fields)
		Returns		  	: none
=================================================================================*/

		function UpdateConsumer($objConsumerBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL CONSUMER_UPDATE_BY_ID(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiiiisssssssssssisisi",$objConsumerBO->getConsumerId(),
														$objConsumerBO->getConsumerCountryId(),
														$objConsumerBO->getConsumerStateId(),
														$objConsumerBO->getConsumerAccountType(),
														$objConsumerBO->getConsumerSecretQuestion(),
														$objConsumerBO->getConsumerEmail(),
														$objConsumerBO->getConsumerPassword(),
														$objConsumerBO->getConsumerFristName(),
														$objConsumerBO->getConsumerLastName(),
														$objConsumerBO->getConsumerAddress(),
														$objConsumerBO->getConsumerCity(),
														$objConsumerBO->getConsumerZipCode(),
														$objConsumerBO->getConsumerTelephone1(),
														$objConsumerBO->getConsumerDateOfBirth(),
														$objConsumerBO->getConsumerAnswer(),
														$objConsumerBO->getConsumerActivationCode(),
														$objConsumerBO->getConsumerIsVerified(),
														$objConsumerBO->getConsumerCreateDate(),
														$objConsumerBO->getConsumerIsActive(),
													   	$objConsumerBO->getMobileNumber(),
													   	$objConsumerBO->getCellularId()
														 );
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
		Function Name 	: passwordUpdate
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Change password for specific customer after matching old one 
		Input Parameter : Object ConsumerBO (String email, String Old password, String New Pasword)
		Returns		  	: none
=================================================================================*/


	   function passwordUpdate($objConsumerBO,$newPassword)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL CONSUMER_PASSWORD_UPDATE(?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("sss",$objConsumerBO->getConsumerEmail(),$objConsumerBO->getConsumerPassword(),$newPassword);
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
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
		Function Name 	: ConsumerRecordCountByStatus
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records against a particular Consumer
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/
		function ConsumerRecordCountByStatus($pIntIsActive)
		{
			$strQuery = "CALL CONSUMER_RECORD_COUNT_BY_STATUS(?)";
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
		Function Name 	: ConsumerDeleteById
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Delete particular record against ID
		Input Parameter : integer ID
		Returns		  	: none
=================================================================================*/
		function ConsumerDeleteById($pConsumerId)
		{
			$strQuery = "CALL CONSUMER_DELETE_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pConsumerId);
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



	}	
?>