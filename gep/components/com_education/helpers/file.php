<?php
/**
 * @version		01
 * @package		Gep.Site
 * @subpackage	com_education
 * @author Nguyen Xuan Nghe - nxnghe@gmail.com
 * @copyright	Copyright (C) 2013 Prime Labo Technology. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Upload a file
 * @param	string	$source			File to upload
 * @param	string	$destination	Upload to here
 * @return True on success
 */
function cUploadFile($source, $destination)
{
	$err		= null;
	$ret		= false;

	// Set FTP credentials, if given
	jimport('joomla.client.helper');
	JClientHelper::setCredentialsFromRequest('ftp');

	// Load configurations.
	//$config		=& CFactory::getConfig();

	// Make the filename safe
	jimport('joomla.filesystem.file');

	if (!isset($source['name'])) {
		JError::raiseNotice(100, JText::_('MM INVALID FILE REQUEST'));
		return $ret;
	}

	$source['name']	= JFile::makeSafe($source['name']);

	if (is_dir($destination)) {
		jimport('joomla.filesystem.folder');
		JFolder::create( $destination, 777);

		$destination = JPath::clean($destination . DS . strtolower($source['name']));
	}

	if (JFile::exists($destination)) {
		JError::raiseNotice(100, JText::_('MM FILE EXISTS'));
		return $ret;
	}

	if (!JFile::upload($source['tmp_name'], $destination)) {
		JError::raiseWarning(100, JText::_('MM UNABLE TO UPLOAD FILE'));
		return $ret;

	} else {
		$ret = true;
		return $ret;
	}

}

/**
 * Generate new random file name with specified extension
 * create the directory if it does not exist
 *
 * @params string	$directory	Directory path
 * $params string	$filename	File name, optional
 * @params string	$extension	File extension, optional
 * $params int		$length		The length of filename
 * @return string	File name with extension
 * @since Jomsocial 1.2.0
 */
function cGenRandomFilename($directory, $filename = '' , $extension = '', $length = 11)
{
	if (strlen($directory) < 1)
		return false;

	$directory = JPath::clean($directory);

	// Load configurations.
	//$config		=& CFactory::getConfig();
	jimport('joomla.filesystem.file');
	jimport('joomla.filesystem.folder');

	if (!JFile::exists($directory))
		JFolder::create( $directory, 777 );

	if (strlen($filename) > 0)
		$filename	= JFile::makeSafe($filename);

	if (!strlen($extension) > 0)
		$extension	= '';

	$dotExtension 	= $filename ? JFile::getExt($filename) : $extension;
	$dotExtension 	= $dotExtension ? '.' . $dotExtension : '';

	$map			= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$len 			= strlen($map);
	$stat			= stat(__FILE__);
	$randFilename	= '';

	if(empty($stat) || !is_array($stat))
		$stat = array(php_uname());

	mt_srand(crc32(microtime() . implode('|', $stat)));
	for ($i = 0; $i < $length; $i ++) {
		$randFilename .= $map[mt_rand(0, $len -1)];
	}

	$randFilename .= $dotExtension;

	if (JFile::exists($directory . DS . $randFilename)) {
		cGenRandomFilename($directory, $filename, $extension, $length);
	}

	return $randFilename;
}