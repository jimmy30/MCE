
function Querystring(qs) { // optionally pass a querystring to parse
	this.params = new Object()
	this.get=Querystring_get
	
	if (qs == null)
		qs=location.search.substring(1,location.search.length)

	if (qs.length == 0) return

// Turn <plus> back to <space>
// See: http://www.w3.org/TR/REC-html40/interact/forms.html#h-17.13.4.1
	qs = qs.replace(/\+/g, ' ')
	var args = qs.split('&') // parse out name/value pairs separated via &
	
// split out each name=value pair
	for (var i=0;i<args.length;i++) {
		var value;
		var pair = args[i].split('=')
		var name = unescape(pair[0])

		if (pair.length == 2)
			value = unescape(pair[1])
		else
			value = name
		
		this.params[name] = value
	}
}

function Querystring_get(key, default_) {
	// This silly looking line changes UNDEFINED to NULL
	if (default_ == null) default_ = null;
	
	var value=this.params[key]
	if (value==null) value=default_;
	
	return value
}


var MESSAGE_COLOR_DONE="#339900";
var MESSAGE_COLOR_ERROR="#FF0000";

var ALTERNATE_COLOR_NORMAL="#EEEEEE";
var ALTERNATE_COLOR="#FFFFFF";
var MOUSE_OVER_COLOR="#FFFEDD"

var UNKNOWN_EXCEPTION="<font color='"+MESSAGE_COLOR_ERROR+"'>Unknown exception</font>";
var EMAIL_NOT_UNIQUE="<font color='"+MESSAGE_COLOR_ERROR+"'>Email Address already exists, Please choose unique address</font>";

var EMAIL_NOT_SENT="<font color='"+MESSAGE_COLOR_ERROR+"'>Error occured while sending email</font>";
var EMAIL_NOT_VERIFIED="<font color='"+MESSAGE_COLOR_ERROR+"'>Invalid Email or Activation Code</font>";

var EMAIL_NOT_EXISTS="<font color='"+MESSAGE_COLOR_ERROR+"'>Email does not exist</font>";
var PASSWORD_NOT_CORRECT="<font color='"+MESSAGE_COLOR_ERROR+"'>Invalid Password</font>";
var SECRET_ANSWER_NOT_CORRECT="<font color='"+MESSAGE_COLOR_ERROR+"'>Information does not matched</font>";
var FORGET_PASSWORD_SUCCESSFUL="<font color='"+MESSAGE_COLOR_DONE+"'>You password has been sent to you via email, please check your email</font>";
var REGISTRATION_ACTIVATION_SUCCESSFUL="<table width=660 border=0 align=center cellpadding=0 cellspacing=0><tr><td>&nbsp;</td></tr><tr><td height=250 class='RegistrationBodyText' valign='top' align='center'><b><span class='RegistrationBodyText'>Congratulations!</span></b> <br>Your account has been successfully activated, <br>Now you can Sign In by clicking the following link<br><br><a href='../../CustomerSignIn.php' class='LinkSmall'>Customer Sign In</a></td></tr></table>";
var PRODUCER_PROFILE_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Your profile has been successfully updated</font>";
var CONSUMER_PROFILE_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Your profile has been successfully updated</font>";
var CUSTOMER_PASSWORD_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Password has been successfully changed</font>";
var CUSTOMER_SIGNOUT_SUCCUSSFUL='<table width="660" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td width="662">&nbsp;</td></tr><tr><td height="100" align="center" class="RegistrationBodyText">You have been Sign Out successfully!<br>Click here to <a href="/CustomerSignIn.php" class="LinkSmall">Sign In</a> again</td></tr><tr><td align="left">&nbsp;</td></tr></table>';
var PLACECAST_SUCCUSSFULLY_ADDED="<font color='"+MESSAGE_COLOR_DONE+"'>PlaceCast has been successfully created.  <a href='/PlaceCast/Producer/viewPlaceCast.php' class='LinkSmall'>View PlaceCast List</a></font>";
var PLACECAST_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>PlaceCast has been successfully Updated. <a href='/PlaceCast/Producer/viewPlaceCast.php' class='LinkSmall'>View PlaceCast List</a></font>";
var PLACECAST_SUCCESSFULLY_DELETED="<font color='"+MESSAGE_COLOR_DONE+"'>PlaceCast has been successfully Deleted</font>";
var PLACECAST_NO_RECORD_EXIST="<font color='"+MESSAGE_COLOR_ERROR+"'>No PlaceCast exists</font>";

var objQuerystring = new Querystring();

var WAYPOINT_SUCCUSSFULLY_ADDED="<font color='"+MESSAGE_COLOR_DONE+"'>Waypoint has been successfully created</font> <a href=viewWaypoint.php?id="+objQuerystring.get("id")+" class='LinkSmall'>View Waypoint List</a>";

var WAYPOINT_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Waypoint has been successfully Updated</font> <a href=viewWaypoint.php?id="+objQuerystring.get("pid")+" class='LinkSmall'>View Waypoint List</a>";
var WAYPOINT_SUCCESSFULLY_DELETED="<font color='"+MESSAGE_COLOR_DONE+"'>Waypoint has been successfully Deleted</font>";
var WAYPOINT_NO_RECORD_EXIST="<font color='"+MESSAGE_COLOR_ERROR+"'>No Waypoint exists</font>";
var CUSTOMER_SIGNIN_AUTHENTICATION_REQUIRE="<font color='"+MESSAGE_COLOR_ERROR+"'>Authentication require first</font>";
var ERROR_DOWNLOADING_PLACECAST="<font color='"+MESSAGE_COLOR_ERROR+"'>Error while downloading</font>";
var CONSUMER_ALERT_SUCCUSSFULLY_ADDED="<font color='"+MESSAGE_COLOR_DONE+"'>Alert has been successfully created.  <a href='/Alert/ConsumerAlerts/ViewConsumerAlerts.php' class='LinkSmall'>View Alert List</a></font>";
var CONSUMER_ALL_COUNRY_ERROR="<font color='"+MESSAGE_COLOR_ERROR+"'>All Counry alert already exists please select a specific country</font>";
var CONSUMER_SAME_COUNRY_ERROR="<font color='"+MESSAGE_COLOR_ERROR+"'>This Counry alert already exists please select any other country</font>";
var CONSUMER_ALERT_NO_RECORD_EXIST="<font color='"+MESSAGE_COLOR_ERROR+"'>No Alert exists</font>";
var CONSUMER_ALERT_SUCCESSFULLY_DELETED="<font color='"+MESSAGE_COLOR_DONE+"'>Alert has been successfully Deleted</font>";
var CONSUMER_ALERT_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Alert has been successfully updated.  <a href='/Alert/ConsumerAlerts/ViewConsumerAlerts.php' class='LinkSmall'>View Alert List</a></font>";
var ADMIN_EMAIL_NOT_CORRECT = "<font color='"+MESSAGE_COLOR_ERROR+"'>Email is not correct</font>";;
var ADMIN_FORGET_PASSWORD_SUCCESSFUL = "<font color='"+MESSAGE_COLOR_DONE+"'>You password has been sent to you via email, please check your email</font>";
var ADMIN_SIGNOUT_SUCCUSSFUL='<table width="660" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td width="662">&nbsp;</td></tr><tr><td height="100" align="center" class="RegistrationBodyText">You have been Signout successfully!<br>Click here to <a href="/admin/AdminSignIn.php" class="LinkSmall">SignIn</a> agian</td></tr><tr><td align="left">&nbsp;</td></tr></table>';
var ADMIN_PASSWORD_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Password has been successfully changed</font>";
var ADMIN_PASSWORD_NOT_CORRECT="<font color='"+MESSAGE_COLOR_ERROR+"'>Invalid Password</font>";

var ADMIN_PRODUCER_PROFILE_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Producer has been successfully updated</font>";

var ADMIN_CONSUMER_PROFILE_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Producer has been successfully updated</font>";

var ADMIN_EMAIL_ALREADY_EXISTS="<font color='"+MESSAGE_COLOR_ERROR+"'>Email address already exists</font>";

var PRODUCER_NO_RECORD_EXIST="<font color='"+MESSAGE_COLOR_ERROR+"'>No Producer exists</font>";

var PRODUCER_SUCCESSFULLY_DELETED="<font color='"+MESSAGE_COLOR_DONE+"'>Producer has been successfully deleted</font>";

var CONSUMER_NO_RECORD_EXIST="<font color='"+MESSAGE_COLOR_ERROR+"'>No Consumer exists</font>";

var CONSUMER_SUCCESSFULLY_DELETED="<font color='"+MESSAGE_COLOR_DONE+"'>Consumer has been successfully deleted</font>";

var ADDS_SUCCUSSFULLY_ADDED="<font color='"+MESSAGE_COLOR_DONE+"'>ADD has been successfully Added.  <a href='/Admin/Ads/ViewAds.php' class='LinkSmall'>View Adds List</a></font>";
var ADDS_ERROR="<font color='"+MESSAGE_COLOR_ERROR+"'>Unknown Exception</font>";

var ADDS_FILE_UPLOAD_ERROR="<font color='"+MESSAGE_COLOR_ERROR+"'>File Uploading Error</font>";
var ADD_SUCCESSFULLY_DELETED="<font color='"+MESSAGE_COLOR_DONE+"'>Add has been successfully Deleted</font>";

var ADD_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Add has been successfully updated.  <a href='ViewAds.php' class='LinkSmall'>View Adds List</a></font>";
var ADD_UPDATED_ERROR="<font color='"+MESSAGE_COLOR_ERROR+"'>Unknown Exception</font>";

var SMS_ALERT_SUCCUSSFULLY_ADDED="<font color='"+MESSAGE_COLOR_DONE+"'>Sms Alert has been successfully created.  <a href='/Alert/SmsAlerts/ViewSmsAlerts.php' class='LinkSmall'>View Sms Alert List</a></font>";
var SMS_ALL_COUNRY_ERROR="<font color='"+MESSAGE_COLOR_ERROR+"'>All Counry sms alert already exists please select a specific country</font>";
var SMS_SAME_COUNRY_ERROR="<font color='"+MESSAGE_COLOR_ERROR+"'>This Counry sms alert already exists please select any other country</font>";
var SMS_ALERT_SUCCESSFULLY_DELETED="<font color='"+MESSAGE_COLOR_DONE+"'>Sms Alert has been successfully Deleted</font>";
var SMS_ALERT_NO_RECORD_EXIST="<font color='"+MESSAGE_COLOR_ERROR+"'>No Sms Alert exists</font>";
var SMS_ALERT_SUCCUSSFULLY_UPDATED="<font color='"+MESSAGE_COLOR_DONE+"'>Sms Alert has been successfully updated.  <a href='/Alert/SmsAlerts/ViewSmsAlerts.php' class='LinkSmall'>View Sms Alert List</a></font>";

var PRODUCER_CONSUMER_EMAIL_NOT_UNIQUE="<font color='"+MESSAGE_COLOR_ERROR+"'>Email Address already exists either in Producer or Consumer, Please choose unique address</font>";

var PRODUCER_EMAIL_NOT_EXISTS='<table width="660" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td width="662">&nbsp;</td></tr><tr><td height="100" align="center" class="RegistrationBodyText">You are not registered as producer!<br>Click here to <a href="/Registration/ProducerRegistration/registration.php" class="LinkSmall">Sign Up</a> as producer</td></tr><tr><td align="left">&nbsp;</td></tr></table>';