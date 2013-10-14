<?php
	if(isset($_GET['skin']))
	{
		$strQuery = $_GET['skin'];	
	}
	else if (isset($_COOKIE['skin']))
	{
		$strQuery=$_COOKIE['skin'];
	}

	if (strcmp($strQuery,'skin1')==0)
	{
		setcookie('skin', "skin1",time()+31536000, "/");
		$strSkin="skin1"; 
		$strColor="#044c9a";
		echo("<script language='javascript'> var strSkin='skin1';var strMainMenuColor='#044c9a';var strSubMenuColor='#044c9a';</script>");
	}
	
	else if (strcmp($strQuery,'skin2')==0)
	{

		setcookie('skin', "skin2",time()+31536000, "/");
		$strSkin="skin2"; 
		$strColor="#3b3525";
		echo("<script language='javascript'> var strSkin='skin2';var strMainMenuColor='#044c9a';var strSubMenuColor='#044c9a';</script>");
	}
	
	else if (strcmp($strQuery,'skin3')==0)
	{
		setcookie('skin', "skin3",time()+31536000, "/");
		$strSkin="skin3"; 
		$strColor="#004627";
		echo("<script language='javascript'> var strSkin='skin3';var strMainMenuColor='#ffffff';var strSubMenuColor='#004627';</script>");
	}
	
	else if (strcmp($strQuery,'skin4')==0)
	{
		setcookie('skin', "skin4",time()+31536000, "/");
		$strSkin="skin4"; 
		$strColor="#ffcf25";
		echo("<script language='javascript'> var strSkin='skin4';var strMainMenuColor='#ffffff';var strSubMenuColor='#64001a';</script>");
	}
	else if (strcmp($strQuery,'skin5')==0)
	{
		setcookie('skin', "skin5",time()+31536000, "/");
		$strSkin="skin5"; 
		$strColor="#083a8f";
		echo("<script language='javascript'> var strSkin='skin5';var strMainMenuColor='#ffffff';var strSubMenuColor='#083a8f';</script>");
	}
	
	else
	{
		setcookie('skin', "skin1",time()+31536000, "/");
		$strSkin="skin1"; 
		$strColor="#044c9a";
		echo("<script language='javascript'> var strSkin='skin1';var strMainMenuColor='#044c9a';var strSubMenuColor='#044c9a';</script>");
	
	}
?>