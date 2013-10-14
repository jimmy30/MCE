<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<?php
	$strUrl=urldecode($_GET['Url']);
?>

<html>
	<head>
	</head>	
	<body>
		<object id='myMovie' classid='CLSID:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' height='250' width='540'>
		 <param name='controls' value='ImageWindow'>
		<param name='console' value='_master'>
		 <param name='center' value='true'>
		<embed name='myMovie' src='<?php echo($strUrl); ?>' height='250' width='540' nojava='true' controls='ImageWindow' console='_master' center='true' pluginspage='http://www.real.com/'></embed>
		</object>
	
		<br>
	
		<object id='myMovie' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='540' height='100'>
		<param name='src' value='<?php echo($strUrl);?> '>
		<param name='console' value='video1'>
		<param name='controls' value='All'>
		 <param name='autostart' value='true'>
		<param name='loop' value='false'>
	<embed name='myMovie' src='<?php echo($strUrl); ?>' height='100' width='540' autostart='false' loop='false' nojava='true' console='video1' controls='All'></embed>
		<noembed><a href='http://realmedia.uic.edu/ramgen/itltv/bbintro.30jan02.smil'>Play first clip</a></noembed>
		</object>
	
		 <br>
		
		 <object id='myMovie' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='540' height='36'>
		 <param name= 'src' value='<?php echo($strUrl);?>'>
		 <param name='console' value='video2'>
		 <param name='controls' value='ControlPanel'>
		<param name='autostart' value='true'>
		<param name='loop' value='false'>
		<embed name='myMovie' src='<?php echo($strUrl); ?>' height='36' width='540' autostart='false' loop='false' nojava='true'		 console='video2' controls='ControlPanel'></embed>
		<noembed><a href='http://realmedia.uic.edu/ramgen/itltv/bbtips.6feb02.smi'>Play second clip</a></noembed>
		</object>
	
	</body>
</html>	
	