<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
if(!isset($_SESSION[sessionKeys::ADMIN_EMAIL]) || $_SESSION[sessionKeys::ADMIN_EMAIL]=="" || $_SESSION[sessionKeys::ADMIN_TYPE]==1 || $_SESSION[sessionKeys::ADMIN_TYPE]==2)
{
$url=$_SERVER['PHP_SELF'];
if(isset($_REQUEST["id"]))
$url.="?id=".$_REQUEST["id"];
	?>
	<html>
	<body>
	<form id="frm" name="frm" action="/admin/AdminSignIn.php" method="post"> 
	<input type="hidden" name="urlAfterLoginAdmin" id="urlAfterLoginAdmin" value="<?php echo $url;?>">
	</form>
	</body>
	</html>
	<script language="javascript"> document.frm.submit();</script>	<?
	exit;
}
?>