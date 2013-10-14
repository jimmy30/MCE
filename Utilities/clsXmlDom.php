<?php
class clsXmlDom
{
	var $objXmlDom;
	var $strParentNodePath;
	var $strNextNodePath;
	var $strFilePath;
	function __construct()
	{
		$this->objXmlDom = new DomDocument(); 	
	}
	function getParentNodePath()
	{
		return $this->strParentNodePath;
	}
	function setParentNodePath($value)
	{
		$this->strParentNodePath=$value;
	}
	function getNextNodePath()
	{
		return $this->strNextNodePath;
	}
	function setNextNodePath($value)
	{
		$this->strNextNodePath=$value;
	}
	function getFileName()
	{
		return $this->strFilePath;
	}
	function setFileName($value)
	{
		$this->strFilePath=$value;
	}
	function CreateXmlNode()
	{
		
	}
}
?>