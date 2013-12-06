<?php

class JAXResponseContestant
{

	var $_response = null;

	function JAXResponseContestant(){
		//echo "nghe";exit;
		$this->_response = array();
	}

	function object_to_array($obj) {
       $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
       $arr = array();
       foreach ($_arr as $key => $val) {
               $val = (is_array($val) || is_object($val)) ? $this->object_to_array($val) : $val;
               $arr[$key] = $val;
       }
       return $arr;
	}

	/**
	 * Assign new sData to the $sTarget's $sAttribute property
	 */
	function addAssign($sTarget,$sAttribute,$sData){
		//$sData = $this->_hackString($sData);
		//$sData = preg_replace("((\r\n)+)", '', $sData);
		//echo "nghe";exit;
		$this->_response[] = array('as', $sTarget, $sAttribute, $sData);
	}

	/**
	 * Clear the given target property
	 */
	function addClear($sTarget,$sAttribute){
		$this->_response[] = array('as', $sTarget, $sAttribute, "");
	}

	function addCreate($sParent, $sTag, $sId, $sType=""){
		$this->_response[] = array('ce', $sParent, $sTag, $sId);
	}

	function addRemove($sTarget){
		$this->_response[] = array('rm', $sTarget);
	}

	/**
	 * Assign new sData to the $sTarget's $sAttribute property
	 */
	function addAlert($sData){
		$this->_response[] = array('al', "", "", $sData);
	}

	function _hackString($str){
		# Convert '{' and '}' to 0x7B and 0x7D
	    //$str = str_replace(array('{', '}'), array('&#123;', '&#125;'), $str);
		return $str;
	}

	/**
	 * Add a script call
	 */
	function addScriptCall($func){
		$size = func_num_args();
		$response = "";

		if($size > 1){
			$response = array();

			for ($i = 1; $i < $size; $i++) {
				$arg = func_get_arg($i);
				$response[] = $arg;
			}
		}


		$this->_response[] = array('cs', $func, "", $response);
	}

	function encodeString($contents){
	    $ascii = '';
	    $strlen_var = strlen($contents);

	   /*
	    * Iterate over every character in the string,
	    * escaping with a slash or encoding to UTF-8 where necessary
	    */
	    for ($c = 0; $c < $strlen_var; ++$c) {

	        $ord_var_c = ord($contents{$c});

	        switch ($ord_var_c) {
	            case 0x08:  $ascii .= '\b';  break;
	            case 0x09:  $ascii .= '\t';  break;
	            case 0x0A:  $ascii .= '\n';  break;
	            case 0x0C:  $ascii .= '\f';  break;
	            case 0x0D:  $ascii .= '\r';  break;

	            default:
	                $ascii .= $contents{$c};
	          }
	    }


	    return $ascii;

	    //return $this->_hackString($ascii);
	}

	/**
	 * Flush the output back
	 */
	function sendResponse(){


		$obEnabled  = ini_get('output_buffering');

		if($obEnabled == "1" || $obEnabled == 'On')
		{
			$ob_active = ob_get_length () !== FALSE;
			if($ob_active)
			{
				while (@ ob_end_clean());
					if(function_exists('ob_clean'))
					{
						@ob_clean();
					}
			}
			ob_start();
		}

		// Send text/html if we're using iframe
		if(isset($_GET['func']))
		{
			$iso		= '';

			if( azrulGetJoomlaVersion() == '1.5' )
			{
				$iso	= 'UTF-8';
			}
			else
			{
				global $mainframe;

				$lang   = 'english';

				// loads english language file by default
				if ($mainframe->getCfg('lang') != '')
				{
				    $lang   =& $mainframe->getCfg('lang');
				}

				// If the $lang is still empty, force it to be english
				if($lang == '' || empty($lang))
					$lang   = 'english';

				include_once( JAX_SITE_ROOT . '/language/' . $lang . '.php' );

				$iso	= explode( '=' , _ISO );
			}
			header("Content-type: text/html; $iso");
		}else
			header('Content-type: text/plain');

		if(!defined('SERVICES_JSON_SLICE'))
		include_once(JPATH_ROOT . DS . 'components' . DS . 'com_contestants' . DS . 'assets' .DS. 'JSON.php');

		$json = new Services_JSON();

		# Encode '{' and '}' characters

		# convert a complex value to JSON notation
		$output = $json->encode($this->_response);

		if(isset($_GET['func']))
			$output = "<body onload=\"parent.jax_iresponse();\">" . htmlentities($output). "</body>";
		echo(($output));
		exit;
	}
}

