<?php
set_error_handler('errorHandler');
function errorHandler ($errno, $errstr, $errfile, $errline, $errcontext)
// If the error condition is E_USER_ERROR or above then abort
{
   switch ($errno)
   {
      case E_USER_WARNING:
      case E_USER_NOTICE:
      case E_WARNING:
      		//echo ($errstr);
      		break;
      case E_NOTICE:
      case E_CORE_WARNING:
      case E_COMPILE_WARNING:
	         break;
      case E_USER_ERROR:
      		echo ($errstr);
      		break;
      case E_ERROR:
      		echo ($errstr);
      		break;
      case E_PARSE:
      case E_CORE_ERROR:
      		echo ($errstr);
      		break;
      case E_COMPILE_ERROR:
  				         global $query;
   				         session_start();
				         if (eregi('^(sql)$', $errstr))
						 {
				            $errstr = "MySQL error: $MYSQL_ERRNO : $MYSQL_ERROR";
				            $MYSQL_ERRNO = mysql_errno();
				            $MYSQL_ERROR = mysql_error();
				         } 
						 else 
						 {
			         	   $query = NULL;
				         } 
         
				         echo "<h2>This system is temporarily unavailable</h2>\n";
				         echo "<b><font color='red'>\n";
				         echo "<p>Fatal Error: $errstr (# $errno).</p>\n";
				         if ($query) echo "<p>SQL query: $query</p>\n";
				         echo "<p>Error in line $errline of file '$errfile'.</p>\n";
				         echo "<p>Script: '{$_SERVER['PHP_SELF']}'.</p>\n";
				         echo "</b></font>";
         
				         session_unset();
				         session_destroy();
				         die();
      default:
	         break;
   } 
   
} 
?>