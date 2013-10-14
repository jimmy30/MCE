<?php 

class DatabaseConnectivityException extends Exception 
{
	var $strMessage="Error occured while connecting with the database server";
	
	function __construct()
	{
		parent::__construct($strMessage);
		$this->strMessage=$strMessage;
		
	}
	function displayMessage()
	{
		echo ($this->strMessage);	
	}
}

?>
