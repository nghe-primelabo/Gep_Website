<?php

 /**
 * @version		01
 * @package		Gep.Site
 * @subpackage	com_education
 * @author Nguyen Xuan Nghe - nxnghe@gmail.com
 * @copyright	Copyright (C) 2013 Prime Labo Technology. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
$itemid = JRequest::getInt('Itemid');
?>

<div class="edit<?php echo $this->pageclass_sfx; ?>">
	<form action="<?php echo JRoute::_('index.php'); ?>" 
			id="adminForm" name="adminForm" method="post" class="form-validate">
		<fieldset>
		<legend><?php echo JText::_('COM_JOOMPROSUBS_FORM_LABEL'); ?></legend>
			<dl>
				<dt><?php echo JText::_('COM_JOOMPROSUBS_GRID_TITLE'); ?></dt>
				<dd><?php echo $this->escape($this->item->get('title')); ?></dd>
				<dt><?php echo JText::_('COM_JOOMPROSUBS_GRID_DESC'); ?></dt>
				<dd><?php echo $this->escape(strip_tags($this->item->get('description'))); ?></dd>
				<dt><?php echo $this->form->getLabel('subscription_terms'); ?></dt>
				<dd><?php echo $this->form->getInput('subscription_terms'); ?></dd>
			</dl>
		</fieldset>
		<fieldset>
			<button class="button validate" type="submit"><?php echo JText::_('COM_JOOMPRPOSUBS_FORM_SUBMIT'); ?></button>
			<a href="<?php echo JRoute::_('index.php?option=com_joomprosubs&Itemid='. $itemid); ?>">
				<?php echo JText::_('COM_JOOMPRPOSUBS_FORM_CANCEL'); ?></a>
			<input type="hidden" name="option" value="com_joomprosubs" />
			<input type="hidden" name="task" value="subscription.subscribe" />
			<input type="hidden" name="sub_id" value="<?php echo $this->item->id; ?>" />
			<?php echo JHtml::_( 'form.token' ); ?>
		</fieldset>
	</form>
</div>