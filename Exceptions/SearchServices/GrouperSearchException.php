<?php
//include('../Utilities/ErrorHandler.inc');
class GrouperSearchException extends Exception 
{
var $strMessage;
	function __construct($strMessage)
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