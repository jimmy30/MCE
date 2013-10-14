<?php
//include_once("config.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
/**
 * Database class for handling database connections.
 * 
 * @author Khurrum Dawood
 * @version 22 Oct 2006
 */

class Database 
{
		//// Declaring DB connection and objects and privateiables
		var $strDbHost;
		var $strDbUser;
		var $strDbPassword;
		var $strDbName;	
		/// Declaring Error handling privateiables
		var $mysqli;
		var $mysql;
		var $useMysqli;	
		var $insertId;
		var $affectedRows;
		var $errorMessage;
		var $errorNumber; //1451 for editing parent key used as foreign key, 1062 for insert duplicate key
	
	function ping()
	{
		$errorMessage = "";
		if($this->useMysqli)
		{
			return true;								
		}
		return false;								

	}
	function __construct()
	{
		//echo "<br>constructor called";
		$this->useMysqli = 1;
		$this->mysqli = null;
		$this->mysql = null;
		$this->open();

	}
	 public static function singleton() 
    {
        if (!isset($mysqli)) {
            $c = __CLASS__;
            $mysqli= new $c;
        }

        return $mysqli;
    }
/*	function Database()
	{
		$this->mysqli = $this->singleton();
	}*/
	
	private function getrowscount($result)
	{
			return $result->num_rows;
	}
	function geterrormessage()
	{
			return	$this->mysqli->error;
	}
	function geterrornumber()
	{
			return	$this->mysqli->errno;
	}
	function executeQuery($query)
	{
			return $this->mysqli->query($query);
	}
	function executeQueryWithLink($query)
	{
			return $this->mysqli->query($query);
	}

	function getResultSet($query)
	{		
		if($this->ping())
		{
			if($result = $this->executeQuery($query))
			{
				$arr = null;
				$arr = $this->fetcharray($result);
				return $arr;
			}
		}
		else
		{
			$this->errorMessage = $this->geterrormessage();
		}
		return null;
	}
	function executePrepare($query)
	{
		if($this->ping())
			return $this->mysqli->prepare($query);
		else
			return $this->errorMessage;
	}
	
	function executeProcedure($query,$type,$objParam)
	{
		$query=$query.$this->getQuery($type,$objParam);
	
		$stmt=$this->executePrepare($query);
	    $stmt->execute();
		$stmt->close();
	
	}
	function getQuery($type,$objParam)
	{
		$i=0;
		$strStart="(";
		$str="";
		foreach ($objParam as $val){
			if($i==0) $str=$this->getVal($type,$val,$i);
			else $str=$str.",".$this->getVal($type,$val,$i);
			$i++;
		}
		$strEnd=$strStart.$str.")";
		return $strEnd;
	}
	function getVal($type,$val,$index)
	{
		if($type[$index]=='i') return $val;
		else	return "'".$val."'";
	}
	function getResultSetWithCount($query,&$count)
	{		
	if($this->ping())
		{
			if($result = $this->executeQuery($query))
			{
				$count = $this->getrowscount($result);
				$arr = null;
				$i = 0;
				while($obj = $this->fetchobject($result))
				{					
					$arr[$i] = $obj;
					$i++;
				}
				return $arr;
			}
		}
		else
		{
			$this->errorMessage = $this->geterrormessage();
		}
		return null;
	}
	private function fetchobject($result)
	{
			return mysqli_fetch_object($result);
	}
	
	function getSingleRow($query)
	{	
		if($this->ping())
		{
			
			if($result = $this->executeQuery($query))
			{
				if($row = $this->fetchobject($result))
				{
					return $row;
				}
			}
		}
		else
		{
			$this->errorMessage = $this->geterrormessage();
		}
		return null;
	}
	private function fetcharray($result)
	{
			return mysqli_fetch_array($result, MYSQL_NUM); 
	}
	function getSingleValue($query)
	{
		$value = null;
		if($this->ping())
		{
			$result = $this->executeQuery($query);
			if(! $result)
				return null;
			$row = $this->fetcharray($result);
			$value = $row[0];
			$this->errorMessage = "";
		}
		else
		{
			$this->errorMessage = $this->geterrormessage();
		}
		return $value;
	}
	private function getinsertid()
	{
			return $this->mysqli->insert_id;
	}
	function insertquery($query)
	{
		if($this->ping())
		{
			if(!$this->executeQuery($query))
			{
				$this->errorNumber = $this->geterrornumber();
				return $this->geterrormessage();				
			}
			$this->insertId = $this->getinsertid();
			$this->errorMessage = "";
		}
		else
		{
			$this->errorMessage = $this->geterrormessage();
		}
		
		return $this->geterrormessage();
	}
	function insert($query)
	{
		if($this->ping())
		{
			if(! $result = $this->executeQuery($query))
			{
				$this->errorNumber = $this->geterrornumber();
				if($this->errorNumber == 1062)
				{
					$this->errorMessage = "is unique.";
				}
			}
			else
			{
				$this->insertId = $this->getinsertid();
			}
		}
		$this->errorMessage = $this->geterrormessage();
				
		return $result;
	}
	
	
	private function getaffectedrowscount()
	{
		return $this->mysqli->affected_rows;
	}
	function update($query)
	{
		if($this->ping())
		{
			if($result = $this->executeQuery($query))
			{				
				$this->affectedRows = $this->getaffectedrowscount();
				$this->errorMessage = "";
			}
			else
			{			
				$this->errorMessage = $this->geterrormessage();
				$this->errorNumber = $this->geterrornumber();
				if($this->errorNumber == 1451)
				{
					$this->errorMessage = "This record can not be deleted as it is being referred in some other record(s).";
				}
				
				if($this->errorNumber == 1062)
				{
					$this->errorMessage = "already exists.";
				}
			}
		}
		else
		{
			$this->errorMessage = $this->$this->geterrormessage();
			$this->errorNumber = $this->geterrornumber();
		}
		
		return $result;
	}
	function open()
	{
			$this->openmysqli();
	}
	private function openmysqli()
	{
		$objProperties=new Properties();
		$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
			
		$this->strDbHost = $objProperties->getProperty('db_host');
		$this->strDbUser=$objProperties->getProperty('db_username');
		$this->strDbPassword = $objProperties->getProperty('db_password');
		$this->strDbName=$objProperties->getProperty('db_dbname');

		$this->mysqli = new mysqli($this->strDbHost,$this->strDbUser,$this->strDbPassword ,$this->strDbName);
		/* check connection */ 
		if (!$this->mysqli)
		{
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
	function startTransaction($condition)
	{
			$this->mysqli->autocommit($condition);
	}
	function commitTransaction()
	{
			if ($this->ping()) 
			{
				$this->mysqli->commit();
			}
	}
	function rollBackTransaction()
	{
			if ($this->ping()) 
			{
				$this->mysqli->rollback();
			}
	}
	function close()
	{
			$this->mysqli->close();
	}
	function __destruct()
	{
//			echo "<br> destructor called";
			$this->close();
	}
}
?>