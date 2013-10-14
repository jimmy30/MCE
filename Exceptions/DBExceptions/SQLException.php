<?PHP 
class SQLException extends Exception 
{
	var $strMessage="Error in SQL Query syntax";
	
	function __construct($pException)
	{
		if ($pException!="")
		{
			parent::__construct($pException);
			$this->strMessage=$pException;
		}	
		else
		{
			parent::__construct($this->strMessage);
				
		}
	}
	function displayMessage()
	{
		echo ($this->strMessage);	
	}
}

?>