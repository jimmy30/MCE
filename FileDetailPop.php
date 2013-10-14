<?php 
	require_once('ManageFile.php');
	require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
	$objFile = new ManageFile();
//		echo($objFile->uploadFile($_FILES['fileupload'][name],$_FILES['fileupload'][tmp_name]));


	NAJAX_Server::allowClasses("ManageFile");
	if (NAJAX_Server::runServer()) 
	{
		exit;
	}

?>

<?php 
	echo(NAJAX_Utilities::header('/IncludeFiles/PHP/Najax'));
	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>
<MMString:LoadString id="insertbar/formsButton" />
</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>
<script language="javascript">
var obj = <?= NAJAX_Client::register(new ManageFile()) ?>;
var arrayResult;
function showUpload()
{
	document.getElementById("uploadFile").style.display="inline";
}
function hideUpload()
{
	document.getElementById("uploadFile").style.display="none";
}
function showFiles()
{

	var strHtml="";
	var intCount="";
	obj.getFileList('',function(result)
			{
				arrayResult=result;
				
				strHtml+="<table border=0 cellpadding=5 cellspacing=1 align=center width=99%>";
				for(intCount=0;intCount<arrayResult.length;intCount++)
				{
					
					if((Math.round(intCount - (Math.floor(intCount/2)*2)))==0)
						altColor=ALTERNATE_COLOR_NORMAL;
					else
						altColor=ALTERNATE_COLOR;
					var filePathSplit = arrayResult[intCount].split("/");

					var filePathSplit = arrayResult[intCount].split("/");
					var fileExtension = filePathSplit[filePathSplit.length-1].split(".");
					
					strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'>';
					strHtml+="<td class=RegistrationBodyText><img src=/ImageFiles/Common/"+fileExtension[1]+".gif border=0>&nbsp;"+filePathSplit[filePathSplit.length-1]+"</td>";
					strHtml+="<td class=RegistrationBodyText align='center'><a href='#' onclick=\"downloadFile('"+arrayResult[intCount]+"')\"><img src=/ImageFiles/Common/download.gif alt='Download' border=0></td>";
					strHtml+="<td align='center'><input type='checkbox' name='Chkdelete' value='"+arrayResult[intCount]+"'></td></tr>";
					
				}	
				strHtml+="</table>";
				document.getElementById("displayFile").innerHTML=strHtml;
			}
			);
			

}


function downloadFile(sourceFile)
{
	
/*	obj.downLoadFile(sourceFile,function(result)
	{
		//alert(result);
	}
	);*/
	document.getElementById("downloadFilePath").value=sourceFile;
	document.frmFileManager.submit();
	

}

function deleteFiles()
{
	var intLength;
	var intCounter;
	var blnCheck=0;
	intLength=document.FileDetailchk.Chkdelete.length;
	
	if(intLength>0)
	{

		for(intCounter=0;intCounter<intLength;intCounter++)
		{
			if (document.FileDetailchk.Chkdelete[intCounter].checked)
			{
				blnCheck=1;
			}
		}	
	
		if(blnCheck==0)
		{
			alert("No file(s) selected");
		}
		else if(window.confirm("Are you sure, you want to delete file(s)"))
		{
			for(intCounter=0;intCounter<intLength;intCounter++)
			{
				if (document.FileDetailchk.Chkdelete[intCounter].checked)
				{
					
					//alert(document.FileDetail.Chkdelete[intCounter].value);
					obj.deleteFile(document.FileDetailchk.Chkdelete[intCounter].value,function(result)
					{
						showFiles();
					}
					);
				}	
				
			}
			
		}
	}
	else
	{

		if(document.FileDetailchk.Chkdelete.checked)
		{
			 if(window.confirm("Are you sure, you want to delete file(s)"))
			 {
				obj.deleteFile(document.FileDetailchk.Chkdelete.value,function(result)
					{
						showFiles();
					}
					);
			 }
		}	
		else 		
		{
			alert("No file(s) selected");
		}

	}	
}



var extArray= new Array();
extArray[0]="jpg";
extArray[1]="bmp";
extArray[2]="gif";
extArray[3]="png";
extArray[4]="mp3";
extArray[5]="avi";
extArray[6]="rm";
extArray[7]="wmv";
extArray[8]="doc";
extArray[9]="pdf";
extArray[10]="mpeg";
extArray[11]="mpeg4";
extArray[12]="wav";

function chkExt(str)
{

var chkExt=0;
	var strExt=str.substr(str.length-3,str.length-(str.length-3));

		for(var i=0;i<extArray.length;i++)
		{
			if(strExt.toLowerCase()==extArray[i])
			{
			chkExt=1;
			}
			
		}
		if(chkExt==0)
		{
			alert("Only .JPG, .GIF, .BMP, .PNG, .MP3, .AVI, .RM, .WMV, .DOC, .PDF, .MPEG, .MPEG4, .WMV file extensions are supported!");
			return false;
		}
		return true;
}
function validateForm()
{
	
	if(document.FileDetail.elements[0].value!="")
	{
	
		if(!chkExt(document.FileDetail.elements[0].value))
		{
			document.FileDetail.elements[0].focus();		
			document.FileDetail.elements[0].select();						
			return false;
		}
		
	}
	if(document.FileDetail.elements[1].value!="")
	{
	
		if(!chkExt(document.FileDetail.elements[1].value))
		{
			document.FileDetail.elements[1].focus();		
			document.FileDetail.elements[1].select();						
			return false;
		}
		
	}
	if(document.FileDetail.elements[2].value!="")
	{
	
		if(!chkExt(document.FileDetail.elements[2].value))
		{
			document.FileDetail.elements[2].focus();		
			document.FileDetail.elements[2].select();						
			return false;
		}
		
	}
	if(document.FileDetail.elements[3].value!="")
	{
	
		if(!chkExt(document.FileDetail.elements[3].value))
		{
			document.FileDetail.elements[3].focus();		
			document.FileDetail.elements[3].select();						
			return false;
		}
		
	}
	if(document.FileDetail.elements[4].value!="")
	{
	
		if(!chkExt(document.FileDetail.elements[4].value))
		{
			document.FileDetail.elements[4].focus();		
			document.FileDetail.elements[4].select();						
			return false;
		}
		
	}
}
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
</head>
<body onUnload="opener.getFileList()">
  <table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
      <tr  class="RegistrationCellBg">
        <td width="32"  height="27">&nbsp;</td>
        <td width="616" align="left" valign="middle"><p class="RegistrationTitleText">File Manager  </p></td>
      </tr>
      <tr valign="top">
        <td height="5" colspan="2" class="RegistrationBodyText"></td>
      </tr>
      <tr valign="top">
        <td height="417" colspan="2" class="RegistrationBodyText"><table width="650" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="433"  height="25" class="RegistrationCellBG"><span class="RegistrationTitleTextSmall">&nbsp;File List </span></td>
              <td width="134" class="RegistrationCellBG"><span class="RegistrationTitleTextSmall">Download</span></td>
              <td width="81" class="RegistrationCellBG"><span class="RegistrationTitleTextSmall">Delete</span></td>
            </tr>
            <tr>
              <td colspan="3"><form name="FileDetailchk" id="FileDetailchk"><div id="displayFile"> </div></form></td>
            </tr>
            <tr>
              <td height="35" colspan="3"><div align="right">
                  <input type="button" name="btnAdd" value="Add"  onClick="showUpload()" class="Button">
                  <input type="button" name="btnDelete" value="Delete" onClick="deleteFiles()" class="Button">
                  &nbsp; </div></td>
            </tr>
		 <form name="FileDetail" id="FileDetail" action="UploadFilepop.php" enctype="multipart/form-data" method="post" onSubmit="return validateForm();">	
            <tr>
              <td height="10" colspan="3"></td>
            </tr>
            <tr>
              <td colspan="3"><div id="uploadFile" style="display:none">
                  <table width="650" border="0" cellpadding=5 cellspacing=1>
                    <tr>
                      <td class="RegistrationCellBg"><span class="RegistrationTitleTextSmall">&nbsp;Upload File </span></td>
                    </tr>
                    <tr bgcolor="#EEEEEE">
                      <td class="RegistrationBodyText"><div align="center"><strong>File1</strong>
                              <input type="file" name="fileupload[]">
                      </div></td>
                    </tr>
                    <tr bgcolor="#EEEEEE">
                      <td class="RegistrationBodyText"><div align="center"><strong>File2</strong>
                              <input type="file" name="fileupload[]">
                      </div></td>
                    </tr>
                    <tr bgcolor="#EEEEEE">
                      <td class="RegistrationBodyText"><div align="center"><strong>File3</strong>
                              <input type="file" name="fileupload[]">
                      </div></td>
                    </tr>
                    <tr bgcolor="#EEEEEE">
                      <td class="RegistrationBodyText"><div align="center"><strong>File4</strong>
                              <input type="file" name="fileupload[]">
                      </div></td>
                    </tr>
                    <tr bgcolor="#EEEEEE">
                      <td class="RegistrationBodyText"><div align="center"><strong>File5</strong>
                              <input type="file" name="fileupload[]">
                      </div></td>
                    </tr>
                    <tr bgcolor="#EEEEEE">
                      <td align="right"><div align="right">
                          <input name="btnUpload" type="submit" id="btnUpload" value="Upload" class="Button">
                          <input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="hideUpload()" class="Button">
                        &nbsp; </div></td>
                    </tr>
                  </table>
              </div></td>
            </tr>
          </form>
        </table>          
          <p><form action="/FileManagerDownload.php" method="post" name="frmFileManager" id="frmFileManager">
		  <input type="hidden" name="downloadFilePath" id="downloadFilePath">
		  </form>
		  </p></td>
      </tr>
</table>
    <!-- InstanceEndEditable --> </td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
</table>
<script language="JavaScript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/JavaScript/tmenu.js"></script>
</body>
<!-- InstanceEnd --></html>
<script language="javascript">showFiles()</script>
