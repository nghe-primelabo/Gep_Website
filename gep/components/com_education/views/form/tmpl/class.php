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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.noframes');



?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>


<div class="registration<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>
<div id="contestants-wrap">
<form action="<?php echo JRoute::_('index.php?option=com_education&task=class.register'); ?>" method="post" id="conForm" name="conForm" class="contestant-form-validate" enctype="multipart/form-data">
		  	
				<fieldset>
				<legend style="color:red; text-decoration:underline"><?php echo JText::_( 'GEP CLASS INFOR' );?></legend>
				<table class="contentTable paramlist" cellspacing="1" cellpadding="0">
					<tr>
						<td class="paramlist_key" valign="top" width="200px"><label id="class_namemsg" for="class_name" class="label" ><span class="red">*</span><?php echo JText::_('GEP CLASS_NAME');?></label>
						</td>
                        <td class="paramlist_value"><input type="text" value="" id="class_name" name="class_name" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errclass_namemsg" class="reerror" style="display:none;">&nbsp;</span>
                        <!-- <p style="float:left; clear:both; margin-left:0px"><strong><i>(Nháº­p Há»� vÃ  TÃªn cÃ³ Ä'Ã¡nh dáº¥u tiáº¿ng Viá»‡t)</i></strong></p>-->
						</td>					
                   <tr>
                        <td class="paramlist_key" valign="top"><label id="class_desmsg" for="class_des" class="label" ><span class="red"></span><?php echo JText::_('GEP CLASS INTRODUCTION');?></label>
						</td>
						<td class="paramlist_value">
							<textarea COLS=34 ROWS=5 id="class_des" name="class_des" class="required inputbox" /></textarea>
							<span id="errclass_desmsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>					
					<tr>
						<td class="paramlist_key">&nbsp;
						</td>
						<td class="paramlist_value"><span class="valid_condition">
						<?php echo JText::_('GEP FIELD_REQUIRED');?></span>
						</td>
					</tr>
				</table>
				</fieldset>

			<table class="ccontentTable paramlist" cellspacing="1" cellpadding="0">
			  <tbody>
				<tr>
					<td class="paramlist_key">&nbsp;</td>
					<td class="paramlist_value">
						<div id="cwin-wait" style="display:none;"></div>
						<input class="button validateSubmit" type="submit" id="btnSubmit" value="<?php echo JText::_('GEP CLASS SAVE'); ?>" name="submit">
					</td>
				</tr>
			</tbody>
			</table>
			<input type="hidden" name="option" value="com_education" />
			<input type="hidden" name="task" value="class.register" />
			<input type="hidden" name="userid" value="<?php echo $this->userid;?>" />
			<input type="hidden" name="id" value=" " />
			<input type="hidden" name="gid" value="0" />
			<input type="hidden" id="authenticate" name="authenticate" value="1" />
			<input type="hidden" id="authkey" name="authkey" value="" />

		</form>

        <script type="text/javascript">
					cvalidate.init();
					cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("GEP REQUIRED ENTRY MISSING")); ?>');
					//cvalidate.restrictIpAdress();

					jQuery('#conForm' ).submit( function(){
					jQuery('#btnSubmit').hide();
					jQuery('#cwin-wait').show();
					if(jQuery('#authenticate').val() != '1')
					{
						//alert('mm.registrations.authenticate()');
						gep.registrations.authenticate();
						return false;
					}
				});
		</script>

</div>
</div>
