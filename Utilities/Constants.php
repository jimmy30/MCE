<?php 
class clsConstants
{
	const RESPONSE_STATUS_OK="ok";
	const RESPONSE_STATUS_ERROR="error";
	const RESPONSE_STATUS_EXCEPTION="exception";
	///// for producer acitavation page link
	const PAGE_PRODUCER_REGISTRATION_ACTIVATION="/Registration/ProducerRegistration/ProducerActivation.php?id=[ACTIVATION_CODE]&EMAIL=[EMAIL]";
	///// for consumer acitavation page link	
	const PAGE_CONSUMER_REGISTRATION_ACTIVATION="/Registration/ConsumerRegistration/ConsumerActivation.php?id=[ACTIVATION_CODE]&EMAIL=[EMAIL]";
	const RESPONSE_STATUS_EMAIL_NOT_EXISTS="EmailNotExists";
	const RESPONSE_STATUS_PASSWORD_NOT_CORRECT="PasswordNotCorrect";
	const RESPONSE_STATUS_FORGET_SECRET_ANSWER_NOT_CORRENCT="SecretAnswerNotCorrect";
	///// admin for get password
	const RESPONSE_STATUS_ADMIN_FORGET_PASSWORD_EMAIL_NOT_CORRECT="EmailNotCorrect";
	// Open file 
	const RESPONSE_STATUS_FILE_NOT_OPEN="file not open";
	const RESPONSE_STATUS_NO_FILE="No file information found";
	
	// Waypoints  download content directories name
	const Content_Directory="ContentFiles";
	const Multimedia_Content_Directory="Multimedia";
	const Text_Content_Directory="Text";
	const Audio_Content_Directory="Audio";
	const Video_Content_Directory="Video";
	const Images_Content_Directory="Images";
	
	const Image_File_Path="/UserFiles/Image/Audio.jpg";
	const STATUS_OK=1;
	const STATUS_FAILURE=0;

}


?>