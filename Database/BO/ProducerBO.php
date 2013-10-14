<?php 
class ProducerBO
{
	var $intProducerId;
	var $intProducerCountryId;
	var $intProducerStateId;
 	var $intProducerAccountType;
	var $strProducerEmail;
	var $strProducerPassword;
	var $strProducerFristName;	
	var $strProducerLastName;		
	var $strProducerAddress;			
	var $strProducerCity;		
	var $strProducerZipCode;		
	var $strProducerTelephone1;			
	var $strProducerTelephone2;				
	var $strProducerTelephone3;			
	var $strProducerExtension;				
	var $dateProducerDateOfBirth;	
	var $strProducerSecretQuestion;
	var $strProducerAnswer;	
	var $strProducerActivationCode;		
	var $intProducerIsVerified;			
	var $dateProducerCreateDate;
	var $intProducerIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getProducerId()
 	{
 		return $this->intProducerId;
 	}
 	function setProducerId($pProducerId)
 	{
 		$this->intProducerId=$pProducerId;
 	}
 	
 	function getProducerCountryId()
 	{
 		return $this->intProducerCountryId;
 	}
 	function setProducerCountryId($pProducerCountryId)
 	{
 		$this->intProducerCountryId=$pProducerCountryId;
 	}

 	function getProducerStateId()
 	{
 		return $this->intProducerStateId;
 	}
 	function setProducerStateId($pProducerStateId)
 	{
 		$this->intProducerStateId=$pProducerStateId;
 	}
 	
 	function getProducerAccountType()
 	{
 		return $this->intProducerAccountType;
 	}
 	function setProducerAccountType($pProducerAccountType)
 	{
 		$this->intProducerAccountType=$pProducerAccountType;
 	}

 	function getProducerEmail()
 	{
 		return $this->strProducerEmail;
 	}
 	function setProducerEmail($pProducerEmail)
 	{
 		$this->strProducerEmail=$pProducerEmail;
 	}

 	function getProducerPassword()
 	{
 		return $this->strProducerPassword;
 	}
 	function setProducerPassword($pProducerPassword)
 	{
 		$this->strProducerPassword=$pProducerPassword;
 	}

 	function getProducerFristName()
 	{
 		return $this->strProducerFristName;
 	}
 	function setProducerFristName($pProducerFristName)
 	{
 		$this->strProducerFristName=$pProducerFristName;
 	}

 	function getProducerLastName()
 	{
 		return $this->strProducerLastName;
 	}
 	function setProducerLastName($pProducerLastName)
 	{
 		$this->strProducerLastName=$pProducerLastName;
 	}

 	function getProducerAddress()
 	{
 		return $this->strProducerAddress;
 	}
 	function setProducerAddress($pProducerAddress)
 	{
 		$this->strProducerAddress=$pProducerAddress;
 	}

 	function getProducerCity()
 	{
 		return $this->strProducerCity;
 	}
 	function setProducerCity($pProducerCity)
 	{
 		$this->strProducerCity=$pProducerCity;
 	}

 	function getProducerZipCode()
 	{
 		return $this->strProducerZipCode;
 	}
 	function setProducerZipCode($pProducerZipCode)
 	{
 		$this->strProducerZipCode=$pProducerZipCode;
 	}

 	function getProducerTelephone1()
 	{
 		return $this->strProducerTelephone1;
 	}
 	function setProducerTelephone1($pProducerTelephone1)
 	{
 		$this->strProducerTelephone1=$pProducerTelephone1;
 	}

 	function getProducerTelephone2()
 	{
 		return $this->strProducerTelephone2;
 	}
 	function setProducerTelephone2($pProducerTelephone2)
 	{
 		$this->strProducerTelephone2=$pProducerTelephone2;
 	}

 	function getProducerTelephone3()
 	{
 		return $this->strProducerTelephone3;
 	}
 	function setProducerTelephone3($pProducerTelephone3)
 	{
 		$this->strProducerTelephone3=$pProducerTelephone3;
 	}

 	function getProducerExtension()
 	{
 		return $this->strProducerExtension;
 	}
 	function setProducerExtension($pProducerExtension)
 	{
 		$this->strProducerExtension=$pProducerExtension;
 	}

 	function getProducerDateOfBirth()
 	{
 		return $this->dateProducerDateOfBirth;
 	}
 	function setProducerDateOfBirth($pProducerDateOfBirth)
 	{
 		$this->dateProducerDateOfBirth=$pProducerDateOfBirth;
 	}

 	function getProducerSecretQuestion()
 	{
 		return $this->strProducerSecretQuestion;
 	}
 	function setProducerSecretQuestion($pProducerSecretQuestion)
 	{
 		$this->strProducerSecretQuestion=$pProducerSecretQuestion;
 	}

 	function getProducerAnswer()
 	{
 		return $this->strProducerAnswer;
 	}
 	function setProducerAnswer($pProducerAnswer)
 	{
 		$this->strProducerAnswer=$pProducerAnswer;
 	}

 	function getProducerActivationCode()
 	{
 		return $this->strProducerActivationCode;
 	}
 	function setProducerActivationCode($pProducerActivationCode)
 	{
 		$this->strProducerActivationCode=$pProducerActivationCode;
 	}

 	function getProducerIsVerified()
 	{
 		return $this->intProducerIsVerified;
 	}
 	function setProducerIsVerified($pProducerIsVerified)
 	{
 		$this->intProducerIsVerified=$pProducerIsVerified;
 	}


 	function getProducerCreateDate()
 	{
 		return $this->dateProducerCreateDate;
 	}
 	function setProducerCreateDate($pProducerCreateDate)
 	{
 		$this->dateProducerCreateDate=$pProducerCreateDate;
 	}

 	function getProducerIsActive()
 	{
 		return $this->intProducerIsActive;
 	}
 	function setProducerIsActive($pProducerIsActive)
 	{
 		$this->intProducerIsActive=$pProducerIsActive;
 	}

}


?>