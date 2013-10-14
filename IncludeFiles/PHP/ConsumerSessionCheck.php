<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
if(!isset($_SESSION[sessionKeys::USER_EMAIL]) || $_SESSION[sessionKeys::USER_EMAIL]=="" || $_SESSION[sessionKeys::USER_TYPE]==2 || $_SESSION[sessionKeys::USER_TYPE]==3)
{
$url=$_SERVER['PHP_SELF'];
if(isset($_REQUEST["id"]))
$url.="?id=".$_REQUEST["id"];
else if(isset($_REQUEST["counter"]) && isset($_REQUEST["maxCount"]))
$url.="?counter=".$_REQUEST["counter"]."&maxCount=".$_REQUEST["maxCount"];

	?>
	<html>
	<body>
	<form id="frm" name="frm" action="/CustomerSignIn.php" method="post"> 
	<input type="hidden" name="urlAfterLoginConsumer" id="urlAfterLoginConsumer" value="<?php echo $url;?>">
	</form>
	</body>
	</html>
	<script language="javascript"> document.frm.submit();</script>	<?
	exit;
}
?>