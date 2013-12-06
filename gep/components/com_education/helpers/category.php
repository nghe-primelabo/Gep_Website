<?php
/**
 * @version		01
 * @package		Gep.Site
 * @subpackage	com_education
 * @author Nguyen Xuan Nghe - nxnghe@gmail.com
 * @copyright	Copyright (C) 2013 Prime Labo Technology. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

/**
 * Joomprosubs Component Category Tree
 *
 * @static
 * @package		Joomla.Site
 * @subpackage	com_joomprosubs
 */
class CandidatesCategories extends JCategories
{
	public function __construct($options = array())
	{
		$options['table'] = '#__joompro_subscriptions';
		$options['extension'] = 'com_joomprosubs';
		$options['statefield'] = 'published';
		parent::__construct($options);
	}
} // end of class
