<?
	header("Content-Type: application/xml; ");
	require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
	include("classes/RSS.class.php");
	$rss = new RSS();
	$type=$_GET["type"];	
	if($type=='auth'){
	$username=$_GET["username"];
	$password=$_GET["password"];
	echo $rss->GetConsumerFeed($username,$password);
	}else{
	$param=$_GET["param"];
	$value=$_GET["value"];
	echo $rss->GetPlaceCastFeed($param,$value);
	}
	
?>