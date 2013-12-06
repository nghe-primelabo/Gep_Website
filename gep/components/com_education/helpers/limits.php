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

function cExceededPhotoUploadLimit( $id , $type = PHOTOS_USER_TYPE )
{
	// Get the configuration for uploader tool
	$config			=& CFactory::getConfig();
	$model			=& CFactory::getModel( 'photos' );
	$photoLimit		= $config->get( 'photouploadlimit' );

	if( $type == PHOTOS_GROUP_TYPE )
		$photoLimit	= $config->get('groupphotouploadlimit');

	$totalPhotos	= $model->getPhotosCount( $id , $type );

	if( $totalPhotos >= $photoLimit && $photoLimit != 0 )
	{
		return true;
	}

	return false;
}

function cExceededGroupCreationLimit( $userId )
{
	// Get the configuration for group creation
	$config		=& CFactory::getConfig();
	$model		=& CFactory::getModel( 'groups' );

	$groupLimit	= $config->get('groupcreatelimit');
	$totalGroup	= $model->getGroupsCreationCount($userId);

	if($totalGroup >= $groupLimit && $groupLimit != 0 )
	{
		return true;
	}

	return false;
}

function cExceededVideoUploadLimit( $userId, $type = VIDEO_USER_TYPE )
{
	//$config		=& CFactory::getConfig();
	$model		=& CFactory::getModel( 'videos' );

	if( $type == VIDEO_GROUP_TYPE )
	{
		$videoLimit	= 50;
		$totalVideos= $model->getVideosCount( $userId , VIDEO_GROUP_TYPE );
	} else {
		$videoLimit	= 50;
		$totalVideos= $model->getVideosCount( $userId , VIDEO_USER_TYPE );
	}

	if( $totalVideos >= $videoLimit && $videoLimit != 0 )
	{
		return true;
	}

	return false;
}