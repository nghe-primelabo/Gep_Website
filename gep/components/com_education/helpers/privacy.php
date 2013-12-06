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
 * Translate Permission Value to Text
 *
 * @param	int		$permissions
 * @return	string	Permission type
 */
function cFormatPermissions($permissions = null)
{
	switch ((int) $permissions)
	{
		case '0':
			$nicePermissions = JText::_('MM PRIVACY PUBLIC');
			break;
		case '20':
			$nicePermissions = JText::_('MM PRIVACY SITE MEMBERS');
			break;
		case '30':
			$nicePermissions = JText::_('MM PRIVACY FRIENDS');
			break;
		case '40':
			$nicePermissions = JText::_('MM PRIVACY ME');
			break;
		default:
			$nicePermissions = JText::_('MM PERMISSIONS NOT DEFINED');
	}

	return $nicePermissions;
}