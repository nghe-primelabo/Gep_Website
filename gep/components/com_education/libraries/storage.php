<?php
/**
 * @copyright (C) 2010 Multimedia JSC - All rights reserved!
 * @license Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.file' );

require_once( JPATH_ROOT . DS  . 'components' . DS . 'com_contestants' . DS . 'libraries' . DS . 'storage' . DS . 's3.php' );
require_once( JPATH_ROOT . DS  . 'components' . DS . 'com_contestants' . DS . 'libraries' . DS . 'storage' . DS . 'file.php' );

class CStorage
{
	function getStorage($type = 'file')
	{
		$classname = ucfirst($type) . '_CStorage';
		$obj = new $classname();
		$obj->_init();
		return $obj;
	}
}


class CStorageMethod
{
	/**
	 * Put a resource into a remote storage.
	 * Return true if successful
	 */
	function put()
	{
	}

	function exists()
	{
	}

	/**
	 * Retrive the entire resource locally
	 */
	function get($uri)
	{
	}

	function getURI(){}

	function read(){}
	function write(){}
	function delete(){}
	function getExt(){}
}


