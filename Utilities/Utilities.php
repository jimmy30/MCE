<?php 

require_once($_SERVER["DOCUMENT_ROOT"]."/"."Utilities/Logger.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/"."Utilities/Properties.php");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function isSearchEngineExists($pSearchEngines,$pSearchEngine)
{
	$strSearchEnginesArray=explode(',', $pSearchEngines); 
	$intArraySize=sizeof($strSearchEnginesArray);

	for($i=0; $i<$intArraySize;$i++)
	{
 		if 	($strSearchEnginesArray[$i]==$pSearchEngine)	
 		{
 			
 			
 			return true;
 		}
	}	
	
	return false;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Log Related Functions 					
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function isLogOptionExists($pLogOptions,$pLogOption)
{
	$strLogOptionsArray=explode('|', $pLogOptions); 
	$intArraySize=sizeof($strLogOptionsArray);

	for($i=0; $i<$intArraySize;$i++)
	{
 		if 	($strLogOptionsArray[$i]==$pLogOption)	
 		{
 			return true;
 		}
	}	
	
	return false;
}

function getLogOption($pLogOptions)
{

	if( (isLogOptionExists($pLogOptions,"SCREEN")) &&  (isLogOptionExists($pLogOptions,"DEBUG")) )
	{
		$LogOptions=FILE|SCREEN|DEBUG;
	}
	else if((isLogOptionExists($pLogOptions,"SCREEN")) )
	{
		$LogOptions=FILE|SCREEN;
		
	}

	else 
	{
		$LogOptions=FILE|DEBUG;
	}
	
	return $LogOptions;
	
} 


 function LogEntry($pMessage,$pLogMode)
{
	
	$objProperties=new Properties();
	$objProperties->load(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/" . "Properties" . "/" . "default.properties"));

	$LogOptionsString=$objProperties->getProperty('log_file_options');
	$LogOptions=getLogOption($LogOptionsString);

	$LogDir=$_SERVER["DOCUMENT_ROOT"]."/".$objProperties->getProperty('log_directory_path');
	$strFileName=$LogDir ."/" . "log_" . date("d_m_Y")  . ".log";
	
	$l=new Logger($strFileName, $LogOptions);
	$l->log($pMessage);
	$l->closelog();
} 



function copydirr($fromDir,$toDir,$chmod=0757,$verbose=false)
/*
   copies everything from directory $fromDir to directory $toDir
   and sets up files mode $chmod
*/
{
//* Check for some errors
$errors=array();
$messages=array();
/*if (!is_writable($toDir))
   $errors[]='target '.$toDir.' is not writable';
if (!is_dir($toDir))
   $errors[]='target '.$toDir.' is not a directory';
  */ 
 if(!is_dir($toDir))
 {
 	mkdir($toDir);
 }
if (!is_dir($fromDir))
   $errors[]='source '.$fromDir.' is not a directory';
if (!empty($errors))
   {
   if ($verbose)
       foreach($errors as $err)
           echo '<strong>Error</strong>: '.$err.'<br />';
   return false;
   }
//*/
$exceptions=array('.','..');
//* Processing
$handle=opendir($fromDir);

while (false!==($item=readdir($handle)))
   if (!in_array($item,$exceptions))
       {
       //* cleanup for trailing slashes in directories destinations
       $from=str_replace('//','/',$fromDir.'/'.$item);
       $to=str_replace('//','/',$toDir.'/'.$item);
       //*/
       if (is_file($from))
           {
           if (@copy($from,$to))
               {
               chmod($to,$chmod);
               touch($to,filemtime($from)); // to track last modified time
               $messages[]='File copied from '.$from.' to '.$to;
               }
           else
               $errors[]='cannot copy file from '.$from.' to '.$to;
           }
       if (is_dir($from))
           {
           if (@mkdir($to))
               {
               chmod($to,$chmod);
               $messages[]='Directory created: '.$to;
               }
           else
               $errors[]='cannot create directory '.$to;
           copydirr($from,$to,$chmod,$verbose);
           }
       }
closedir($handle);
//*/
//* Output
/*
if ($verbose)
   {
   foreach($errors as $err)
       echo '<strong>Error</strong>: '.$err.'<br />';
   foreach($messages as $msg)
       echo $msg.'<br />';
   }
//*/
return true;
}


function RemoveFiles($source)
{
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
function CopyFiles()
{

}

?>