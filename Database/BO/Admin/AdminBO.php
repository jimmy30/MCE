<?php 
class AdminBO
{
	var $strEmail;
	var $strPassword;	
							
 	function __construct()
 	{
		 		
 	}
	
 	function getEmail()
 	{
 		return $this->strEmail;
 	}
 	function setEmail($pEmail)
 	{
 		$this->strEmail=$pEmail;
 	}

 	function getPassword()
 	{
 		return $this->strPassword;
 	}
 	function setPassword($pPassword)
 	{
 		$this->strPassword=$pPassword;
 	}
 	
}


?>