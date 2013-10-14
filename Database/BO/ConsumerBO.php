<?php 
class ConsumerBO
{
	var $intConsumerId;
	var $intConsumerCountryId;
	var $intConsumerStateId;
 	var $intConsumerAccountType;
	var $strConsumerEmail;
	var $strConsumerPassword;
	var $strConsumerFristName;	
	var $strConsumerLastName;		
	var $strConsumerAddress;			
	var $strConsumerCity;		
	var $strConsumerZipCode;		
	var $strConsumerTelephone1;			
	var $strConsumerTelephone2;				
	var $strConsumerTelephone3;			
	var $strConsumerExtension;				
	var $dateConsumerDateOfBirth;	
	var $strConsumerSecretQuestion;
	var $strConsumerAnswer;	
	var $strConsumerActivationCode;		
	var $intConsumerIsVerified;			
	var $dateConsumerCreateDate;
	var $intConsumerIsActive;			
	var $strMobileNumber;
	var $intCellularId;						
 	function __construct()
 	{
		 		
 	}
	
 	function getConsumerId()
 	{
 		return $this->intConsumerId;
 	}
 	function setConsumerId($pConsumerId)
 	{
 		$this->intConsumerId=$pConsumerId;
 	}
 	
 	function getConsumerCountryId()
 	{
 		return $this->intConsumerCountryId;
 	}
 	function setConsumerCountryId($pConsumerCountryId)
 	{
 		$this->intConsumerCountryId=$pConsumerCountryId;
 	}

 	function getConsumerStateId()
 	{
 		return $this->intConsumerStateId;
 	}
 	function setConsumerStateId($pConsumerStateId)
 	{
 		$this->intConsumerStateId=$pConsumerStateId;
 	}
 	
 	function getConsumerAccountType()
 	{
 		return $this->intConsumerAccountType;
 	}
 	function setConsumerAccountType($pConsumerAccountType)
 	{
 		$this->intConsumerAccountType=$pConsumerAccountType;
 	}

 	function getConsumerEmail()
 	{
 		return $this->strConsumerEmail;
 	}
 	function setConsumerEmail($pConsumerEmail)
 	{
 		$this->strConsumerEmail=$pConsumerEmail;
 	}

 	function getConsumerPassword()
 	{
 		return $this->strConsumerPassword;
 	}
 	function setConsumerPassword($pConsumerPassword)
 	{
 		$this->strConsumerPassword=$pConsumerPassword;
 	}

 	function getConsumerFristName()
 	{
 		return $this->strConsumerFristName;
 	}
 	function setConsumerFristName($pConsumerFristName)
 	{
 		$this->strConsumerFristName=$pConsumerFristName;
 	}

 	function getConsumerLastName()
 	{
 		return $this->strConsumerLastName;
 	}
 	function setConsumerLastName($pConsumerLastName)
 	{
 		$this->strConsumerLastName=$pConsumerLastName;
 	}

 	function getConsumerAddress()
 	{
 		return $this->strConsumerAddress;
 	}
 	function setConsumerAddress($pConsumerAddress)
 	{
 		$this->strConsumerAddress=$pConsumerAddress;
 	}

 	function getConsumerCity()
 	{
 		return $this->strConsumerCity;
 	}
 	function setConsumerCity($pConsumerCity)
 	{
 		$this->strConsumerCity=$pConsumerCity;
 	}

 	function getConsumerZipCode()
 	{
 		return $this->strConsumerZipCode;
 	}
 	function setConsumerZipCode($pConsumerZipCode)
 	{
 		$this->strConsumerZipCode=$pConsumerZipCode;
 	}

 	function getConsumerTelephone1()
 	{
 		return $this->strConsumerTelephone1;
 	}
 	function setConsumerTelephone1($pConsumerTelephone1)
 	{
 		$this->strConsumerTelephone1=$pConsumerTelephone1;
 	}

 	function getConsumerTelephone2()
 	{
 		return $this->strConsumerTelephone2;
 	}
 	function setConsumerTelephone2($pConsumerTelephone2)
 	{
 		$this->strConsumerTelephone2=$pConsumerTelephone2;
 	}

 	function getConsumerTelephone3()
 	{
 		return $this->strConsumerTelephone3;
 	}
 	function setConsumerTelephone3($pConsumerTelephone3)
 	{
 		$this->strConsumerTelephone3=$pConsumerTelephone3;
 	}

 	function getConsumerExtension()
 	{
 		return $this->strConsumerExtension;
 	}
 	function setConsumerExtension($pConsumerExtension)
 	{
 		$this->strConsumerExtension=$pConsumerExtension;
 	}

 	function getConsumerDateOfBirth()
 	{
 		return $this->dateConsumerDateOfBirth;
 	}
 	function setConsumerDateOfBirth($pConsumerDateOfBirth)
 	{
 		$this->dateConsumerDateOfBirth=$pConsumerDateOfBirth;
 	}

 	function getConsumerSecretQuestion()
 	{
 		return $this->strConsumerSecretQuestion;
 	}
 	function setConsumerSecretQuestion($pConsumerSecretQuestion)
 	{
 		$this->strConsumerSecretQuestion=$pConsumerSecretQuestion;
 	}

 	function getConsumerAnswer()
 	{
 		return $this->strConsumerAnswer;
 	}
 	function setConsumerAnswer($pConsumerAnswer)
 	{
 		$this->strConsumerAnswer=$pConsumerAnswer;
 	}

 	function getConsumerActivationCode()
 	{
 		return $this->strConsumerActivationCode;
 	}
 	function setConsumerActivationCode($pConsumerActivationCode)
 	{
 		$this->strConsumerActivationCode=$pConsumerActivationCode;
 	}

 	function getConsumerIsVerified()
 	{
 		return $this->intConsumerIsVerified;
 	}
 	function setConsumerIsVerified($pConsumerIsVerified)
 	{
 		$this->intConsumerIsVerified=$pConsumerIsVerified;
 	}


 	function getConsumerCreateDate()
 	{
 		return $this->dateConsumerCreateDate;
 	}
 	function setConsumerCreateDate($pConsumerCreateDate)
 	{
 		$this->dateConsumerCreateDate=$pConsumerCreateDate;
 	}

 	function getConsumerIsActive()
 	{
 		return $this->intConsumerIsActive;
 	}
 	function setConsumerIsActive($pConsumerIsActive)
 	{
 		$this->intConsumerIsActive=$pConsumerIsActive;
 	}
	function getMobileNumber()
	{
		return $this->strMobileNumber;
	}
	function setMobileNumber($pStrMobileNumber)
	{
		$this->strMobileNumber=$pStrMobileNumber;
	}
	function getCellularId()
	{
		return $this->intCellularId;
	}
	function setCellularId($pIntCellularId)
	{
		$this->intCellularId=$pIntCellularId;
	}

}


?>