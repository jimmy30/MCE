<?php

class GoogleSearchException extends Exception 
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