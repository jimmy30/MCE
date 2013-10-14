<?php 

/*=================================================================================
		Class Name    : ProducerDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with Producer Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class ProducerDAO
	{
		
		//// Declaring DB connection and objects and variables
		var $objDB;
		var $Port;
		
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
						
			$this->Port = 25;
			
			/// Get common variables from property file
			$this->siteUrl=$objProperties->getProperty('site_url');
			$this->helpEmail=$objProperties->getProperty('registration_producer_help_email');			
			
			/// Get customer registration email variables from property file
			$this->strRegistrationFromEmail=$objProperties->getProperty('registration_producer_from_email');						
			$this->strRegistrationEmailSubject=$objProperties->getProperty('registraion_producer_email_subject');	
			$this->strRegistrationEmailBody=$objProperties->getProperty('registraion_producer_email_body');				

			/// Exception thrown incase of error connecting with DB
			if (mysqli_connect_errno())
			{ 
   				throw new DatabaseConnectivityException();
			}	 
		}
		
/*=================================================================================
		Function Name 	: insert
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Insert Producer record and send email to customer registration
		Input Parameter : Object ProducerBO (All customer fields)
		Returns		  	: none
=================================================================================*/

		function insert($pProducerBO) 
		{
			$this->objDB->startTransaction(FALSE);

			/// Calling Stored Procedure
			$strQuery = "CALL PRODUCER_INSERT(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiiisssssssssssisi",$pProducerBO->getProducerCountryId()
														   ,$pProducerBO->getProducerStateId()
														   ,$pProducerBO->getProducerAccountType()
														   ,$pProducerBO->getProducerSecretQuestion()
														   ,$pProducerBO->getProducerEmail()
														   ,$pProducerBO->getProducerPassword()
														   ,$pProducerBO->getProducerFristName()
														   ,$pProducerBO->getProducerLastName()
														   ,$pProducerBO->getProducerAddress()
														   ,$pProducerBO->getProducerCity()
														   ,$pProducerBO->getProducerZipCode()
														   ,$pProducerBO->getProducerTelephone1()
														   ,$pProducerBO->getProducerDateOfBirth()
														   ,$pProducerBO->getProducerAnswer()
														   ,$pProducerBO->getProducerActivationCode()
														   ,$pProducerBO->getProducerIsVerified()
														   ,$pProducerBO->getProducerCreateDate()
														   ,$pProducerBO->getProducerIsActive());
			$objStatement->execute();
	
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
			
			if($this->intErrorNo==0) /// Error does not exists
			{
				/// Set activation page URL
				$pageRegistrationActivation=$this->siteUrl.clsConstants::PAGE_PRODUCER_REGISTRATION_ACTIVATION;

				/// Generating Email body for customer registration
				$this->strRegistrationEmailBody=str_replace("[ACTIVATION_PAGE]",$pageRegistrationActivation,$this->strRegistrationEmailBody);
				$this->strRegistrationEmailBody=str_replace("[ACTIVATION_CODE]",$pProducerBO->getProducerActivationCode(),$this->strRegistrationEmailBody);
				$this->strRegistrationEmailBody=str_replace("[EMAIL]",$pProducerBO->getProducerEmail(),$this->strRegistrationEmailBody);				
				$this->strRegistrationEmailBody=str_replace("[PASSWORD]",$pProducerBO->getProducerPassword(),$this->strRegistrationEmailBody);								
				$this->strRegistrationEmailBody=str_replace("[FIRST_NAME]",$pProducerBO->getProducerFristName(),$this->strRegistrationEmailBody);
				$this->strRegistrationEmailBody=str_replace("[LAST_NAME]",$pProducerBO->getProducerLastName(),$this->strRegistrationEmailBody);				
				$this->strRegistrationEmailBody=str_replace("[SITE_URL]",$this->siteUrl,$this->strRegistrationEmailBody);				
				$this->strRegistrationEmailBody=str_replace("[PRODUCER_REGISTRATION_HELP_EMAIL]",$this->helpEmail,$this->strRegistrationEmailBody);								

				/// Sending Registration Email to Producer
				$objUtitlity=new utility();
				$objUtitlity->sendEmail($this->strRegistrationFromEmail,$pProducerBO->getProducerEmail(),$this->strRegistrationEmailSubject,$this->strRegistrationEmailBody);
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
		Input Parameter : Object ProducerBO (string Email, string Activation code)
		Returns		  	: integer Status
=================================================================================*/

		function activation($pProducerBO)
		{
			/// Calling Stored Procedure		
			$strQuery = "CALL PRODUCER_ACTIVATE_CODE_UPDATE(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ss",$pProducerBO->getProducerEmail(), $pProducerBO->getProducerActivationCode());
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
		Synopsis	  	: Check Producer Authentication
		Input Parameter : Object ProducerBO (string Email, string Password)
		Returns		  	: Object ProducerBO (Integer Id, String Email,
						  String FirstName, String LastName)
=================================================================================*/

		function SignIn($pProducerBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL PRODUCER_LOGIN(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ss",$pProducerBO->getProducerEmail(), $pProducerBO->getProducerPassword());
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result($pProducerId, $pEmail, $pFirstName, $pLastName);
			$objStatement->fetch();
  			
			/// Set results in object
			$objProducerBO=new ProducerBO(); 
			$objProducerBO->setProducerId($pProducerId);
			$objProducerBO->setProducerEmail($pEmail);
			$objProducerBO->setProducerFristName($pFirstName);
			$objProducerBO->setProducerLastName($pLastName);

			/// Get error no from stored procedure			
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exits
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $objProducerBO;
	   }

/*=================================================================================
		Function Name 	: ForgetPassword
		Created On    	: 01-Jun-2006 
		Synopsis	  	: check information correct or not
		Input Parameter : Object ProducerBO (string Email, integer SecretQuestion, 
						  string Answer)
		Returns		  	: Array (string FirstName, String LastName,
						  String Email, String Password)
=================================================================================*/

		function ForgetPassword($pProducerBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL PRODUCER_LIST_ANSWER_BY_EMAIL(?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("sis",$pProducerBO->getProducerEmail(), $pProducerBO->getProducerSecretQuestion(), $pProducerBO->getProducerAnswer());
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
		Synopsis	  	: Get a particular Producer record
		Input Parameter : Object ProducerBO (string Email)
		Returns		  	: object ProducerBO(All fields)
=================================================================================*/

	   function select($objProducerBO)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL PRODUCER_LIST_BY_EMAIL(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("s",$objProducerBO->getProducerEmail());
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result(
										$pProducerId, 
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
										$pIsActive
										); 

			$objStatement->fetch();
			
			/// Set results in object	
			$objProducerBO=new ProducerBO(); 
			$objProducerBO->setProducerId($pProducerId);
			$objProducerBO->setProducerCountryId($pCountryId);
			$objProducerBO->setProducerStateId($pStateId);
			$objProducerBO->setProducerAccountType($pAccountType);
			$objProducerBO->setProducerSecretQuestion($pQuestionId);
			$objProducerBO->setProducerEmail($pEmail);
			$objProducerBO->setProducerPassword($pPassword);
			$objProducerBO->setProducerFristName($pFirstName);
			$objProducerBO->setProducerLastName($pLastName);
			$objProducerBO->setProducerAddress($pAddress);
			$objProducerBO->setProducerCity($pCity);
			$objProducerBO->setProducerZipCode($pZipCode);
			$objProducerBO->setProducerTelephone1($pTelephone1);
			$objProducerBO->setProducerDateOfBirth($pDateOfBirth);
			$objProducerBO->setProducerAnswer($pAnswer);
			$objProducerBO->setProducerActivationCode($pActivationCode);
			$objProducerBO->setProducerIsVerified($pIsVarified);
			$objProducerBO->setProducerCreateDate($pCreateDate);
 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $objProducerBO;
	   }

/*=================================================================================
		Function Name 	: ProducerGetById
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Get a particular Producer record
		Input Parameter : Object ProducerBO (string Producer Id)
		Returns		  	: Array of objects ProducerBO(All fields)
=================================================================================*/

	   function ProducerGetById($pProducerId)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL PRODUCER_GET_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pProducerId);
			$objStatement->execute();
			/// Get results from Stored Procedurs
			$objStatement->bind_result(
										$pProducerId, 
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
										$pCountryName,
										$pStateName,
										$pQuestionName,
										$pAccountType
										); 

			$objStatement->fetch();
			
			/// Set results in object	
			$objProducerBO=new ProducerBO(); 
			$objProducerBO->setProducerId($pProducerId);
			$objProducerBO->setProducerCountryId($pCountryId);
			$objProducerBO->setProducerStateId($pStateId);
			$objProducerBO->setProducerAccountType($pAccountTypeId);
			$objProducerBO->setProducerSecretQuestion($pQuestionId);
			$objProducerBO->setProducerEmail($pEmail);
			$objProducerBO->setProducerPassword($pPassword);
			$objProducerBO->setProducerFristName($pFirstName);
			$objProducerBO->setProducerLastName($pLastName);
			$objProducerBO->setProducerAddress($pAddress);
			$objProducerBO->setProducerCity($pCity);
			$objProducerBO->setProducerZipCode($pZipCode);
			$objProducerBO->setProducerTelephone1($pTelephone1);
			$objProducerBO->setProducerDateOfBirth($pDateOfBirth);
			$objProducerBO->setProducerAnswer($pAnswer);
			$objProducerBO->setProducerActivationCode($pActivationCode);
			$objProducerBO->setProducerIsVerified($pIsVarified);
			$objProducerBO->setProducerCreateDate($pCreateDate);
			$objProducerBO->setProducerIsActive($pIsActive);
			
			$objCountryBO=new CountryBO();
			$objCountryBO->setCountryName($pCountryName);
			
			$objStateBO=new StateBO();
			$objStateBO->setStateName($pStateName);
			
			$objSecretQuestionBO=new SecretQuestionBO();
			$objSecretQuestionBO->setSecretQuestionName($pQuestionName);
			
			$objAccountTypeBO=new AccountTypeBO();
			$objAccountTypeBO->setAccountTypeName($pAccountType);
			
			$objArrayProducer[0]=$objProducerBO;
			$objArrayProducer[1]=$objCountryBO;
			$objArrayProducer[2]=$objStateBO;
			$objArrayProducer[3]=$objSecretQuestionBO;
			$objArrayProducer[4]=$objAccountTypeBO;
			
 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $objArrayProducer;
	   }

/*=================================================================================
		Function Name 	: ProducerListByStatus
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Get a All Producer record
		Input Parameter : Object ProducerBO (int Start limit, int No of Rows, int status, int sort by)
		Returns		  	: Array of object ProducerBO(All fields)
=================================================================================*/

	   function ProducerListByStatus($pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL PRODUCER_LIST_BY_STATUS(".$pIntStart.",".$pIntNumRows.",".$pIntIsActive.",".$pIntSortListBy.")";
			$objStatement=$this->objDB->executeQuery($strQuery);

			/// Set results in object	
			while ($row=$objStatement->fetch_array()) 

			{
				$objProducerBO=new ProducerBO(); 
				$objProducerBO->setProducerId($row[0]);
				$objProducerBO->setProducerCountryId($row[1]);
				$objProducerBO->setProducerStateId($row[2]);
				$objProducerBO->setProducerAccountType($row[3]);
				$objProducerBO->setProducerSecretQuestion($row[4]);
				$objProducerBO->setProducerEmail($row[5]);
				$objProducerBO->setProducerPassword($row[6]);
				$objProducerBO->setProducerFristName($row[7]);
				$objProducerBO->setProducerLastName($row[8]);
				$objProducerBO->setProducerAddress($row[9]);
				$objProducerBO->setProducerCity($row[10]);
				$objProducerBO->setProducerZipCode($row[11]);
				$objProducerBO->setProducerTelephone1($row[12]);
				$objProducerBO->setProducerDateOfBirth($row[13]);
				$objProducerBO->setProducerAnswer($row[14]);
				$objProducerBO->setProducerActivationCode($row[15]);
				$objProducerBO->setProducerIsVerified($row[16]);
				$objProducerBO->setProducerCreateDate($row[17]);
				$objProducerBO->setProducerIsActive($row[18]);
				$objArrayProducerBO[]=$objProducerBO;
			}
			 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();

			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $objArrayProducerBO;
	   }


/*=================================================================================
		Function Name 	: update
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Update record for particular customer
		Input Parameter : Object ProducerBO (All fields)
		Returns		  	: none
=================================================================================*/

		function update($pProducerBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL PRODUCER_UPDATE(?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("siiiissssssss",$pProducerBO->getProducerEmail()
														   ,$pProducerBO->getProducerCountryId()
														   ,$pProducerBO->getProducerStateId()
														   ,$pProducerBO->getProducerAccountType()
														   ,$pProducerBO->getProducerSecretQuestion()
														   ,$pProducerBO->getProducerFristName()
														   ,$pProducerBO->getProducerLastName()
														   ,$pProducerBO->getProducerAddress()
														   ,$pProducerBO->getProducerCity()
														   ,$pProducerBO->getProducerZipCode()
														   ,$pProducerBO->getProducerTelephone1()
														   ,$pProducerBO->getProducerDateOfBirth()
														   ,$pProducerBO->getProducerAnswer()
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
		Function Name 	: UpdateProducer
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Update record for particular ID
		Input Parameter : Object ProducerBO (All fields)
		Returns		  	: none
=================================================================================*/

		function UpdateProducer($objProducerBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL PRODUCER_UPDATE_BY_ID(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiiiisssssssssssisi",$objProducerBO->getProducerId(),
														$objProducerBO->getProducerCountryId(),
														$objProducerBO->getProducerStateId(),
														$objProducerBO->getProducerAccountType(),
														$objProducerBO->getProducerSecretQuestion(),
														$objProducerBO->getProducerEmail(),
														$objProducerBO->getProducerPassword(),
														$objProducerBO->getProducerFristName(),
														$objProducerBO->getProducerLastName(),
														$objProducerBO->getProducerAddress(),
														$objProducerBO->getProducerCity(),
														$objProducerBO->getProducerZipCode(),
														$objProducerBO->getProducerTelephone1(),
														$objProducerBO->getProducerDateOfBirth(),
														$objProducerBO->getProducerAnswer(),
														$objProducerBO->getProducerActivationCode(),
														$objProducerBO->getProducerIsVerified(),
														$objProducerBO->getProducerCreateDate(),
														$objProducerBO->getProducerIsActive()
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
		Input Parameter : Object ProducerBO (String email, String Old password, String New Pasword)
		Returns		  	: none
=================================================================================*/


	   function passwordUpdate($objProducerBO,$newPassword)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL PRODUCER_PASSWORD_UPDATE(?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("sss",$objProducerBO->getProducerEmail(),$objProducerBO->getProducerPassword(),$newPassword);
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
		Function Name 	: ProducerRecordCountByStatus
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records against a particular Producer
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/
		function ProducerRecordCountByStatus($pIntIsActive)
		{
			$strQuery = "CALL PRODUCER_RECORD_COUNT_BY_STATUS(?)";
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
		Function Name 	: ProducerDeleteById
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Delete particular record against ID
		Input Parameter : integer ID
		Returns		  	: none
=================================================================================*/
		function ProducerDeleteById($pProducerId)
		{
			$strQuery = "CALL PRODUCER_DELETE_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pProducerId);
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
		Function Name 	: IsConsumerProducer
		Created On    	: 22-Nov-2006 
		Synopsis	  	: Validate Email into Consumer and Producer
		Input Parameter : Producer Email
		Returns		  	: integer Status
=================================================================================*/
		function IsConsumerProducer($pEmail)
		{
			/// Calling Stored Procedure	
	   		$strQuery = "CALL IS_CONSUMER_PRODUCER(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("s",$pEmail);
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
	}	
?>