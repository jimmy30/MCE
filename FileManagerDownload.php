<?php
/////////////////////////////////////////Strat Firefox Code ///////////////////////////////////////////////
// downloading a file
///////////////////////////////////////////////////////////////////////////////////////////////////////////

$filename =$_SERVER['DOCUMENT_ROOT'].$_REQUEST["downloadFilePath"];

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


header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename));

readfile("$filename");

exit();


/////////////////////////////////////////End Firefox Code ///////////////////////////////////////////////


/////////////////////////////////////////Start IE Code //////////////////////////////////////////////////


//header("Content-Disposition: attachement");
//echo'<a href="a.jpg">download</a>';

///////////////////////////////////////End IE Code //////////////////////////////////////////////////////
/*
function dwfile($file) 
{ 
    if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) 
    { 
        // IE Bug in download name workaround 
        ini_set( 'zlib.output_compression','Off' ); 
    } 
    header ('Content-type: ' . mime_content_type($file)); 
    header ('Content-Disposition: attachment; filename="'.basename($file).'"'); 
    header ('Expires: '.gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y"))).' GMT'); 
    header ('Accept-Ranges: bytes'); 
    header ('Cache-control: no-cache, must-revalidate'); 
    header ('Pragma: private'); 

    $size = filesize($file); 
    if(isset($_SERVER['HTTP_RANGE'])) 
    { 
        list($a, $range)=explode("=",$_SERVER['HTTP_RANGE']); 
        //if yes, download missing part 
        str_replace($range, "-", $range); 
        $size2=$size-1; 
        $new_length=$size2-$range; 
        header("HTTP/1.1 206 Partial Content"); 
        header("Content-Length: $new_length"); 
        header("Content-Range: bytes $range$size2/$size"); 
    } 
    else 
    { 
        $size2=$size-1; 
        header("Content-Range: bytes 0-$size2/$size"); 
        header("Content-Length: ".$size); 
    } 

    if ($file = fopen($file, 'rb')) 
    { 
        while(!feof($file) and (connection_status()==0)) 
        { 
            print(fread($file, 1024*8)); 
            flush(); 
        } 
        $status = (connection_status()==0); 
        fclose($file); 
    } 
    return($status); 
} 
*/


?>
