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

if(JFile::exists(JPATH_ROOT . DS . 'components' . DS . 'com_contestants' . DS . 'libraries' . DS . 'advancesearch.php'))
	require_once( JPATH_ROOT . DS . 'components' . DS . 'com_contestants' . DS . 'libraries' . DS . 'advancesearch.php' );


if(! defined('TOOLBAR_HOME'))
	define( 'TOOLBAR_HOME', 'HOME');

if(! defined('TOOLBAR_PROFILE'))
	define( 'TOOLBAR_PROFILE', 'PROFILE');

if(! defined('TOOLBAR_FRIEND'))
	define( 'TOOLBAR_FRIEND', 'FRIEND');

if(! defined('TOOLBAR_APP'))
	define( 'TOOLBAR_APP', 'APP');

if(! defined('TOOLBAR_INBOX'))
	define( 'TOOLBAR_INBOX', 'INBOX');


class CToolbar {
	var $_toolbar		= array();

	function CToolbar(){

		$my	=& JFactory::getUser();
		$userId = JRequest::getVar('userid', 0, 'request', 'int');
		$task_new = JRequest::getVar('newtask');
		$task_new = 'topcan';

		$this->_toolbar	= array(
							TOOLBAR_PROFILE => null,
							TOOLBAR_PHOTO	 	=> null

						);


		//$config		=& CFactory::getConfig();

		$mySQLVer	= 0;
		if(JFile::exists(JPATH_ROOT . DS . 'components' . DS . 'com_contestants' . DS . 'libraries' . DS . 'advancesearch.php'))
			$mySQLVer	= CAdvanceSearch::getMySQLVersion();

		foreach ($this->_toolbar as $key => &$row)
		{

			$defaultCoreMenuArray	= array();

			$default	= new stdClass();

			switch ($key)
			{
				case TOOLBAR_PROFILE :
					$default->caption	= JText::_('MM PROFILE');
					$default->link		= JURI::base().'index.php?option=com_contestants&view=condetail&userid='.$userId;
					$default->view		= array('condetail');
					break;
				case TOOLBAR_PHOTO :
					$default->caption	= JText::_('MM PHOTOS');
					$default->link		= JURI::base().'index.php?option=com_contestants&view=photos&task=myphos&userid='.$userId;
					$default->view		= array('apps', 'groups', 'photos', 'photos');
					break;

			}

			$default->child		= array(
									'prepend'	=> array(),
									'append'	=> $defaultCoreMenuArray
									);

			$row	= $default;
		}
	}

	function _addDefaultItem($caption='', $link='', $isScriptCall=false, $hasSeparator=false)
	{
		$child	= new stdClass();
		$child->caption			= $caption;
		$child->link			= $link;
		$child->isScriptCall	= $isScriptCall;
		$child->hasSeparator	= $hasSeparator;
		return $child;
	}

	/**
	 * Function to add new toolbar group.
	 * param - key : string - the key of the group
	 *       - caption : string - the label of the group name
	 *       - link	: string - the url that link to the page
	 */
	function addGroup($key, $caption='', $link='')
	{
		if(! array_key_exists($key, $this->_toolbar))
		{

	    	$newGroup	= new stdClass();
			$newGroup->caption	= $caption;
			$newGroup->link		= $link;
			$newGroup->view		= array();
			$newGroup->child	= array(
									'prepend'	=> array(),
									'append'	=> array()
									);

			$this->_toolbar[strtoupper($key)]	= $newGroup;
		}
	}

	/**
	 * Function used to remove toolbar group and its associated menu items.
	 * param - key : string - the key of the group
	 */
	function removeGroup($key)
	{
		if(array_key_exists($key, $this->_toolbar))
		{
			unset($this->_toolbar[strtoupper($key)]);
		}
	}


	/**
	 * Function to add new toolbar menu items.
	 * param - groupKey : string - the key of the group
	 *       - itemKey : string - the unique key of the menu item
	 *       - caption : string - the label of the menu item name
	 *       - link	: string - the url that link to the page
	 *       - order : string - display sequence : append | prepend
	 *       - isScriptCall : boolean - to indicate whether this is a javascript function or is a anchor link.
	 *       - hasSeparator : boolean - to indicate whether this item should use the class 'seperator' from JomSocial.
	 */

	function addItem($groupKey, $itemKey, $caption='', $link='', $order='append', $isScriptCall=false, $hasSeparator=false)
	{
		$sorting	= $order;

		if(array_key_exists($groupKey, $this->_toolbar))
		{
			$tbGroup	=& $this->_toolbar[strtoupper($groupKey)];
			$childItem	=& $tbGroup->child;

			$child	= new stdClass();
			$child->caption			= $caption;
			$child->link			= $link;
			$child->isScriptCall	= $isScriptCall;
			$child->hasSeparator	= $hasSeparator;

			if($sorting != 'append' && $sorting != 'prepend')
				$sorting	= 'append';
			$childItem[$sorting][$itemKey]	= $child;
		}
	}

	/**
	 * Function used to remove toolbar menu item
	 * param - groupKey : string - the key of the group
	 *       - itemKey : string - the unique key of the menu item
	 */
	function removeItem($groupKey, $itemKey)
	{
		if(array_key_exists($groupKey, $this->_toolbar))
		{

			$tbGroup	=& $this->_toolbar[strtoupper($groupKey)];
			$childItem	=& $tbGroup->child;

			if(array_key_exists($itemKey, $childItem['prepend']))
			{
				unset($childItem['prepend'][$itemKey]);
			}
			if(array_key_exists($itemKey, $childItem['append']))
			{
				unset($childItem['append'][$itemKey]);
			}
		}
	}

	/**
	 * Function used to return html anchor link
	 * param  - string - toolbar group key
	 *        - string - order of the items
	 * return - string - html anchor links
	 */
	function getMenuItems($groupKey, $order)
	{
		$sorting	= array();
		$itemString	= '';

		if($order != 'append' && $order != 'prepend' && $order != 'all')
		{
			$sorting[]	= 'append';
		}
		else if($order == 'all')
		{
			$sorting[]	= 'prepend';
			$sorting[]	= 'append';
		}
		else
		{
			$sorting[]	= $order;
		}

		if(isset($this->_toolbar) && !empty($this->_toolbar[$groupKey])){

			$toolbarItems	=  $this->_toolbar[$groupKey]->child;

			foreach($sorting as $row)
			{
				$menuItems		=  $toolbarItems[$row];

				if(! empty($menuItems))
				{
					foreach($menuItems as $row)
					{
						$caption		= $row->caption;
						$link			= $row->link;
						$isScriptCall	= $row->isScriptCall;
						$hasSeparator	= (isset($row->hasSeparator) && $row->hasSeparator) ? 'class="has-separator"' : '';


						if(isset($link) && !empty($link))
						{
							if($isScriptCall)
							{
								$itemString .= '<a href="javascript:void(0)" onclick="'. $link . ';" ' . $hasSeparator . '>' . $caption . '</a>';
							}
							else
							{
								$itemString .= '<a href="' . $link . '" ' . $hasSeparator. '>' . $caption . '</a>';
							}
						}


					}
				}
			}
		}
		return $itemString;
	}

	/**
	 *	Function to retrieve those toolbar that user custom add.
	 *	return - an array of object.
	 */
	function getExtraToolbars()
	{
		$tbExtra	= array();
		if(isset($this->_toolbar) && !empty($this->_toolbar)){
			//we cant use array_diff_assoc bcos only php version > 4.3.0 support.
			//so no choice but we have to use looping.

			$tbCore		= array(
							TOOLBAR_HOME 	=> '1',
							TOOLBAR_PROFILE => '1',
							TOOLBAR_FRIEND 	=> '1',
							TOOLBAR_APP	 	=> '1',
							TOOLBAR_INBOX 	=> '1'
						  );

			foreach($this->_toolbar as $key => $val){
				if(! array_key_exists($key, $tbCore))
				{
					$tbExtra[$key] = $val;
				}
			}//end foreach
		}//end if

		return $tbExtra;
	}


	/**
	 * Function to retrieve custom toolbar menu items to caller
	 * param - groupKey : string - the key of the group
	 * return array of object
	 */
	function getToolbarItems($groupKey)
	{

		if(array_key_exists($groupKey, $this->_toolbar))
		{
			$tbGroup	= $this->_toolbar[strtoupper($groupKey)];
			return $tbGroup;
		}
		else
		{
			return	'';
		}
	}

	/**
	 * Function used to determined whether a core menu group was set.
	 * param  - string - toolbar group key
	 * return - boolean
	 */
	function hasToolBarGroup($groupKey)
	{
		if(array_key_exists($groupKey, $this->_toolbar))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Function to add views that associated with the toolbar group.
	 * param  - string - group key
	 * param  - string - view name
	 */
	function addGroupActiveView($groupkey, $viewName)
	{
		if(! empty($groupkey) && ! empty($viewName))
		{
			if(array_key_exists($groupkey, $this->_toolbar))
			{

				$tbGroup	=& $this->_toolbar[strtoupper($groupkey)];
				$tbView		=& $tbGroup->view;

				if(! in_array($viewName, $tbView))
				{
					array_push($tbView, $viewName);
				}
			}
		}
	}


	/**
	 * Function to get the toolbar group key based on what view being associated.
	 * param  - string - view name
	 * return - string
	 */
	/*function getGroupActiveView($viewName)
	{
		$groupKey	= '';
		if(! empty($viewName))
		{
			foreach($this->_toolbar as $key => $tbGroup)
			{
				$tbView	= $tbGroup->view;
				if(in_array($viewName, $tbView))
				{
					$groupKey	= $key;
					break;
				}
			}
		}
		return $groupKey;
	}*/


	/**
	 * Function used to return all the toolbar group keys.
	 * return - array
	 */
	function getToolBarGroupKey()
	{
		return array_keys($this->_toolbar);
	}


	/**
	 * Function to get the current viewing page, the toolbar group key.
	 * param  - string - uri of the current view page
	 * return - string
	 */
	function getActiveToolBarGroup($uri)
	{
		//echo "active group";
		//echo $uri;
		$activeGroup = '';
		$sorting	= array('prepend', 'append');
		//var_dump($this->_toolbar);exit;
		foreach($this->_toolbar as $key => $group)
		{
			//check the parent link

			//var_dump($group);

			if(htmlspecialchars_decode($uri) == htmlspecialchars_decode($group->link))
			{
				$activeGroup = $key;
				break;
			}

			//check the child links
			$toolbarItems	=  $group->child;

			foreach($sorting as $row)
			{
				$menuItems		=  $toolbarItems[$row];
				if(! empty($menuItems))
				{
					foreach($menuItems as $item)
					{
						if(! $item->isScriptCall)
						{
							if(htmlspecialchars_decode($uri) == htmlspecialchars_decode($item->link))
							{
								$activeGroup = $key;
								break;
							}
						}
					}
				}
			}
		}
		//var_dump($activeGroup);
		return $activeGroup;
	}
	/**
	 * Function to get the toolbar group key based on what view being associated.
	 * param  - string - view name
	 * return - string
	 */
	function getGroupActiveView($viewName)
	{
		$groupKey	= '';
		//echo $viewName;
		if(! empty($viewName))
		{
			foreach($this->_toolbar as $key => $tbGroup)
			{
				$tbView	= $tbGroup->view;
				//var_dump($tbView);
				if(in_array($viewName, $tbView))
				{
					$groupKey	= $key;
					break;
				}
			}
		}
		//echo $groupKey;
		return $groupKey;
	}
}
