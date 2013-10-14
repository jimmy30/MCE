<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/htmlparser.inc");

class ManageFile
{
	var $strUploadDirectory;
	var $strFileName;
	var $strTempFileName;
	var $strMessage;
	var $strFile;
	var $strFileList;
	var	$strPattern;
	var $strTempDir;
	var $strServerName;
	var $strContentWayPoint;
	var $arrExtenshionName=array(".wmv",".jpg",".png",".pdf",".mp3",".rm",".avi",".mpg",".jpeg",".gif",".bmp");
	var $arrImageExtension;
	var $arrFileExtension;
	//=array("pdf","doc");
	var $arrMediaExtension;
	//=array("wmv","mp3","rm","avi","mpg");
	var $arrFlashExtension;
	//=array("swf","fla");
	function ManageFile()
	{
		$this->strPattern="(\.jpg$)|(\.png$)|(\.jpeg$)|(\.gif$)|(\.xml$)(\.pdf$)(\.avi$)(\.mpg$)(\.wmv$)(\.bmp$)(\.mp3$)(\.rm$)"; //valid image extensions
		$this->setProperties();
	}
	function getFileName()
	{
		return $this->strFileName;
	}
	function setFileName($value)
	{
		$this->strFileName=$value;
	}
	function getTempFileName()
	{
		return $this->strTempFileName;
	}
	
	function setTempFileName($value)
	{
		$this->strTempFileName=$value;
	}
	
	function getUploadDirectory()
	{
		return $this->$strUploadDirectory;
	}
	
	function setUploadDirectory($value)
	{
		$this->strUploadDirectory=$value;
	}
	function getDirectory()
	{
		return $this->strDirectory;
	}
	function setDirectory($value)
	{
		$this->strDirectory=$value;
	}
	function setProperties()
	{
		//Property class object
		$objProperties=new Properties();
		//Load property file
		$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT']."/Properties/default.properties"));
		
		// File extension properties
		$this->arrImageExtension=$objProperties->getProperty('manage_file_imgage_extension');
		$this->arrImageExtension = explode(',',$this->arrImageExtension); 
		
		$this->arrFileExtension=$objProperties->getProperty('manage_file_file_extension');
		$this->arrFileExtension= explode(',',$this->arrFileExtension); 
		
		$this->arrMediaExtension=$objProperties->getProperty('manage_file_media_extension');
		$this->arrMediaExtension= explode(',',$this->arrMediaExtension); 
		
		$this->arrFlashExtension=$objProperties->getProperty('mange_file_flash_extension');
		$this->arrFlashExtension= explode(',',$this->arrFlashExtension); 
		
		
		$this->strUploadDirectory=$_SERVER['DOCUMENT_ROOT']."/".$objProperties->getProperty('user_files_upload_directory');
		$this->strDirectory="/".$objProperties->getProperty('user_files_upload_directory');
		//$this->strPattern=$objProperties->getProperty('user_files_extensions');
	
		$this->strUploadDirectory=$this->strUploadDirectory."/".$_SESSION[sessionKeys::USER_ID];
		$this->strDirectory=$this->strDirectory."/".$_SESSION[sessionKeys::USER_ID];
		$this->strTempDir=$this->strUploadDirectory;
		$this->strServerName=$objProperties->getProperty('site_url');
		$this->strContentWayPoint=$objProperties->getProperty('waypoint_content_directory');
	}
	function uploadFile($pIntCounter)
	{
		// Find file extension 
		$strExtension=explode(".",$this->strFileName);
		//return $this->strFileName;
		$strExtension=$strExtension[1];
		$strExtension=strtolower($strExtension);
		// check file extension imgae,media or file.
//		return $strExtension;
		if (in_array($strExtension,$this->arrImageExtension))
		{
			$status="Image";
			
		}
		elseif(in_array($strExtension,$this->arrMediaExtension))
		{	
			$status="Media";		
	
		}
		elseif(in_array($strExtension,$this->arrFileExtension))
		{	
			$status="File";			
		}

		elseif(in_array($strExtension,$this->arrFlashExtension))
		{	
			$status="Flash";			
		}
		
		else
		{
			return $this->strMessage=$this->strFileName. " Not Valid Extension";
		}
	
	
		// set directory path
		if ($status=="Image")
		{
			
			$strUpDirectory=$this->strUploadDirectory."/Image";

			if (!is_dir($this->strTempDir))
			{
				mkdir($this->strTempDir,0777,TRUE);
			}
			if(!is_dir($strUpDirectory))		
			{
				mkdir($strUpDirectory,0777,TRUE);
			}

			$this->strMessage=$this->saveFile($pIntCounter,$strUpDirectory);
			return $this->strMessage;
		}	
		elseif($status=="Media")
		{
			$strUpDirectory=$this->strUploadDirectory."/Media";
			if (!is_dir($this->strTempDir))
			{
				mkdir($this->strTempDir,0777,TRUE);
				
			}	
			if(!is_dir($strUpDirectory))
			{
				mkdir($strUpDirectory,0777,TRUE);
			}	

			$this->strMessage=$this->saveFile($pIntCounter,$strUpDirectory);
			return $this->strMessage;
		}
		elseif($status=="File")
		{
			
			$strUpDirectory=$this->strUploadDirectory."/File";
			if (!is_dir($this->strTempDir))
			{
				mkdir($this->strTempDir,0777,TRUE);
				
			}	
			if(!is_dir($strUpDirectory))
			{
				mkdir($strUpDirectory,0777,TRUE);
			}	
			$this->strMessage=$this->saveFile($pIntCounter,$strUpDirectory);
			return $this->strMessage;
		}	
		elseif($status=="Flash")
		{

			if (!is_dir($this->strTempDir))
			{
				mkdir($this->strTempDir,0777,TRUE);
				$strUpDirectory=$this->strUploadDirectory."/Flash";
				$this->strMessage=$this->saveFile($pIntCounter,$strUpDirectory);
				return $this->strMessage;
			}	
			if(!is_dir($strUpDirectory))
			{
				mkdir($strUpDirectory,0777,TRUE);
			}	
		}	
		
	
			
   }
	function saveFile($pIntCounter,$strDirPath)
	{

		$this->strFileName=$strDirPath."/".$this->strFileName;
		// return $this->strTempFileName[$pIntCounter];
		//return $this->strFileName;
		if (move_uploaded_file($this->strTempFileName[$pIntCounter], $this->strFileName)) 
		{
		 
		   $this->strMessage= $this->strFileName." File is valid, and was successfully uploaded.\n";
		} 
		else 
		{
		   $this->strMessage=$this->strFileName. "Not uploaded!\n";
		}
		return $this->strMessage;		
			
   }
   
   function saveSingleFile($pStrDirPath)
	{


		$this->strFileName=$pStrDirPath."/".$this->strFileName;

		//$pStrDirPath;
		if(!is_dir($pStrDirPath))
		{	
			mkdir($pStrDirPath,0777,TRUE);
		}
	
		if (move_uploaded_file($this->strTempFileName, $this->strFileName)) 
		{
		 
		   $this->strMessage= "yes";
		   //$this->strFileName." File is valid, and was successfully uploaded.\n";
		} 
		else 
		{
		   $this->strMessage="no";
		   //$this->strFileName. "Not uploaded!\n";
		}
		return $this->strMessage;		
			
   }
   
   
   function getFileList()
   {
   		
		$strExtension=explode(".",$this->strFile);
		$strExtension=$strExtension[1];
		$strArray=array(".","..","Thumbs.db");
	   $this->strFileList = array();
	   $i=0;

	  	// Retrive Directories
   		if($handle = opendir($_SERVER['DOCUMENT_ROOT']."/".$this->strDirectory))
		{
			while(false !== ($this->strFile = readdir($handle)))
			{
			
				if (!in_array($this->strFile,$strArray))
				{	
			   		$strDirectoryArray[$i]=$this->strFile;
					$i++;
				}	 
			}	
				
			closedir($handle);
		}


	   $k=0;
	   // Retrive files in directories
		for ($j=0;$j<count($strDirectoryArray);$j++)
		{
			
			$this->strFile ="";

			$strDirectorya=$this->strDirectory."/".$strDirectoryArray[$j];
			
			if($handle = opendir($_SERVER['DOCUMENT_ROOT']."/".$strDirectorya))
			{
				
				while(false !== ($this->strFile = readdir($handle)))
				{
					
					if (!in_array($this->strFile,$strArray))
					{

						 $this->strFileList[$k]=$strDirectorya."/".$this->strFile;
						$k++; 
					}	
					
				}
				closedir($handle);	
			}
			
		}	
	   return $this->strFileList;
	}
	

	function deleteFile($pStrFileName,$pPlaceCastId)
	{

		
		 $pStrFileName=$_SERVER['DOCUMENT_ROOT']."/".$pStrFileName;;	
		if (is_file($pStrFileName))
		{
	
			$blnStatus=unlink($pStrFileName);
			return $blnStatus;
		}	
		else
		{	
			return $pStrFileName="";
		}	
	}
	
	function deleteContent($pWaypointId)
	{
		// To Do...
		$rootPath=$_SERVER['DOCUMENT_ROOT']."/Contents/PlaceCasts/".$pPlaceCastId."/Waypoints/".$pWaypointId;
		
		if(is_dir($rootPath))
		{
			///// Remove ContentFiles folder //////////
			$path[0]=$rootPath."/ContentFiles/Images";
			$path[1]=$rootPath."/ContentFiles/Multimedia";
			$path[2]=$rootPath."/ContentFiles/Text";

			for($j=0;$j<sizeof($path);$j++)
			{
				if(is_dir($path[$j]))
				{
					$this->setDirectory($path[$j]);
					$arrayFiles=$this->getFileList();
	
					if(sizeof($arrayFiles)>0)
					{
						for($i=0;$i<sizeof($arrayFiles);$i++)
						{
							unlink($path[$j]."/".$arrayFiles[$i]);
						}
					}
					rmdir($path[$j]);
				}
			}
			rmdir($rootPath."/ContentFiles");
			/////////////////////////////////////////

			///// Remove TempFiles folder //////////
			$path=$rootPath."/TempFiles";
			$this->setDirectory($path);
			$arrayFiles=$this->getFileList();
			
			if(sizeof($arrayFiles)>0)
			{
				for($i=0;$i<sizeof($arrayFiles);$i++)
				{
					unlink($path."/".$arrayFiles[$i]);
				}
			}
			rmdir($path);
			//////////////////////////////////////////
			
			///// Remove Root folder /////////////////
			$this->setDirectory($rootPath);
			$arrayFiles=$this->getFileList();
			
			if(sizeof($arrayFiles)>0)
			{
				for($i=0;$i<sizeof($arrayFiles);$i++)
				{
					unlink($rootPath."/".$arrayFiles[$i]);
				}
			}
			rmdir($rootPath);
			/////////////////////////////////////////
		}
	}

	function RemoveFiles($source)
	{
		
		//$source=$_SERVER['DOCUMENT_ROOT']."/Contents/PlaceCasts/".$pPlaceCastId."/Waypoints/".$pWaypointId;
		$folder = opendir($source);
  		 while($file = readdir($folder))
	   	{
		   if ($file == '.' || $file == '..') 
		   {
			   continue;
		   }
		   
		   if(is_dir($source.'/'.$file))
		   {
			   RemoveFiles($source.'/'.$file);
		   }
		   else 
		   {
			   unlink($source.'/'.$file);
		   }
		   
	   }
	   closedir($folder);
	   rmdir($source);
	   return 1;
	}
	function FilesRemove($source)
	{
	
	//$source=$_SERVER['DOCUMENT_ROOT']."/Contents/PlaceCasts/".$pPlaceCastId."/Waypoints/".$pWaypointId;
	$folder = opendir($source);
	 while($file = readdir($folder))
	{
	   if ($file == '.' || $file == '..') 
	   {
		   continue;
	   }
	   
	   if(is_dir($source.'/'.$file))
	   {
		   RemoveFiles($source.'/'.$file);
	   }
	   else 
	   {
		   unlink($source.'/'.$file);
	   }
	   
   }
   closedir($folder);
   return 1;
	}
	
   function findDirectory($strDirectoryName)
   {
   		if(!is_dir($strDirectoryName))
		{
			return $staus="false";
		}
		else
		{
			return $status="true";
		}
   }
   function readFile($strFileName)
   {
	 //   $strFileName="Contents/PlaceCasts/Waypoints/37/37.html";

   		if (file_exists($strFileName))
		{

			$handle = fopen($strFileName, 'r');
			if ($handle === false) 
			{ 
			   return false; 
			} 
			else
			{
				$strFileData = fread($handle, filesize($strFileName));
				fclose($handle);
				return $strFileData;
			}
			
		}
		
   }
   
   function contentEditorHtml($strFileName,$pId,$pPid)
   {
	   	$strHtml="<Html>";
		//echo($strFileName);
		// call parse html string function.
		$parser = HtmlParser_ForString ($strFileName);
		
		while ($parser->parse()) 
		{
			// check if tag name image or hyperlink
			if($parser->iNodeName=="<Html>" || $parser->iNodeName=="</Html>")
			{
					
			}
		   else if ($parser->iNodeName=="<img>" || $parser->iNodeName=="<a>")
		   {
				if ($parser->iNodeType == NODE_TYPE_ELEMENT) 
				{
					// assign attribute name value.
					$attrValues = $parser->iNodeAttributes;
					//assign attribute name.
	                $attrNames = array_keys($attrValues);
					// get no. of attribute in tag
    	            $size = count($attrNames);
        	        $strFilePath=$this->strServerName."/".$this->strContentWayPoint."/".$pPid."/Waypoints/".$pId."/";

					for ($i = 0; $i < $size; $i++) 
					{
						$name = $attrNames[$i];
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
						if($attrNames[$i]=="src")
						{
							$strImage="<img src=\"".$strFilePath.$attrValues[$name]."\" height=75 width=75 alt=\"".$alt."\">";
						}
						
						if ($attrNames[$i]=="href")
						{	

							$strHref="<a href=\"".$strFilePath.$attrValues[$name]."\"></a>";
						}
						$strImageHref=$strImageHref.$strImage.$strHref;
						$strImage="";
						$strHref="";
					}
									
				}
			}
			else
			{
				$strHtml=$strHtml.$parser->iNodeName.$parser->iNodeValue;
			}
			
		}
		$strHtml=$strHtml.$strImageHref;
		$strHtml=$strHtml."<Html>";
		return $strHtml;
		
   }
   
   function downLoadFile($filePath)
   {
   		
		/*
		try
		{
			/////////////////////////////////////////Strat Firefox Code ///////////////////////////////////////////////
			// downloading a file
			///////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			//echo $_REQUEST["downloadFilePath"];
			//exit;
			//$filename = "desktop.jpg";
			$filename =$_SERVER['DOCUMENT_ROOT'].$filePath;
			//$file='FileManagerDownload.php'.'?downloadFilePath='.$filename;
			//require_once($file);
			//return $filename;
			$newFileName=basename($filename);

			// fix for IE catching or PHP bug issue
			
			header("Pragma: public");
			header("Expires: 0"); // set expiration time
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			// browser must download file from server instead of cache
			
			
			
			// force download dialog
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			
			// use the Content-Disposition header to supply a recommended filename and
			// force the browser to display the save dialog.
			header("Content-Disposition: attachment; filename=$newFileName".";");
			
			
			/*
			The Content-transfer-encoding header should be binary, since the file will be read
			directly from the disk and the raw bytes passed to the downloading computer.
			The Content-length header is useful to set for downloads. The browser will be able to
			show a progress meter as a file downloads. The content-lenght can be determines by
			filesize function returns the size of a file.
			*/
			/*			
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($filename));
			
			readfile("$filename");
			return $filename;
			//exit();
		
		}
		catch(Exception $e)
		{
			$e->getMessage(); 
		}		
		*/
		/////////////////////////////////////////End Firefox Code ///////////////////////////////////////////////
		
		
		/////////////////////////////////////////Start IE Code //////////////////////////////////////////////////
		
		
		//header("Content-Disposition: attachement");
		//echo'<a href="a.jpg">download</a>';
		
		///////////////////////////////////////End IE Code //////////////////////////////////////////////////////
		
   }

	/// Mapping Function for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('getFileList','deleteFile','downLoadFile','readFile'));
		NAJAX_Client::publicMethods($this, array('getFileList','deleteFile','downLoadFile','readFile'));
	}

 }
?>