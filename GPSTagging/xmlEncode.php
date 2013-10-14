<?php
/*
 * -File        $Id: xmlencode.php,v 1.1 2004/09/03 17:46:04 amadeus Exp $
 * -License     LGPL (http://www.gnu.org/copyleft/lesser.html)
 * -Copyright   2004, Nexista
 * -Author      joshua savage, js@nexista.com
 */

 

/**
 * This class provides xml encoding functionality. It basically provides
 * translation utilities for xml forbidden characters (&,< in cdata, tags 
 * that start with digits, etc...). It is used mostly to be able to output 
 * xml from things like Flow which may have a lot of non-xml data in it.
 *
 */

 
class XmlEncode
{

    /**
     * Cdata translation array
     *
     * @var         array
     * @access      private
     */
     
    var $cdataTranslate = array();
    
    
    /**
     * Tag name translation array
     *
     * @var         array
     * @access      private
     */
     
    var $tagTranslate = array();
    
    
    /**
     * Attribute name translation array
     *
     * @var         array
     * @access      private
     */
     
    var $attribTranslate = array();
    
    
    /**
     * Flag to strip instead of translate certain characters (cdata mostly)
     *
     * @var         boolean
     * @access      private
     */
     
    var $tagStrip = true;
    
    
     
    /**
     * Constructor - inits translations arrays
     *
     */
     
    function XmlEncode()
    {
         $this->initTransTables();   
    
    }
      
    /**
     * Inits translations arrays
     *
     */
     
    function initTransTables()
    {
    
        $this->cdataTranslate = array(
        '<' => '&lt;',
        '&nbsp;' => '&#160;',
        '&' => '&amp;'
        );
        
        //build cdata translation array
        for ($i=127; $i<255; $i++)
        {

            if(!$this->tagStrip)
            {
                $this->cdataTranslate[chr($i)] = "&#" . $i . ";";

            }
            else
            { 
                $this->cdataTranslate[chr($i)] = "";
            }

        }
        
        //build tag translation
        $this->tagTranslate = array(
        '0' => '_0',
        '1' => '_1',
        '2' => '_2',
        '3' => '_3',
        '4' => '_4',
        '5' => '_5',
        '6' => '_6',
        '7' => '_7',
        '8' => '_8',
        '9' => '_9'
        );
       
    
    }
    
    
    /**
     * This method encodes tags to be xml safe
     *
     * @param    string - tag name
     * @return    string - safe tag name
     */
     
    function xmlTagEncode($val)
    {    
        //kill stuff
        $val = preg_replace("|\W|", "", $val);
        
        //translate what we can
        $val = strtr($val, $this->tagTranslate);
        
        return $val; 
      
    }
    
    
    /**
     * This method encodes cdata to be xml safe
     *
     * @param    string - cdata
     * @return    string - safe cdata
     */
     
    function xmlCdataEncode($val)
    {  
   
        $val = strtr($val, $this->cdataTranslate);
        
        return $val;
    
    }
    
    
    /**
     * This method encodes attribute names to be xml safe
     *
     * @param    string - attrib name
     * @return    string - safe attrib name
     */
     
    function xmlAttribEncode()
    {
         return strtr($val, $this->attribTranslate);    
    }

}





?>