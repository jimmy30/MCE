<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<?php
	$strUrl=urldecode($_GET['Url']);
?>

<html>
	<head>
	</head>	
	<body>
			<OBJECT id="VIDEO" width="400" height="300" style="position:absolute; left:0;top:0;" CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" type="application/x-oleobject">
				<PARAM NAME="URL" VALUE="<?php echo($strUrl); ?> ">
				<PARAM NAME="SendPlayStateChangeEvents" VALUE="True">
				<PARAM NAME="AutoStart" VALUE="True">
				<PARAM name="uiMode" value="full">
				<PARAM name="PlayCount" value="9999">
			</OBJECT>
	</body>
</html>	
	