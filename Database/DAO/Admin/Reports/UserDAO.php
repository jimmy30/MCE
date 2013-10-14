<?php
/*=================================================================================
		Class Name    : UserDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with Producer and Consumer Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class UserDAO
	{
		
		//// Declaring DB connection and objects and variables
		var $objDB;
				
		/// Declaring Error handling variables
		var $strErrorMessage;
		var $strEmailErrorMessage;
		var $intErrorNo;
		
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
			
			/// Exception thrown incase of error connecting with DB
			if (mysqli_connect_errno())
			{ 
   				throw new DatabaseConnectivityException();
			}	 
		}


/*=================================================================================
		Function Name 	: RecordCountByTypeAndStatus
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Record Count
		Input Parameter : integer AccountType, integer IsActive
		Returns		  	: integer Count Records
=================================================================================*/
		function GetUsersReport($pFromDate, $pToDate)
		{
			$strQuery = "CALL USER_RECORD_COUNT_REPORT(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param('ss',$pFromDate, $pToDate);
			$objStatement->execute();

 			$objStatement->bind_result($FreeActiveP,$FreeInActiveP,$PremiumActiveP,$PremiumInActiveP,$FreeActiveC,$FreeInActiveC,$PremiumActiveC,$PremiumInActiveC,$SumFreeP,$SumPrmiumP,$SumFreeC,$SumPrmiumC,$SumP,$SumC);
			$objStatement->fetch();
			
			$objUserBO = new UserBO();
			$objUserBO->setFreeActiveP($FreeActiveP);
			$objUserBO->setFreeInActiveP($FreeInActiveP);
			$objUserBO->setPremiumActiveP($PremiumActiveP);
			$objUserBO->setPremiumInActiveP($PremiumInActiveP);
			$objUserBO->setFreeActiveC($FreeActiveC);
			$objUserBO->setFreeInActiveC($FreeInActiveC);
			$objUserBO->setPremiumActiveC($PremiumActiveC);
			$objUserBO->setPremiumInActiveC($PremiumInActiveC);
			$objUserBO->setSumFreeP($SumFreeP);
			$objUserBO->setSumPremiumP($SumPrmiumP);
			$objUserBO->setSumFreeC($SumFreeC);
			$objUserBO->setSumPremiumC($SumPrmiumC);
			$objUserBO->setSumP($SumP);
			$objUserBO->setSumC($SumC);
			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}

			$objStatement->close(); 
			return $objUserBO;		
		}

	}
?>