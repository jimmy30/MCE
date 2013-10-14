<link rel="stylesheet" href="../../IncludeFiles/Javascript/AutoComplete/AutoComplete.css" media="screen" type="text/css">
<script language="javascript" type="text/javascript" src="../../IncludeFiles/Javascript/AutoComplete/AutoComplete.js"></script>
<table cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" bgcolor=<?php echo($strColor);?> width="150" height="25" class="HeadingText">Research Tools </td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td><label class="InputLabelSmall">&nbsp;&nbsp;Enter Text</label></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;
        <input name="txtQuery" type="text" class="TextBox" id="txtQuery" style="width:130px"></td>
  </tr>
  <tr>
    <td height="2"></td>
  </tr>
  <tr>
    <td align="right"><input name="button" type="button" class="Button" onClick="openwin()" value="Search" width="120">
      &nbsp;&nbsp;&nbsp;&nbsp; </td>
  </tr>
  <tr>
    <td height="10"></td>
  </tr>
</table>
<script language="javascript">
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
</script>

<script language="javascript">
function openwin()
{
if(document.getElementById("txtQuery").value=="")
{
	alert("Please enter query");
	document.getElementById("txtQuery").focus();
	return false;
}

var winWidth=600;
var winHeight=400;
var left=(screen.width / 2 - winWidth / 2);
var top=(screen.height / 2 - winHeight / 2);
window.open('/SearchSpider.php','Search','left='+left+', top='+top+', width='+winWidth+', height='+winHeight+',status=yes,scrollbars=yes')
}
</script>
<script language="javascript" type="text/javascript">
<!--
var query=readCookie('SearchTxtQuery');
if(query!=null)
{
data=query.split('||');

    data = data.sort();

    AutoComplete_Create('txtQuery', data);
}
// -->
</script>


