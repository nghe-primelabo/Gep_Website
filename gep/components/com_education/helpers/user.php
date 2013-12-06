<?php
/**
 * @category	Helper
 * @package		Contestants
 */
defined('_JEXEC') or die('Restricted access');

function cGetUserId( $username )
{
	$db		=& JFactory::getDBO();
	$query	= 'SELECT ' . $db->nameQuote( 'id' ) . ' '
			. 'FROM ' . $db->nameQuote( '#__users' ) . ' '
			. 'WHERE ' . $db->nameQuote( 'username' ) . '=' . $db->Quote( $username );

	$db->setQuery( $query );

	$id		= $db->loadResult();

	return $id;
}

function cGetUserThumb( $userId , $imageClass = '' , $anchorClass = '' )
{
	$db =& JFactory::getDBO();

	$db =& JFactory::getDBO();

	//Get the detail information of the candidate
	$query = "SELECT c.full_name, c.thumb, c.userid FROM #__contestants_candidates as c where c.userid = '" . $userId . "' and c.published = '1' ";
	$db->setQuery( $query );
	//echo $db->getQuery( $query );
	$user_infor = $db->loadObject();
	$user_thumb = ($user_infor->thumb!='')?JURI::base().$user_infor->thumb:JURI::base().'images/contestantsavatar/default_thumb.png';

	$data	= '<a href="' . CRoute::_('index.php?option=com_contestants&view=condetail&layout=condetail&userid=1762' . $user_infor->userid ) . '"' . $anchorClass . '>';
	$data	.= '<img width="45px" height="45px" style="float:left" src="' . $user_thumb . '" alt="' . $user_infor->full_name . '"' . $imageClass . ' />';
	$data	.= '</a>';

	return $data;
}

function cValidUsername( $username )
{
	return (!preg_match( "/[<>\"'%;()&]/i" , $username ) && JString::strlen( $username )  > 2 );
}