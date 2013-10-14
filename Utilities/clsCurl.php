<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utilities.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/Utilities/htmlparser.inc");
class clsCurl
{
	var $strUrl;
	var $objCurl;
	var $strInfo;
	var $strContentType;
	var $objFile;
	var $strExtenshion;
	var $strFileUrl;
	var $strFileName;
	var $strHtmlFileName;
	var $strDirectoryName;
	var $strError;
	var $strErrorNo;
	var $strDirectoryPath;
	var $strXmlFileDirectoryPath;
	var $strXmlFileName;
	var $strPlaceCastDirectoryPath;
	var $strWaypointDirectoryPath;
	var $strWaypointIdDirectoryPath;
	var $strContentFilesDirectory;
	var $strTempFilesDirectory;
	var $strAudioDirectory;
	var $strVideoDirectory;
	var $strImagesDirectory;
	var $strTextDirectory;
	var $strXmlPlaceCastPath;
	var $strTempTempFileName;
	var $strOldFileName;
	var $strMultimediaDirector;
	var $strTempFileName;
	var $strTempDir;
	var $intTimeOut;
	var $strOldUrl;
	var	$dblFileSize=0;
	var	$dblFileTime=0;
	var $dblImgeFileSize=0;
	var $dblImgeFileSizes=0;
	var $dblLinkFileSize=0;
	var $dblLinkFileSizes=0;
	var $dblLinkFileTime=0;
	var $dblModemSpeed=0;
	var $strSiteUrl;
	var $blnInd=0;
	var $intFileStatus;
	var $intFileNameCounter=0;
	var $arrFilePath;
	var $arrFilePathName;
	var $arrConvertionFileExt;
	var $arrPath;
	var $intFileCounter=0;
	var $strCodecPath;
	var $strFileConvertionExt;
	var $strScreenSize;
	var $strFormatConvertion;
	var $strFileConSetting;
	var $intPlaceCastFolderId;
	var $arrExtenshion=array('.zip'=>'application/zip',
					 '.wmv'=>'video/x-ms-wmv',
					 '.txt'=>'text/plain; charset=iso-8859-1',
					 '.html'=>'text/html; charset=iso-8859-1',
					 '.html'=>'text/html',
					 '.ps'=>'application/postscript',
					 '.jpg'=>'image/jpeg',
					 '.png'=>'image/png',
					 '.exe'=>'application/octet-stream',
					 '.doc'=>'application/msword',
					 '.pdf'=>'application/pdf',
					 '.mp3'=>'audio/mpeg',
					 '.rm'=>'audio/x-pn-realaudio',
					 '.avi'=>'video/x-msvideo',
					 '.mpg'=>'video/mpeg',
 					 '.xml'=>'text/xml',
					 '.gif'=>'image/gif'
 );
	var $arrExtenshionName;
	//=array(".wmv",".jpg",".png",".pdf",".mp3",".rm",".avi",".mpg",".doc");
	var $arrAudioExtension=array(".mp3",".rm");
	var $arrVideoExtension=array(".wmv",".avi",".mpg");
	var $arrMultimediaExtension;
	var $arrFileExtension;
	//=array(".wmv",".mp3",".rm",".avi",".mpg");
	function clsCurlInit()
	{
		// Set properties.
		$this->setProperties();

	}
	/*******************************************************************************************************************
	Name				: getUrl()
	Description			: 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/
	function getUrl()
	{
		return $this->strUrl;
	}
	
	/*******************************************************************************************************************
	Name				: setUrl()
	Description			: 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/
	function setUrl($value)
	{
		$this->strUrl=urldecode($value);
		$this->strOldUrl=$this->strUrl;
		$strHttp=explode("/",$this->strUrl);
		if($strHttp[0]!="http:")
		{
			$this->blnInd=1;
			$this->strUrl=$this->strSiteUrl.$this->strUrl;
		}
		
	}
	/*******************************************************************************************************************
	Name				: getContentType()
	Description			: Get all file information using curl and return file content type.
	Input Parameters	: 
	Returns				: return file content type
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/

	function getContentType()
	{
		 // initialize curl object
		$this->objCurl= curl_init(); 
		// Set Url
		curl_setopt($this->objCurl, CURLOPT_URL,$this->getUrl());
		curl_setopt($this->objCurl, CURLOPT_RETURNTRANSFER, 1);
		// Execute  curl command.
		curl_exec($this->objCurl);
		// get Url information eg. file size,extenshion etc.
		$this->strInfo = curl_getinfo($this->objCurl);
		// 
		foreach ($this->strInfo as $key=>$value) 
		{
			// check file content type.
			if ($key=='content_type')
			{
			  	$this->strContentType=$value;
				return $this->strContentType;
			}
		}
		// close curl object.
		$this->close($this->objCurl);
	}
	/*******************************************************************************************************************
	Name				: getContentType()
	Description			: find out file extenshion.
	Input Parameters	: 
	Returns				: return file extenshion
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/

	
	function getFileExtension()
	{

		// find url extenshion eg. www.pakistan.com/abc.wmv return .wmv
		$this->strExtension=substr($this->getUrl(), -4, 4);
		// check extenshion not exists in extenshion Name array.
		if (!in_array($this->strExtension,$this->arrExtenshionName))
		{
			// find url extenshion eg. www.pakistan.com/abc.rm return .rm
			$this->strExtension=substr($this->getUrl(), -3, 3);
			// if not exists in extension array then get content type and find in extenshion array.
			if (!in_array($this->strExtension,$this->arrExtenshionName))
			{
				// find extension using file content type.
				$this->strExtension=array_keys($this->arrExtenshion,$this->getContentType());
				$this->strExtension=$this->strExtension[0];
			}
		}
			
		//set extenshin in lower case.
		$this->strExtension=strtolower($this->strExtension);
		return $this->strExtension;
	}
	
	/*******************************************************************************************************************
	Name				: setFileName()
	Description			: 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/

	function setFileName($pStrFileUrl)
	{
		$this->strFileName=$pStrFileUrl;
	}
	/*******************************************************************************************************************
	Name				: getFileName()
	Description			: Create file name which download.
	Input Parameters	: 
	Returns				: file name 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/
	
	function getFileName($pIntFileNameCounter,$pStrDirectoryPath)
	{
		
		
		$this->strFileName=$pIntFileNameCounter.$this->getFileExtension();
		$this->strTempFileName=$this->strFileName;
		$this->strTempTempFileName=$pStrDirectoryPath."/".$this->strFileName;
		$this->arrFilePath[$this->intFileCounter]=$this->strTempTempFileName;
		return $this->strFileName;
	}
	/*******************************************************************************************************************
	Name				: setDirectoryPath()
	Description			: 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/
	

	function setDirectoryPath($value)
	{	
		$this->strDirectoryName=$value;
	}
	
	/*******************************************************************************************************************
	Name				: getDirectoryPath()
	Description			: 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/
	function getDirectoryPath()
	{
		return $this->strDirectoryName;
	}
	/*******************************************************************************************************************
	Name				: getTimeOut()
	Description			: 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/
	
	function getTimeOut()
	{
		return $this->intTimeOut;
	}
	/*******************************************************************************************************************
	Name				: setTimeOut()
	Description			: 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/
	
	function setTimeOut($value)
	{
		$this->intTimeOut=$value;
	}
	/*******************************************************************************************************************
	Name				: setProperties()
	Description			: get values from property file and assign. 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/

	function setProperties()
	{
		//Property class object
		$objProperties=new Properties();
		//Load property file
		$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT']."/Properties/default.properties"));
		//Get download files directory path
		$this->strDirectoryPath=$_SERVER['DOCUMENT_ROOT']."/".$objProperties->getProperty('curl_download_directory_path');
		//return $this->strDirectoryPath;
		//Get html file name
		$this->strHtmlFileName = $this->strDirectoryPath."/".$objProperties->getProperty('curl_html_file_name');
		//Get xml file name.
		$this->strXmlFileName=$this->strDirectoryPath."/".$objProperties->getProperty('curl_xml_file_name');
		//Get curl command execution time
		$this->intTimeOut=$objProperties->getProperty('curl_time_out');
		//Get modem speed.
		$this->dblModemSpeed=$objProperties->getProperty('curl_modem_speed');
		// Convert modem speed in to bits 
		$this->dblModemSpeed=$this->dblModemSpeed*1000;
		// Get watypoint directory path
		$this->strWaypointDirectoryPath=$_SERVER['DOCUMENT_ROOT']."/".$objProperties->getProperty('waypoint_content_directory');
		$this->strXmlFileDirectoryPath=$objProperties->getProperty('waypoint_content_directory');
		//$this->strTempDir=$objProperties->getProperty('waypoint_content_directory');		
		$this->strSiteUrl=$objProperties->getProperty('site_url');
		$this->strTempDir=$objProperties->getProperty('waypoint_content_directory');
		
		
		// Load file extension 
		$this->arrExtenshionName=$objProperties->getProperty('curl_file_extension');
		$this->arrExtenshionName = explode(',',$this->arrExtenshionName); 
		
		$this->arrMultimediaExtension=$objProperties->getProperty('curl_multimedia_extension');
		$this->arrMultimediaExtension = explode(',',$this->arrMultimediaExtension); 
		$this->arrFileExtension=$objProperties->getProperty('curl_doc_pdf_files_extension');
		$this->arrFileExtension = explode(',',$this->arrFileExtension); 

		// Codec Properties		
		$this->arrConvertionFileExt=$objProperties->getProperty('file_format_convertion_extension');
		$this->arrConvertionFileExt = explode(',',$this->arrConvertionFileExt); 
		$this->strCodecPath=$objProperties->getProperty('file_format_codec_path');
		$this->strFileConvertionExt=$objProperties->getProperty('file_format_convertion_extension');
		$this->strScreenSize=$objProperties->getProperty('file_format_convertion_screen_size');
		$this->strFormatConvertion=$objProperties->getProperty('file_format_converstion');
		$this->strFileConSetting=$objProperties->getProperty('file_format_converstion_setting');
		
		//$this->setUrl($this->strXmlFileName);
	}
	/*******************************************************************************************************************
	Name				: saveFile()
	Description			: download files using curl and save on given location. 
	Input Parameters	: 
	Returns				: status eg. download complete or not.
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	28-07-2006       1.00
	*********************************************************************************************************************/

	function saveFile($pStrDirectoryPath)
	{
		
		$this->intFileNameCounter++;
		$this->strFileName=$this->getFileName($this->intFileNameCounter,$pStrDirectoryPath);
		$strTempDir="Temp/".$this->intPlaceCastFolderId."/";
		rmdir($strTempDir);
		if (!is_dir($strTempDir))
		{
			
			mkdir($strTempDir,0777,TRUE);
		}
		//$this->strTempFileName=$this->strFileName;
		$this->strFileName=$strTempDir.$this->strTempFileName;	
		$this->arrPath[$this->intFileCounter]=$pStrDirectoryPath;
		$this->arrFilePathName[$this->intFileCounter]=$this->strFileName;
		$this->intFileCounter++;
		
		// check file extenshion exists in array.
		if (in_array($this->strExtension,$this->arrExtenshionName))
		{
			// open file.
			$this->objFile= fopen($this->strFileName, "w+");
			// if file not open then return error.
			if ($this->objFile==false)
			{
				 $this->strError= "File not opened"; 
				 $this->strErrorNo=0;
			}
			else
			{
				// initialize curl object
				$this->objCurl= curl_init(); 
				// set time for execution of this command
				if ($this->dblFileSize>30)
				{
					// set php script exection time
					set_time_limit(0);
					//curl_setopt($this->objCurl, CURLOPT_TIMEOUT,$this->dblFileSize);
				}
				else
				{
					// set php script exection time
					set_time_limit(30);	
				}			
				// set file object
				if ($this->intTimeOut!="" || $this->intTimeOut>0)
				{
					curl_setopt($this->objCurl, CURLOPT_TIMEOUT,$this->intTimeOut);
				}
				
				curl_setopt($this->objCurl, CURLOPT_FILE, $this->objFile); 
				// set header
				curl_setopt($this->objCurl, CURLOPT_HEADER, 0); 
				// set url for download.
				curl_setopt($this->objCurl, CURLOPT_URL, $this->getUrl()); 
				// exectue curl object.
				curl_exec($this->objCurl);
				// if curl error occur set status.
				if (curl_error($this->objCurl))
				{
					 // check curl error.
					 $this->strError=curl_error($this->objCurl); 
					  $this->strErrorNo=0;
					 // close curl object
					 $this->close($this->objCurl);
					// return $this->strError;
				}
				else
				{
					 $this->strErrorNo=1;
					// close file object.
					fclose($this->objFile);
					// close curl object.
					$this->close($this->objCurl);
					// set status.
					$this->strError="File download successfully"; 
					//return $this->strError;
				}
			}
		}	
		else
		{
  		    $this->strErrorNo=0;
			$this->strError="No file information found";
			//return $this->strError;
		}	
		
		return $this->strError;
	}
	/*******************************************************************************************************************
	Name				: getRemoteFilesize()
	Description			: get remote file size. 
	Input Parameters	: username and password optional
	Returns				: file size
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	28-07-2006       1.00
	*********************************************************************************************************************/

	function getRemoteFilesize($user='',$pw='') 
 	{ 
		// initialize curl object.
		$this->objCurl= curl_init(); 
	   // set Url.
	   curl_setopt($this->objCurl, CURLOPT_URL,$this->getUrl());
	   // start output buffering 
	   ob_start(); 
	   // make sure we get the header 
	   curl_setopt($this->objCurl, CURLOPT_HEADER, 1); 
	   // make it a http HEAD request 
	   curl_setopt($this->objCurl, CURLOPT_NOBODY, 1); 
 	  // if auth is needed, do it here 
	   if (!empty($user) && !empty($pw)) 
	   { 
    	   $headers = array('Authorization: Basic ' .  base64_encode($user.':'.$pw)); 
	       curl_setopt($this->objCurl, CURLOPT_HTTPHEADER, $headers); 
	   } 
	   // exectute curl command.
	   $okay = curl_exec($this->objCurl); 
	
   		// get the output buffer 
   		$head = ob_get_contents(); 
   		// clean the output buffer and return to previous 
   		// buffer settings 
   		ob_end_clean(); 
   
	   // gets you the numeric value from the Content-Length 
	   // field in the http header 
	   $regex = '/Content-Length:\s([0-9].+?)\s/'; 
	   $count = preg_match($regex, $head, $matches); 
   
	   // if there was a Content-Length field, its value 
	   // will now be in $matches[1] 
	   if (isset($matches[1])) 
	   { 
		   $intSize = $matches[1]; 
	   } 
	   else 
	   { 
		   // if no size return then set unknown.
		   $intSize = 'unknown'; 
	   } 
	   // close curl object.
	   $this->close($this->objCurl);
	   return $intSize; 
 } 

	/*******************************************************************************************************************
	Name				: makDirectories()
	Description			:  
	Input Parameters	: Folder Id
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	03-08-2006       1.00
	*********************************************************************************************************************/

	function makDirectories($pIntFolderId,$pIntPlaceCastFolderId)
	{

		$this->intPlaceCastFolderId=$pIntPlaceCastFolderId;
		$this->strPlaceCastDirectoryPath=$this->strWaypointDirectoryPath."/".$pIntPlaceCastFolderId;

		if (!is_dir($this->strPlaceCastDirectoryPath))
		{
			
			mkdir($this->strPlaceCastDirectoryPath,0777,TRUE);
		}
		

		$this->strPlaceCastDirectoryPath=$this->strPlaceCastDirectoryPath."/"."Waypoints";
				
		
		if (!is_dir($this->strPlaceCastDirectoryPath))
		{

			mkdir($this->strPlaceCastDirectoryPath,0777,TRUE);
		}
		
		$this->strWaypointIdDirectoryPath=$this->strPlaceCastDirectoryPath."/".$pIntFolderId;
		if(is_dir($this->strWaypointIdDirectoryPath))
		{
			
			//RemoveFiles($this->strWaypointIdDirectoryPath);

		}
		
		$this->strTempDir=$this->strTempDir."/".$pIntFolderId;		
		
		
		if (!is_dir($this->strWaypointIdDirectoryPath))
		{
			mkdir($this->strWaypointIdDirectoryPath,0777,TRUE);
		}	
		
		
		$this->strHtmlFileName=$this->strWaypointIdDirectoryPath."/".$pIntFolderId.".html";
		$this->strContentFilesDirectory=$this->strWaypointIdDirectoryPath."/".clsConstants::Content_Directory;
		
		
		if (!is_dir($this->strContentFilesDirectory))
		{
			mkdir($this->strContentFilesDirectory,0777,TRUE);
		}	
		$this->strTempFilesDirectory=$this->strWaypointIdDirectoryPath."/"."TempFiles/";
		
		if (!is_dir($this->strTempFilesDirectory))
		{
			mkdir($this->strTempFilesDirectory,0777,TRUE);
		}	
		$this->strXmlFileName=$this->strTempFilesDirectory."/".$pIntFolderId.".xml";
		
		$this->strImagesDirectory=$this->strContentFilesDirectory."/".clsConstants::Images_Content_Directory;
		
		
		$this->strTempDir=clsConstants::Content_Directory."/".clsConstants::Images_Content_Directory;

		if (!is_dir($this->strImagesDirectory))
		{
			
		
			mkdir($this->strImagesDirectory,0777,TRUE);
			
		}		
		
		$this->strTextDirectory=$this->strContentFilesDirectory."/".clsConstants::Text_Content_Directory;
		
		if (!is_dir($this->strTextDirectory))
		{
			mkdir($this->strTextDirectory,0777,TRUE);
		}		
		
		
		$this->strMultimediaDirectory=$this->strContentFilesDirectory."/".clsConstants::Multimedia_Content_Directory;

		if (!is_dir($this->strMultimediaDirectory))
		{
			mkdir($this->strMultimediaDirectory,0777,TRUE);
		}
		
		/*
		$this->strAudioDirectory=$this->strContentFilesDirectory."Audio";
		mkdir($this->strAudioDirectory,0777,TRUE);
		$this->strVideoDirectory=$this->strContentFilesDirectory."Video";;
		mkdir($this->strVideoDirectory,0777,TRUE);
		*/
	}
	
	function CreatePlaceCastXmlFile($pIntPlaceCastId,$pIntWayPointId,$pStrFilePath,$strWaypointName,$pStrLongitude,$pStrWaypointLatitude)
	{
	

	
		
		//$this->strWaypointDirectoryPath;
		//$_SERVER['DOCUMENT_ROOT']."/".$objProperties->getProperty('waypoint_content_directory');
		//$this->strXmlFileDirectoryPath
		$strFilePath=$_SERVER['DOCUMENT_ROOT'].'/'.$pStrFilePath.'/'.$pIntPlaceCastId.'/';

		$xml_src = $strFilePath.'placecast.xml'; 
		if (!file_exists($xml_src))
		{
			$strXml='<?xml version="1.0" ?> 
					<Contents></Contents>';
			$objFile=fopen($xml_src,w);
			fwrite($objFile,$strXml);
			fclose($objFile);
		}
		//return $xml_src;
		// XPath-Querys 
		$parent_path = "//Contents"; 
		$next_path = "//Contents/Content[ID='2']"; 
		$length_path="//Content";
		// Create a new DOM document 
		$dom = new DomDocument(); 
		$dom->load($xml_src); 
 
		// Find the parent node 
		$xpath = new DomXPath($dom); 
		 
		// Find parent node 
		$parent = $xpath->query($parent_path); 
		
		// new node will be inserted before this node 
		
		$next = $xpath->query($next_path); 

		$length = $xpath->query($length_path); 
		$size = $length->length;
		//return $size;
		$status="no";	
		for($i=0;$i<$size;$i++)
		{
			$content = $dom->getElementsByTagName('Content')->item($i);
			$contentId=$content->getAttribute('ID');
			if($contentId==$pIntWayPointId)
			{
				$status="yes";
				return $status;
			}
			
		}	
		if ($status="no")
		{
				$element = $dom->createElement('Content'); 
				$element->setAttribute("ID", $pIntWayPointId);
				
				$name=$dom->createElement('Name'); 
				$name = $element->appendChild($name);
				
				$text = $dom->createTextNode($strWaypointName);
				$text = $name->appendChild($text);
				
				$link=$dom->createElement('Link'); 
				$link = $element->appendChild($link);
				
				$linkValue=$pStrFilePath.'/'.$pIntPlaceCastId.'/Waypoints/'.$pIntWayPointId.'/'.$pIntWayPointId.".html";

				$text = $dom->createTextNode($linkValue);
				$text = $link->appendChild($text);
				
				
				$longitude=$dom->createElement('Longitude'); 
				$longitude = $element->appendChild($longitude);
				
				$textlongitude = $dom->createTextNode($pStrLongitude);
				$textlongitude = $longitude->appendChild($textlongitude);
				
				
				$Latitude=$dom->createElement('Latitude'); 
				$Latitude = $element->appendChild($Latitude);
				
				$textLatitude = $dom->createTextNode($pStrWaypointLatitude);
				$textlLatitude= $Latitude->appendChild($textLatitude);
				 
				 
				// Insert the new element 
				$parent->item(0)->insertBefore($element, $next->item(0)); 
			
				//echo $dom->saveXML(); 
				$dom->save($xml_src);
				
		}
		
	}
	
 
		/*******************************************************************************************************************
	Name				: downLoadFile()
	Description			: parse html and find audio,video and image links information
	Input Parameters	: html string
	Returns				: status.
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	28-07-2006       1.00
	*********************************************************************************************************************/

	function downLoadFile($pStrHtml,$pIntFolderId,$pIntPlaceCastFolderId,$pStrWaypointName,$pStrLongitude,$pStrWaypointLatitude)
	{
			
		


		$this->clsCurlInit();
		
		

		$this-> makDirectories($pIntFolderId,$pIntPlaceCastFolderId);


		// call parse html string function.
		$parser = HtmlParser_ForString ($pStrHtml);
		
		
		//return $this->strHtmlFileName;
		//return $this->strHtmlFileName;
		//Open files in writing mode.

		$objNewFile= fopen($this->strHtmlFileName, 'w');
		$objXmlFile= fopen($this->strXmlFileName, 'w');
		//return $pStrHtml;		
		//$strHtml="<html>";
	    $strXml="<DownloadFiles>";		

		//Call parse function for check tags name and his attributes name
    	while ($parser->parse()) 
		{
			
			//return $parser->iNodeName;	
			// check if tag name image or hyperlink
		   if ($parser->iNodeName!="<img>") 
		   {
		   		
				$strHtml=$strHtml.$parser->iNodeName.$parser->iNodeValue;
				
		   }
		   
		   if ($parser->iNodeName=="<img>" || $parser->iNodeName=="<a>")
		   {
					
				//$strHtml=$strHtml.$parser->iNodeValue;
				
        		if ($parser->iNodeType == NODE_TYPE_ELEMENT) 
				{
					// assign attribute name value.
					$attrValues = $parser->iNodeAttributes;
					
					//assign attribute name.
	                $attrNames = array_keys($attrValues);
					
					// get size of the attribute
    	            $size = count($attrNames);
        	        
					for ($i = 0; $i < $size; $i++) 
					{
						 							
                        $name = $attrNames[$i];
						// check if attribute name height.
						if($attrNames[$i]=="height")
						{
							$height=$attrValues[$name];
						}
						// check if attribute name width.
						if($attrNames[$i]=="width")
						{
							$width=$attrValues[$name];
						}	
						// check if attribute name alt.
						if($attrNames[$i]=="alt")
						{
							$alt=$attrValues[$name];
						}	
						if($attrNames[$i]=="style")
						{
							$style=$attrValues[$name];
						}	
						// check if attribute name src.		
						if($attrNames[$i]=="src")
						{
			
							if ($attrValues[$name]!=clsConstants::Image_File_Path)
							{
								// assign attribute value to setUrl function.
								$this->setUrl($attrValues[$name]);
								
								// set directory path where files to be download.
								$this->setDirectoryPath($this->strDirectoryPath);
								
								// get file size
								$this->dblFileSize=$this->getRemoteFilesize();
								// xml string
								$strXml=$strXml."<Image>";
								
								$strXml=$strXml."<FileSize>".$this->dblFileSize."</FileSize>";
								
								// if file size no return then return unknown if unknown return then size assign 0.
								if ($this->dblFileSize=="unknown")
								{
									$this->dblFileSize=0;
								}	
							
								// (filesize*8)/modem using this formula find esitmated download time.
								$this->dblFileTime=($this->dblFileSize*8)/($this->dblModemSpeed);
								
								// round this time value.
								$this->dblFileTime=round($this->dblFileTime);
								
								// set php script exection time
								//set_time_limit($this->dblFileSize);
								
								// To Do......
								// call saveFile function.
								
								
								$strStatus=$this->saveFile($this->strImagesDirectory);
								//return $strStatus;
								// create xml string.
								
								$strTempFileName=$this->strContentFilesDirectory."/".clsConstants::Images_Content_Directory."/".$this->strFileName;
								//$strXml=$strXml."<ImageUrl>".$this->getUrl()."</ImageUrl>";

								$strXml=$strXml."<ImageUrl>".$this->getUrl()."</ImageUrl>";
								$strXml=$strXml."<DownloadStatus>". $this->strErrorNo."</DownloadStatus>";
								$strXml=$strXml."<DownloadStatusDescription>".$strStatus."</DownloadStatusDescription>";
								$strXml=$strXml."<FileName>".$this->strFileName."</FileName>";

								$strXml=$strXml."<DownloadLocation>".$this->strDirectoryName."</DownloadLocation>";
								$strXml=$strXml."<DownloadMessage></DownloadMessage>";
								$strXml=$strXml."</Image>";
								
								//open test.html file in append mode.
								//$objNewFile= fopen($this->strHtmlFileName, 'a');
								
								// To do......................................
								$strContentsImages=clsConstants::Content_Directory."/".clsConstants::Images_Content_Directory."/";
								
								$strContentsImages=$this->strSiteUrl.'/Contents/PlaceCasts/'.$pIntPlaceCastFolderId.'/Waypoints/'.$pIntFolderId.'/'.$strContentsImages;
								if ($this->blnInd==0)
								{
									$strHtml=$strHtml."<img src=\"".$strContentsImages.$this->strTempFileName."\" height=".$height." width=".$width." alt=\"".$alt."\" style=\"".$style."\">";		
								}
								else
								{
									$strHtml=$strHtml."<img src=\"".$strContentsImages.$this->strTempFileName."\" height=".$height." width=".$width." alt=\"".$alt."\" style=\"".$style."\">";		

								}	
								
							}
							else
							{
								// set directory path where files to be download.
								$this->setDirectoryPath($this->strDirectoryPath);

								$strXml=$strXml."<Image>";
								$strXml=$strXml."<ImageUrl>".clsConstants::Image_File_Path."</ImageUrl>";
								$strXml=$strXml."<FileSize>0</FileSize>";
								$strXml=$strXml."<DownloadStatus>".$this->strErrorNo."</DownloadStatus>";
								$strXml=$strXml."<DownloadStatusDescription>".$strStatus."</DownloadStatusDescription>";
								$strXml=$strXml."<FileName>Audio.jpg</FileName>";
								$strXml=$strXml."<DownloadLocation>".$this->strDirectoryName."</DownloadLocation>";
								$strXml=$strXml."<DownloadMessage></DownloadMessage>";
								$strXml=$strXml."</Image>";							
							}	
						}
						// check href attribute.
						if($attrNames[$i]=="href")
						{
							
							// attribute value to setUrl function.
							$this->setUrl($attrValues[$name]);
							
							$strXml=$strXml."<Url>".$this->getUrl()."</Url>";
							
							// set directory path where files to be download.
							$this->setDirectoryPath($this->strDirectoryPath);
							
							// get remote file size.
							$this->dblFileSize=$this->getRemoteFilesize();
							
							// if file size return unkown then assign 0.
							if ($this->dblFileSize=="unknown")
							{
								$this->dblFileSize=0;
							}	
							
							// calculate estimated file download time.
						    $this->dblFileTime=($this->dblFileSize*8)/($this->dblModemSpeed);
							
							// round file time.
							$this->dblFileTime=round($this->dblFileTime);
							
						    // return $this->dblFileSize;

							if (in_array($this->getFileExtension(),$this->arrMultimediaExtension))
							{
								$strStatus=$this->saveFile($this->strMultimediaDirectory);
								$strContentsMultimedia=clsConstants::Content_Directory."/".clsConstants::Multimedia_Content_Directory."/";
								
								$strContentsMultimedia=$this->strSiteUrl.'/Contents/PlaceCasts/'.$pIntPlaceCastFolderId.'/Waypoints/'.$pIntFolderId.'/'.$strContentsMultimedia;
								
								$this->strTempFileName=explode(".",$this->strTempFileName);
								$strExt=".".$this->strTempFileName[1];
								//$objTestFile=fopen("testpathaa.txt",'w');
								//fwrite($objTestFile,$strExt);	
								//fclose($objTestFile);		
								if(in_array($strExt,$this->arrConvertionFileExt))
								{
									$this->strTempFileName=$this->strTempFileName[0].".".$this->strFormatConvertion;
									$strContentsMultimedia=explode("http:",$strContentsMultimedia);
									$strContentsMultimedia="rtsp:".$strContentsMultimedia[1];
								}	
								if ($this->blnInd==0)
								{
									$strHtml=$strHtml."<a href=\"".$strContentsMultimedia.$this->strTempFileName."\">".$parser->iNodeValue;		
								}
								else
								{
									$strHtml=$strHtml."<a href=\"".$strContentsMultimedia.$this->strTempFileName."\">".$parser->iNodeValue;		
								}	
							}
							
							
							else if(in_array($this->getFileExtension(),$this->arrFileExtension))
							{
								// To Do....
								$strStatus=$this->saveFile($this->strTextDirectory);
								$strContentsText=clsConstants::Content_Directory."/".clsConstants::Text_Content_Directory."/";
								
								if ($this->blnInd==0)
								{
									$strHtml=$strHtml."<a href=\"".$strContentsText.$this->strTempFileName."\">".$parser->iNodeValue;		
								}
								else
								{
									$strHtml=$strHtml."<a href=\"".$strContentsText.$this->strTempFileName."\">".$parser->iNodeValue;		
								}	
							}
							else
							{
								$strHtml=$strHtml."<a href=\"".$this->getUrl()."\">".$parser->iNodeValue;		
								$strMessage="Not Supported";
							}
							// call save file function and return status.
							
						
							// make xml string.
							$strXml=$strXml."<FileName>".$this->strFileName."</FileName>";
							$strXml=$strXml."<FileSize>".$this->dblFileSize."</FileSize>";
							$strXml=$strXml."<DownloadLocation>".$this->strDirectoryName."</DownloadLocation>";
							$strXml=$strXml."<DownloadStatus>". $this->strErrorNo."</DownloadStatus>";
							$strXml=$strXml."<DownloadStatusDescription>".$strStatus."</DownloadStatusDescription>";
							$strXml=$strXml."<DownloadMessage>".$strMessage."</DownloadMessage>";
							//set_time_limit($this->dblLinkFileTime);
						
						
						}
                	}
	       		}
			
		   }
		
 	   }
			
			//	$strHtml=$strHtml."</html>";		
				
				// write data on html file.
				fwrite($objNewFile,$strHtml);
				
				// close file object.
				fclose($objNewFile);	
				
				$strXml=$strXml."</DownloadFiles>";		
				
				// write data in xml file.
				fwrite($objXmlFile,$strXml);
				
				// close file object.
				fclose($objXmlFile);	
					//	return $pStrWaypointName;
				// call CreatePlaceCastXmlFile

				$test=$this->CreatePlaceCastXmlFile($pIntPlaceCastFolderId,$pIntFolderId,$this->strXmlFileDirectoryPath,$pStrWaypointName,$pStrLongitude,$pStrWaypointLatitude);
				
				$this->RemoveFiles();
				/*for($j=0;$j<count($this->arrPath);$j++)	
				{
					FilesRemove($this->arrPath[$j]);
				}*/
				$objTestFile= fopen('testfilepath.txt', 'a+');
				for($k=0;$k<count($this->arrFilePath);$k++)
				{
					$strNewUrl=explode(".",$this->arrFilePath[$k]);
					$strExt=".".$strNewUrl[1];
					//fwrite($objTestFile,$strExt);
					
					if(in_array($strExt,$this->arrConvertionFileExt))
					{
						$strNewUrl=explode(".",$this->arrFilePath[$k]);
						$strNewUrl=$strNewUrl[0].".".$this->strFormatConvertion;
						$command=$this->strCodecPath." -i ".$this->arrFilePathName[$k]." -s ".$this->strScreenSize." -vcodec wmv1 -acodec ".$this->strFileConSetting." -ar  44100 -ab 128 ".$strNewUrl;
						echo exec($command);
						//fwrite($objTestFile,$strNewUrl);
					}
					else
					{			
						copy($this->arrFilePathName[$k],$this->arrFilePath[$k]);
					}	
			
					unlink($this->arrFilePathName[$k]);
				}
				fclose($objTestFile);
				// call downloadReport function
				$strStatus=$this->downLoadReport();
				return $strStatus;


	}
	function RemoveFiles()
	{
		$strRemoveFilesPath=$this->arrPath[0];	
		$strRemoveFilesPath= explode("ContentFiles/", $strRemoveFilesPath);
		
		if ($strRemoveFilesPath[1]=='Images')
		{
			$strRemoveFilesImagePath=$this->arrPath[0];
			
			$strRemoveFilesMultiMediaPath=$strRemoveFilesPath[0].'ContentFiles/Multimedia';
			
			$strRemoveFilesTextPath=explode("ContentFiles/", $strRemoveFilesPath);
			$strRemoveFilesTextPath=$strRemoveFilesPath[0].'ContentFiles/Text';
		}
		else if($strRemoveFilesPath[1]=='Multimedia')
		{
			$strRemoveFilesMultiMediaPath=$this->arrPath[0];	
	
			$strRemoveFilesImagePath=$strRemoveFilesPath[0].'ContentFiles/Images';
			
			$strRemoveFilesTextPath=explode("ContentFiles/", $strRemoveFilesPath);
			$strRemoveFilesTextPath=$strRemoveFilesPath[0].'ContentFiles/Text';
		}
		
		else if($strRemoveFilesImagePath[1]=='Text')
		{
			$strRemoveFilesTextPath=$this->arrPath[0];	
			
			$strRemoveFilesImagePath=$strRemoveFilesImagePath[0].'ContentFiles/Images';
			
			$strRemoveFilesMultiMediaPath=explode("ContentFiles/", $strRemoveFilesImagePath);
			$strRemoveFilesMultiMediaPath=$strRemoveFilesImagePath[0].'ContentFiles/Multimedia';
			
		}
		$arrRemovePath[0]=$strRemoveFilesImagePath;
		$arrRemovePath[1]=$strRemoveFilesMultiMediaPath;
		$arrRemovePath[2]=$strRemoveFilesTextPath;			
			
			
		for($j=0;$j<count($arrRemovePath);$j++)	
		{
		//	$objTest=fopen('path.txt','a+');
		//	fwrite($objTest,$arrRemovePath[$j]);
		//	fclose($objTest);	
			FilesRemove($arrRemovePath[$j]);
		}
	}

	/*******************************************************************************************************************
	Name				: close()
	Description			: close curl object.
	Input Parameters	: curl object
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	28-07-2006       1.00
	*********************************************************************************************************************/

	
	function close($pObjCurl)
	{
		curl_close($pObjCurl);
	}
	/*******************************************************************************************************************
	Name				: downLoadReport()
	Description			: parse xml file and generate downloaded file report.
	Input Parameters	: html string.
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            working     -----------    	1-08-2006       1.00
	*********************************************************************************************************************/

	function downLoadReport()
	{
	
	
	
		//$strHtml="<table border=1>";
		// load xml file for parsing.
		$strXml=simplexml_load_file($this->strXmlFileName); 
		$strHtml="<table border='0' cellpadding='0' cellspacing='0' width='780' height='430'>
				 <tr class='RegistrationCellBg'><td height='33' colspan='5' class='RegistrationTitleText' >&nbsp;&nbsp;Contents Download Report</td></tr>";
				 
		if($strXml)
		{

		$strHtml=$strHtml."<tr><td height='99' colspan='5'>";
		$strHtml=$strHtml."<table border='0' align='left' cellpadding='0' cellspacing='0'>";
		$strHtml=$strHtml."<tr>";
        $strHtml=$strHtml."<td width='11%'>&nbsp;</td>";
        $strHtml=$strHtml."<td height='26'><span class='GPSTaggingBodyText'><strong>Legend</strong></span></td>";
	    $strHtml=$strHtml."</tr>";
	    $strHtml=$strHtml."<tr>";
		$strHtml=$strHtml."<td>&nbsp;</td>";
        $strHtml=$strHtml."<td><p class='GPSTaggingBodyText'><strong></strong><span class='LinkSmall'><img src='ImageFiles/common/done.gif' width='18' height='17' align='absmiddle'></span> Successfully Downloaded<br>";
        $strHtml=$strHtml."<span class='LinkSmall'><img src='ImageFiles/common/error.gif' width='18' height='17' align='absmiddle'></span> Unable to download</p>";
        $strHtml=$strHtml."</td>";
	    $strHtml=$strHtml."</tr>";
	    $strHtml=$strHtml."</table>";
	    $strHtml=$strHtml."</td>";
		$strHtml=$strHtml." <tr>";

			$strHtml=$strHtml."<td height='21'>";
			$strHtml=$strHtml."<div style='width:780px;height:360px;overflow-y:scroll;overflow:- moz-scrollbars-vertical'>";
			$strHtml=$strHtml."<table width='100%' cellspacing='0' cellpadding='0' border='1' bordercolor='#FFFFFF'>";
			$strHtml=$strHtml."<tr>";

			$intCounter=1;
			$strStatus="";
			foreach($strXml as $strFile=>$strFileValue) 
			{
				
				if ($strFile=="Url")
				{
					$strStatus="yes";
					$strUrl=$strFileValue;
				}
				if ($strFile=="DownloadStatus")
				{
					
					if ($strStatus!="")
					{
						$strUrlStatus=$strFileValue;
					}
					else
					{
						$strDownLoadUrlStatus=$strFileValue;
					}
				}
				if($strFile=="DownloadMessage")
				{
					$strMessage=$strFileValue;
				}
				
				foreach($strFileValue as $strImage=>$strValue) 
					{
						
						if ($strImage=="DownloadStatus")
						{
							$strDownLoadStatus=$strValue;
						
						}
					}	
				if ($strFile=="Image")
				{
	
					foreach($strFileValue as $strImage=>$strValue) 
					{
						
						if ($strImage=="ImageUrl")
						{
						
							if($strStatus=="")
							{
							
								//$strHtml=$strHtml."<td align='center' width=175 height=150><img src=".$strValue." width=100 height=100><br><a href=".$strValue.">Detail</a></td>";
								$strHtml=$strHtml."<td><table width='100%' height='174'  border='0' cellpadding='0' cellspacing='0'>";
								$strHtml=$strHtml."<tr>";
				        	  	$strHtml=$strHtml.'<td align="center" valign="middle">&nbsp;</td>';
							    $strHtml=$strHtml.'</tr>';
								$strHtml=$strHtml.'<tr>';
								$strHtml=$strHtml.'<td align="center" valign="middle"><div align="center"><img src='.$strValue.' width="100" height="100"><br>';
								$strHtml=$strHtml.'</div></td>';
								$strHtml=$strHtml.'</tr>';
								$strHtml=$strHtml.'<tr>';
								if($strDownLoadStatus==clsConstants::STATUS_OK)
								{
									$strHtml=$strHtml.'<td height="32" align="center" valign="bottom" class="RegistrationBodyText"><img src="ImageFiles/common/done.gif" width="18" height="17" align="absmiddle"><a href="'.$strValue.'" class="LinkSmall"> View Detail </a></td>';
								}
								else
								{
									$strHtml=$strHtml.'<td height="32" align="center" valign="bottom" class="RegistrationBodyText"><img src="ImageFiles/common/error.gif" width="18" height="17" align="absmiddle"> View Detail </td>';
								}
									
								$strHtml=$strHtml.'</tr>';
								$strHtml=$strHtml.'<tr>';
								$strHtml=$strHtml.'<td align="center" valign="middle">&nbsp;</td>';
								$strHtml=$strHtml.'</tr>';
								$strHtml=$strHtml.'</table>';
								if ($intCounter==5)
								{
									$strHtml=$strHtml."</tr><tr>";
									$intCounter=0;
								}
			
								$intCounter=$intCounter+1;
							}	
							
							else
							{
	
								$strHtml=$strHtml."<td><table width='100%' height='174'  border='0' cellpadding='0' cellspacing='0'>";
								$strHtml=$strHtml."<tr>";
				        	  	$strHtml=$strHtml.'<td align="center" valign="middle">&nbsp;</td>';
							    $strHtml=$strHtml.'</tr>';
								$strHtml=$strHtml.'<tr>';
								$strHtml=$strHtml.'<td align="center" valign="middle"><div align="center"><img src='.$strValue.' width="100" height="100"><br>';
								$strHtml=$strHtml.'</div></td>';
								$strHtml=$strHtml.'</tr>';
								$strHtml=$strHtml.'<tr>';
								if($strUrlStatus==clsConstants::STATUS_OK)
								{
									$strHtml=$strHtml.'<td height="32" align="center" valign="bottom" class="RegistrationBodyText"><img src="ImageFiles/common/done.gif" width="18" height="17" align="absmiddle"><a href="'.$strUrl.'" class="LinkSmall"> View Detail </a></td>';
								}
								else
								{
									$strHtml=$strHtml.'<td height="32" align="center" valign="bottom" class="RegistrationBodyText"><img src="ImageFiles/common/error.gif" width="18" height="17" align="absmiddle" >'.$strMessage.' </td>';
								}
									
								$strHtml=$strHtml.'</tr>';
								$strHtml=$strHtml.'<tr>';
								$strHtml=$strHtml.'<td align="center" valign="middle">&nbsp;</td>';
								$strHtml=$strHtml.'</tr>';
								$strHtml=$strHtml.'</table>';
								if ($intCounter==5)
								{
									$strHtml=$strHtml."</tr><tr>";
									$intCounter=0;
								}
			
								$intCounter=$intCounter+1;
								$strStatus="";
							}
						}	
					
					}
					
				}
			}
			$strHtml=$strHtml."</tr>";
    		$strHtml=$strHtml."</table>";
			$strHtml=$strHtml."</div>";
			$strHtml=$strHtml."</td>";
			$strHtml=$strHtml."</tr>";
			$strHtml=$strHtml."</table>";
//			$strHtml=$strHtml."<br>";
	
		}
		else
		{
			$strHtml=$strHtml."</td>";
			$strHtml=$strHtml."<td valign='top' class='RegistrationBodyText' height=430 align='center'>";
			$strHtml=$strHtml.'<br><br>No Content Selected';
			$strHtml=$strHtml."</td>";
			$strHtml=$strHtml."</tr>";
			$strHtml=$strHtml."</table>";
			$strHtml=$strHtml."<br>";

		}	
		return $strHtml;
	}
	
	
	/*******************************************************************************************************************
	Name				: getContentType()
	Description			: find out file extenshion.
	Input Parameters	: 
	Returns				: return file extenshion
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	26-07-2006       1.00
	*********************************************************************************************************************/

	
	function getFileExtensionForJavaScript($pUrl)
	{

		$this->setProperties();
		// find url extenshion eg. www.pakistan.com/abc.wmv return .wmv
		
		$this->strExtension=substr($pUrl, -4, 4);
		// check extenshion not exists in extenshion Name array.
		if (!in_array($this->strExtension,$this->arrExtenshionName))
		{
			// find url extenshion eg. www.pakistan.com/abc.rm return .rm
			$this->strExtension=substr($pUrl, -3, 3);
			// if not exists in extension array then get content type and find in extenshion array.
			if (!in_array($this->strExtension,$this->arrExtenshionName))
			{
				// find extension using file content type.
				$this->strExtension=array_keys($this->arrExtenshion,$this->getContentType());
				$this->strExtension=$this->strExtension[0];
			}
		}
			
		//set extenshin in lower case.
		$this->strExtension=strtolower($this->strExtension);
		return $this->strExtension;
	}
	function test2()
	{
		$abc="aaa";
		return $abc;
	}
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('downLoadFile','test','getFileExtensionForJavaScript','test2'));
		NAJAX_Client::publicMethods($this, array('downLoadFile','test','getFileExtensionForJavaScript','test2'));

	}
	
}
?>