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

// Check if the given id is the same and not a guest
function isMine($id1, $id2) {
	return ($id1 == $id2) && (($id1 != 0) || ($id2 != 0) );
}

function isRegisteredUser(){
	$my =& JFactory::getUser();
	return (($my->id != 0) && ($my->block !=1));
}

/**
 *  Determines if the currently logged in user is a super administrator
 **/
function isSuperAdministrator()
{
	return isCommunityAdmin();
}

/**
 * Check if a user can administer the community
 */
function isCommunityAdmin($userid = null)
{
	$my	= CFactory::getUser($userid);
	return ( $my->usertype == 'Super Administrator' || $my->usertype == 'Administrator' || $my->usertype == 'Manager' );
}