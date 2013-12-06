<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_joomprosubs
 * @copyright   Copyright (C) 2011 Mark Dexter and Louis Landry. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
//$id = (int) $this->item->id;
$name = $this->escape(JFactory::getUser()->get('name'));
//$title = $this->escape($this->item->title);
//$duration = (int) $this->item->duration;
$itemid = JRequest::getInt('Itemid');
?>
	<p style="text-align:center; padding:50px 0px 20px 0px; font-size:25px; color:red"><?php echo JText::_('PR_THANK_YOU');?></p>
	<p style="text-align:center; font-size:20px"><?php echo JText::_('PR_THANK_YOU_YOUR_APPLY_CONSIDER');?></p>



