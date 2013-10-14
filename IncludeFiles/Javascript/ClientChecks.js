<!--
// Global Variables...

var win_ie_ver
var _editor_url
var imgWin=null;
/*
=================================================================================
	Function Name : trim
	Synopsis	  : trims text
	Created On    : 19-Oct-2002 
=================================================================================
*/

	function trim(text)
	{
		return rTrim(lTrim(text));
	}

/*
=================================================================================
		Function Name : lTrim
		Synopsis	  : Left trims text
		Created On    : 19-Oct-2002 
=================================================================================
*/

	function lTrim(text)
	{
		var i=0;
		var theValue=new String(text);
		while(theValue.charAt(i)==' ')	{	i=i+1;	}
		return theValue.substring(i,theValue.length);
	}
	
/*
=================================================================================
		Function Name : rTrim
		Synopsis	  : right trims text
		Created On    : 19-Oct-2002 
=================================================================================
*/
	function rTrim(text)
	{
		var theValue=new String(text);
		var i=theValue.length-1;
		while(theValue.charAt(i)==' '){	i=i-1;	}
		return theValue.substring(0,i+1);
	}

/*
=================================================================================
		Function Name : isValidAlphaNumeric
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/
	function isValidAlpha(theValue,fieldName)
	{
		var chr;
		theValue=trim(theValue);
		for(var i=0;i<theValue.length;i++)
		{
			chr=theValue.charAt(i)
			if( !( (chr>='A' &&  chr <= 'Z' ) || (chr>='a' &&  chr <= 'z'  ) ) )
			{
				alert(fieldName+" contains invalid character '"+chr+"'");
				return false;
			} // end of if
		} // end of for
		
		return true;
	}
/*
=================================================================================
		Function Name : isValidAlphaSpace(theValue,fieldName)
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/
	function isValidAlphaSpace(theValue,fieldName)
	{
		var chr;
		theValue=trim(theValue);
		for(var i=0;i<theValue.length;i++)
		{
			chr=theValue.charAt(i)
			// As City, state can contain space....
			if(chr==' ')
			{
			
			}
			else if( !( (chr>='A' &&  chr <= 'Z' ) || (chr>='a' &&  chr <= 'z'  ) ) )
			{
				alert(fieldName+" contains invalid character '"+chr+"'");
				return false;
			} // end of if
		} // end of for
		
		return true;
	}


	
/*
=================================================================================
		Function Name : isValidAlphaNumeric
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/

	function isValidAlphaNumeric(theValue,fieldName)
	{
		var chr;
		for(var i=0;i<theValue.length;i++)
		{
			chr=theValue.charAt(i)
			if( !( (chr>='A' &&  chr <= 'Z') || (chr>='a' &&  chr <= 'z') || (chr>='0' &&  chr <= '9') || (chr=='-') || (chr=='_') || chr==' ' ) )
			{
				alert(fieldName+" contains invalid character '"+chr+"'");
				return false;
			} // end of if
		} // end of for
		
		return true;
	}

/*
=================================================================================
		Function Name : isValidPassword
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/

	function isValidPassword(theValue,fieldName)
	{
		var chr;
		for(var i=0;i<theValue.length;i++)
		{
			chr=theValue.charAt(i)
			if( !( (chr>='A' &&  chr <= 'Z') || (chr>='a' &&  chr <= 'z') || (chr>='0' &&  chr <= '9') || (chr=='-') || (chr=='_') ) )
			{
				alert(fieldName+" contains invalid character '"+chr+"'");
				return false;
			} // end of if
		} // end of for
		
		return true;
	}


/*
=================================================================================
		Function Name : isValidPhone(theValue,fieldName)
		Synopsis	  : check that passed value contain Valid Phone 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/
	function isValidPhone(theValue,fieldName)
	{
		var chr;
		for(var i=0;i<theValue.length;i++)
		{
			chr=theValue.charAt(i)
			if( !( (chr>='0' &&  chr <= '9') || (chr=='-')  ) )
			{
				alert(fieldName+" contains invalid character '"+chr+"'");
				return false;
			} // end of if
		} // end of for
		
		return true;
	}
	
	
/*
=================================================================================
		Function Name : isValidNumeric(theValue,fieldName)
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/
	function isValidNumeric(theValue,fieldName)
	{
		var chr;
		theValue=trim(theValue);
		for(var i=0;i<theValue.length;i++)
		{
			chr=theValue.charAt(i)
			if( !(chr>='0' &&  chr <= '9') )
			{
				alert(fieldName+" contains invalid character '"+chr+"'");				return false;
			} // end of if
		} // end of for
		
		return true;
	}
	
/*
=================================================================================
		Function Name : isValidPositiveInteger(theValue)
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/

	function isValidPositiveInteger(theValue)
	{
		var chr;
		theValue=trim(theValue);
		for(var i=0;i<theValue.length;i++)
		{
			chr=theValue.charAt(i)
			if( !(chr>='0' &&  chr <= '9') )
			{
				return false;
			} // end of if
		} // end of for
		if(theValue<0)
		{
			return false;
		}
		return true;
	}

/*
	=================================================================================
		Function Name : isValidDecimal(theValue,fieldName)
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/
	function isValidDecimal(theValue,fieldName)
	{

		var count_point=0
		var count_minus=0
		
		for(var i=0;i<theValue.length;i++)
		{	
			chr=theValue.charAt(i)

			if (chr>='0' &&  chr<='9')
			{
			
			}
			else if (chr=='.')
			{
				count_point=count_point + 1
			}	
			else if(chr=='-')
			{
				count_minus=count_minus+1
			}
			else
			{
				alert(fieldName+" contains invalid character");
				return false;				
			}
			
			if (count_point > 1 )
			{
				alert(fieldName+" contains invalid values");
				return false; 
			}	 	 

			if (count_minus > 1 )
			{
				alert(fieldName+" contains invalid values");
				return false; 
			}	 	 

		}
		return true; 
	}
	
/*
=================================================================================
		Function Name : isValidAlphaNumeric
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/
	function isValidZip(theValue,fieldName,countryId)
	{
		theValue=trim(theValue);
		var chr;
		// For USA, zip code must be 5 characters long.
		if(countryId==1)
		{
			if(theValue.length!=5)
			{
				alert("Invalid Postal code.");
				return false;
			}
		
		
			for(var i=0;i<theValue.length;i++)
			{
				chr=theValue.charAt(i)
				if((chr>='0' &&  chr <= '9') ) 
				{
	
				}
				else
				{
					alert(fieldName+" contains invalid character '"+chr+"'");				
					return false;
	
				}
				 // end of if
			} // end of for
		} // end if
		else
		{
			for(var i=0;i<theValue.length;i++)
			{
				chr=theValue.charAt(i)
				if((chr>='0' &&  chr <= '9') ) 
				{
	
				}
				else if(( (chr>='A' &&  chr <= 'Z' ) || (chr>='a' &&  chr <= 'z'  ) ) )
				{
			
				}
				else
				{
					alert(fieldName+" contains invalid character '"+chr+"'");				
					return false;
				}
				 // end of if
			} // end of for

		}
		
		return true;
	}
	
/*
=================================================================================
		Function Name : isValidAlphaNumeric
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/

	function isValidDate(sDate)
	{
		sDate=trim(sDate);
		if (sDate == "") return true;
		var iDay, iMonth, iYear;
		var arrValues;
		var today = new Date();
		arrValues = sDate.split("/");
		iYear=arrValues[2];
		iMonth = arrValues[0];
		iDay = arrValues[1];
				 
		if ((iMonth == null) || (iYear == null)) return false;
		if ((iDay > 31) || (iMonth > 12) || 
			(iYear < 1900 || iYear > today.getFullYear())) 
		return false;
		/*var dummyDate = new Date(iYear, iMonth - 1, iDay);
		if ((dummyDate.getDate() != iDay) || 
		(dummyDate.getMonth() != iMonth - 1) || 
		(dummyDate.getFullYear() != iYear)) 
			return false;
			*/
		return true;
		
	}
	
/*
=================================================================================
		Function Name : checkEmailAddress(email)
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/

	function checkEmailAddress(email)
	{
		
		for (var i = 0; i < email.length; i++)
		{
			var chr = email.charAt(i);

			if (!(((chr >= 'a') && (chr <= 'z')) || ((chr >= 'A') && (chr <= 'Z')) ||
				(chr == '.') || (chr == '@') || (chr == '_') || (chr == '-') ||
				((chr >= '0') && (chr <= '9'))))
			{
				alert("Invalid Email address '" + email + "'.");
				return false;
			}
		}
		if ((email == "") || (email.indexOf('@', 0) == -1) ||
			(email.indexOf('@', 0) == 0) || (email.indexOf('.', 0) == -1) ||
			(email.indexOf('.', 0) == (email.length - 1)) ||
			(email.indexOf('@', 0) == (email.length - 2)) ||
			(email.charAt(0) == '.') || (email.charAt(email.length - 1) == '.'))
		{
			alert("Invalid Email address '" + email + "'.");
			return false;
		}
		// Added by Riz... 241201 checking for invalid emails due to '.' placement
		var temp = email.substring(email.indexOf('@', 0) + 1, email.length);

		if (temp.length > 2)
		{
			if (temp.indexOf('.', 1) == -1)
			{
				alert("Invalid Email address '" + email + "'.");
				return false;
			}
			else
			{
				if (temp.indexOf('.', 1) == temp.length - 1)
				{
					alert("Invalid Email address '" + email + "'.");
					return false;
				}
			}
		}
		else
		{
			alert("Invalid Email address '" + email + "'.");
			return false;
		}

		var charIndex = email.indexOf('@', 0);
		if (email.indexOf('@', charIndex + 1) != -1)
		{
			alert("Invalid Email address '" + email + "'.");
			return false;
		}
		else
		{
			charIndex = email.indexOf('@', 0);
			if (email.charAt(charIndex - 1) == '.')
			{
				alert("Invalid Email address '" + email + "'.");
				return false;
			}
		}
		// This case checks that 2 dots can't be consective
		var previousChar;
		var currentChar;

		for (var i = 0; i < email.length; i++)
		{
			currentChar = email.charAt(i);
			if (currentChar == '.')
			{
				if (currentChar == previousChar)
				{
					alert("Invalid Email address '" + email + "'.");
					return false;
				}
			}
			previousChar = currentChar;
		}
		return true;
	}
/*
=================================================================================
		Function Name : check4CookieSupport()
		Synopsis	  : Check for cookie support. If cookie support is disbled then 
						redirect user to "CookieError.aspx".
		Created On    : 31-May-2003
		Author		  : Yassar 
		Returns		  : 
=================================================================================
*/

	function check4CookieSupport()
	{
		document.cookie="test";
		if(document.cookie.indexOf("test")<0)
		{
			location.href="CookieError.php";
			
		}
/*		var cookieEnabled=(navigator.cookieEnabled)? true : false

		//if not IE4+ nor NS6+
		if (typeof navigator.cookieEnabled=="undefined" && !cookieEnabled)
		{ 
			document.cookie="testcookie"
			cookieEnabled=(document.cookie.indexOf("testcookie")!=-1)? true : false
		}

		//if cookies are enabled on client's browser
		if (cookieEnabled==false) 
		{
			location.href="/CookiesError.aspx";
		}*/

	}
	
/*
=================================================================================
		Function Name : isValidAlphaNumeric
		Synopsis	  : check that passed value contain only alphanumeric charaters 
		Created On    : 19-Oct-2002 
		Returns		  : returns a boolean value indivating wether invalid charater is 
						found or not.
=================================================================================
*/
	function verifyCreditCard(CreditCard)
	{
		
		temp = new String(trim(CreditCard.value));
		if ((temp.length < 14) || isNaN(CreditCard.value) ||(temp.substr(0, 1) < "3") || (temp.substr(0, 1) > "6"))
		{
			alert("Please provide a valid credit card number.");
			CreditCard.select();
			return false;
		}
	
	return true;
	}	// End of function
	

	function printDocument(url)
	{
		window.open(url,"Print","url=0,location=0,status=1,directories=0,scrollbars=1,fullscreen=0,menubar=1,resizeable=1,toolbar=1,maximize=1");
		return false;
	}
	function emailDocument(url)
	{
		//top.frames["main"].location.href = "http://localhost/ArtResources/ComposeEmail.aspx"
		top.frames["main"].location.href = url;
		return false;
	}
	//-->
		
