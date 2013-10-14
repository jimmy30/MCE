<?PHP 
class NoRecordFoundExecption extends Exception 
{
	var $strMessage="No Record Found";
	
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