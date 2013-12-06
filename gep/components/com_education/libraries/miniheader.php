<?php
/**
 * @category	Library
 * @package		Contestants
 * @subpackage	user
 * @copyright (C) 2010 By Multimedia JSC - All rights reserved!
 * @license Copyrighted Commercial Software
 */
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT . DS . 'components' . DS . 'com_contestants' . DS . 'libraries' . DS . 'core.php' );

class CMiniHeader
{

	function load()
	{
		$jspath = JPATH_BASE.DS.'components'.DS.'com_contestants';
		include_once($jspath.DS.'libraries'.DS.'core.php');
		include_once($jspath.DS.'libraries'.DS.'template.php');
		//$config	=& CFactory::getConfig();

		$js = '/assets/window-1.0';
		$js	.= '.js';
		CAssets::attach($js, 'js');

		$js = '/assets/script-1.2';
		$js	.= '.js';
		CAssets::attach($js, 'js');

		$css = '/assets/window.css';
		CAssets::attach($css, 'css');

		CFactory::load( 'libraries' , 'template' );
		CTemplate::addStyleSheet( 'style' );
	}

	function showMiniHeader($userId)
	{
		CMiniHeader::load();
		//CFactory::load( 'helpers' , 'friends' );
		//CFactory::load( 'helpers' , 'owner' );
		$option		= JRequest::getVar( 'option', '' , 'REQUEST' );
		$lang		=& JFactory::getLanguage();
		$lang->load( 'com_contestants' );

	    $my 	= CFactory::getUser();

	    if ( !empty( $userId ) )
		{
			$user 			= CFactory::getUser( $userId );

			//CFactory::load( 'libraries' , 'messaging' );
			//$sendMsg	= CMessaging::getPopup ( $user->id );
        	$tmpl		= new CTemplate();
        	$tmpl->set( 'my' 		, $my);
        	$tmpl->set( 'user' 		, $user);
        	$tmpl->set( 'isMine'	, isMine($my->id, $user->id));
        	//$tmpl->set( 'sendMsg'	, $sendMsg );
        	//$tmpl->set( 'config'	, $config );
        	//$tmpl->set( 'isFriend'	, friendIsConnected ( $user->id, $my->id ) && $user->id != $my->id );

        	$showMiniHeader = $option=='com_contestants' ? $tmpl->fetch('profile.miniheader') : '<div id="community-wrap" style="min-height:50px;">' . $tmpl->fetch('profile.miniheader') . '</div>' ;

        	return $showMiniHeader;
        }
	}

	function showGroupMiniHeader( $groupId )
	{
		CMiniHeader::load();

		$option		= JRequest::getVar( 'option', '' , 'REQUEST' );
		$lang		=& JFactory::getLanguage();
		$lang->load( 'com_contestants' );

		//CFactory::load( 'models' , 'groups' );

		//$group		=& JTable::getInstance( 'Group' , 'CTable' );
		//$group->load( $groupId );
		$my 		= CFactory::getUser();


	    if ( !empty( $group->id ) && $group->id != 0 )
		{
        	$isMember	= $group->isMember($my->id);
			$config		=& CFactory::getConfig();
			$tmpl		= new CTemplate();
        	$tmpl->set( 'my' 		, $my );
        	$tmpl->set( 'group' 	, $group );
        	$tmpl->set( 'isMember'	, $isMember );
        	$tmpl->set( 'config'	, $config );

        	$showMiniHeader = $option=='com_contestants' ? $tmpl->fetch('groups.miniheader') : '<div id="community-wrap" style="min-height:50px;">' . $tmpl->fetch('groups.miniheader') . '</div>' ;

        	return $showMiniHeader;
        }
	}

}