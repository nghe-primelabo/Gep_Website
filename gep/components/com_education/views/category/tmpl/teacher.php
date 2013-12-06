<?php
/**
 * @version		$Id: default.php 272 2011-08-11 00:32:05Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_joomprosubs
 * @copyright	Copyright (C) 2011 Mark Dexter and Louis Landry. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
?>
<form action="index.php?option=com_education&view=category&layout=teacher" method="post" id="stuForm" name="stuForm">

    <div>
        <label for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
       <input type="text" name="search" id="search" value="<?php echo $this->teachers['search']; ?>" class="text_area" onchange="this.form.submit();" />
		<button class="search_bnt" onclick="this.form.submit();"><?php echo JText::_( 'Find' ); ?></button>
        <button type="button" onclick="document.id('search').value='';this.form.submit();">
           <?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
        </button>
    </div>

	<?php echo $this->loadTemplate('teacher'); ?>
	<div class="stu_pagination">
		<?php //echo $this->stupagination->getPagesLinks();?>
		<?php echo $this->teapagination->getListFooter();?>


	</div>
</form>
