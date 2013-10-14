<?php 
class SecretQuestionBO
{
	var $intSecretQuestionId;
	var $strSecretQuestionName;		
	var $dateSecretQuestionDate;
	var $intSecretQuestionIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getSecretQuestionId()
 	{
 		return $this->intSecretQuestionId;
 	}
 	function setSecretQuestionId($pSecretQuestionId)
 	{
 		$this->intSecretQuestionId=$pSecretQuestionId;
 	}
 	
 	function getSecretQuestionName()
 	{
 		return $this->strSecretQuestionName;
 	}
 	function setSecretQuestionName($pSecretQuestionName)
 	{
 		$this->strSecretQuestionName=$pSecretQuestionName;
 	}
 	
 	function getSecretQuestionCreateDate()
 	{
 		return $this->dateSecretQuestionCreateDate;
 	}
 	function setSecretQuestionCreateDate($pSecretQuestionCreateDate)
 	{
 		$this->dateSecretQuestionCreateDate=$pSecretQuestionCreateDate;
 	}

 	function getSecretQuestionIsActive()
 	{
 		return $this->intSecretQuestionIsActive;
 	}
 	function setSecretQuestionIsActive($pSecretQuestionIsActive)
 	{
 		$this->intSecretQuestionIsActive=$pSecretQuestionIsActive;
 	}

}


?>