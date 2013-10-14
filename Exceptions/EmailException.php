<?PHP 
class EmailExecption extends Exception 
{
	var $strMessage="Error occured while sending Email!";
	
	function __construct($pException)
	{
		if ($pException!="")
		{
			parent::__construct($pException);
			$this->strMessage=$pException;
		}	
	}
	function displayMessage()
	{
		echo ($this->strMessage);	
	}
}

?>