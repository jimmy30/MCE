<?
$strFileName=$_SESSION["strFileName"];
$handle = fopen($strFileName, "r");
$contents = fread($handle, filesize($strFileName));
fclose($handle);

if($_REQUEST["id"]==1)
{
$arrWayPoints=explode("<WayPoint>",$contents);
$contXml=$arrWayPoints[0];
	for($i=1;$i<sizeof($arrWayPoints);$i++)
	{
	if($i==1) $i++;
	
	if($_REQUEST["maxCount"]==1)
		$contXml.="</WayPoints></Tour>";
	else $contXml.="<WayPoint>";
		$contXml.=$arrWayPoints[$i];
	}

}
else
{
$arrWayPoints=explode("</WayPoint>",$contents);
$contXml=$arrWayPoints[0];
	for($i=1;$i<=sizeof($arrWayPoints);$i++)
	{
	echo $_REQUEST["id"]."<br>";
		if(($_REQUEST["id"]-1)==$i)
		{
		$contXml.="</WayPoint>";
		$i++;
		}
		else if(sizeof($arrWayPoints)!=$i)
		$contXml.="</WayPoint>";
	
	$contXml.=$arrWayPoints[$i];

	}
}
//echo "<textarea rows=30 cols=100>".$contXml."</textarea>";
//exit;
$FileHandle = fopen($strFileName, 'w') or die("can't open file");
fwrite($FileHandle,$contXml);
fclose($FileHandle);
echo '<script language="Javascript"> location.href=\'ViewForm.php?maxCount='.($_REQUEST["maxCount"]-1).'\' </script>';

exit;

?>
