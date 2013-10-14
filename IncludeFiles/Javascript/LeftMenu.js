function tmenudata0()
{
		/*---------------------------------------------
		Image Settinngs (icons and plus minus symbols)
		---------------------------------------------*/
		this.imgage_gap = 3			//The image gap is applied to the left and right of the folder and document icons.
							//In the absence of a folder or document icon the gap is applied between the
							//plus / minus symbols and the text only.
	
		this.plus_image = "/imageFiles/"+ strSkin + "/sample1_main_icon_default.gif"	//specifies a custom plus image.
		this.minus_image = "/imageFiles/"+ strSkin+ "/sample1_main_icon_open.gif"		//specifies a custom minus image.
		this.pm_width_height = "16,16"					//Width & Height  - Note: Both images must be the same dimensions.
	
		//this.folder_image = "folder.gif"				//Automatically applies to all items which may be expanded.
		this.document_image = "/imageFiles/"+ strSkin+ "/sample1_sub_icon.gif"		//Automatically applies to all items which are not expandable.
		this.icon_width_height = "7,7"					//Width & Height  - Note: Both images must be the same dimensions.

		/*---------------------------------------------
		General Settings
		---------------------------------------------*/
		this.indent = 15;			//The indent distance in pixels for each level of the tree.
		this.use_hand_cursor = true;		//Use a hand mouse cursor for expandable items, or the default arrow.
	
	
		/*---------------------------------------------
		Tree Menu Styles
		---------------------------------------------*/
		this.main_item_styles =        "text-decoration:none; 			       		\
										   font-weight:bold;			           	\
										   font-family:Arial;			           	\
										   font-size:12px;			               		\
										   color:"+strMainMenuColor+ ";			               		\
										   background-image:url(/imageFiles/"+strSkin+"/sample1_main_bg.gif); 	\
										   "
	
	
			this.sub_item_styles =         "text-decoration:none;					\
										   padding:0;						\
										   font-weight:normal;					\
										   background-image:url(/ImageFiles/we/pix_trans.gif);						   \
										   font-family:Arial;					\
										   font-size:12px;						\
										   color:#333366;"
	
	
	
		/* Styles may be formatted as multi-line (seen above), or on a single line as shown below.
		   The expander_hover_styles apply to menu items which expand to show child menus.*/



		this.main_container_styles = ""
		this.sub_container_styles = "background-image:url(/imageFiles/"+strSkin+"/sample1_sub_bg.gif); padding-top:5px; padding-bottom:5px; background-color:#044c9a;"
	
		this.main_link_styles = "color:"+strMainMenuColor+"; text-decoration:none; padding:2;"
		this.main_link_hover_styles = "padding:2; background-color:#dfb265; color:" + strMainMenuColor +"; opacity: .7; filter: alpha(opacity=70); -moz-opacity: .7;"
	
	
		this.sub_link_styles = "color:"+strSubMenuColor+"; font-size:11px;"
		this.sub_link_hover_styles = "color:"+strSubMenuColor+";text-decoration:underline; opacity: .7; filter: alpha(opacity=70); -moz-opacity: .7;"
	
	
		this.main_expander_hover_styles = "color:"+strMainMenuColor+";text-decoration:underline"
	
		this.sub_expander_hover_styles = "background-color:#044c9a;color:"+strSubMenuColor+";text-decoration:underline; opacity: .7; -moz-opacity: .7;"
}