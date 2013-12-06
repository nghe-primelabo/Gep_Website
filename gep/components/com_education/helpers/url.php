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

class CUrl {

	function build($view , $task = '' , $keys = null , $route = true )
	{
		// View cannot be empty. Assertion must be included here.
		CError::assert( $view , '' , '!empty' , __FILE__ , __LINE__ );

		$url	= 'index.php?option=com_contestants&view=' . $view;

		// Task might be optional
		$url	.= ( !empty($task) ) ? '&task=' . $task : '';

		if( !is_null( $keys ) && is_array( $keys ) )
		{
			foreach( $keys as $key => $value )
			{
				$url	.= '&' . $key . '=' . $value;
			}
		}

		// Test if it needs JRoute
		if( $route )
		{
			return CRoute::_( $url );
		}

		return $url;
	}

	function test()
	{
		return 'CUrl::test()';
	}
}

/**
 * Create a link to a user profile
 *
 * @param	id		integer		ther user id
 * @param	route   bool		do we want to wrap it with Jroute func ?
 */
function cUserLink($id, $route = true){
	return CRoute::_('index.php?option=com_contestants&view=profile&userid='.$id);
}

/**
 * Create a link to a group page
 *
 * @param	id		integer		ther user id
 * @param	route   bool		do we want to wrap it with Jroute func ?
 */
function cGroupLink($id, $route = true){
	$url = 'index.php?option=com_contestants&view=groups&task=viewgroup&groupid='.$id;
	if($route) $url = CRoute::_($url);
	return $url;
}
