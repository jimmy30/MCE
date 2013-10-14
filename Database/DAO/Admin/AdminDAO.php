<?php 

/*=================================================================================
		Class Name    : AdminDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with Admin Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class AdminDAO
	{
		
		//// Declaring DB connection and objects and variables
		var $objDB;
		
		var $Port;
				
		/// Declaring Error handling variables
		var $strErrorMessage;
		var $strEmailErrorMessage;
		var $intErrorNo;

		/// Declaring paging variables
		var $recordLimit;
		var $pagesLimit;

		
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
			
			$this->Port = 25;
			
			/// GEt Paging variables from property file
			$this->recordLimit = $objProperties->getProperty('admin_paging_record_limit');
			$this->pagesLimit = $objProperties->getProperty('admin_paging_pages_limit');

			/// Connect With Database
			$this->objDB=Database::singleton();
			
			/// Exception thrown incase of error connecting with DB
			if (mysqli_connect_errno())
			{ 
   				throw new DatabaseConnectivityException();
			}	 
		}
		

/*=================================================================================
		Function Name 	: SignIn
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Check Admin Authentication
		Input Parameter : Object AdminBO (string Email, string Password)
		Returns		  	: Object AdminBO (Integer Id, String Email,
						  String FirstName, String LastName)
=================================================================================*/

		function SignIn($pAdminBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL ADMIN_LOGIN(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("ss",$pAdminBO->getEmail(), $pAdminBO->getPassword());
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result($pEmail);
			$objStatement->fetch();
  			
			/// Get error no from stored procedure			
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exits
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
			return $pEmail;
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

		function ForgetPassword($pStrEmail)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL ADMIN_FORGET_PASSWORD(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("s",$pStrEmail);
			$objStatement->execute();

			/// Get results from Stored Procedurs			
			$objStatement->bind_result($pEmail,$pPassword);
			$objStatement->fetch();
			
			$objAdminBO = new AdminBO();
			$objAdminBO->setEmail($pEmail);
			$objAdminBO->setPassword($pPassword);
	
  			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exists
			{

				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}
		
			$objStatement->close(); 
			
			return $objAdminBO;
			
	   }


/*=================================================================================
		Function Name 	: passwordUpdate
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Change password for specific customer after matching old one 
		Input Parameter : Object AdminBO (String email, String Old password, String New Pasword)
		Returns		  	: none
=================================================================================*/


	   function passwordUpdate($objAdminBO,$newPassword)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL ADMIN_PASSWORD_UPDATE(?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("sss",$objAdminBO->getEmail(),$objAdminBO->getPassword(),$newPassword);

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

	}	
?>