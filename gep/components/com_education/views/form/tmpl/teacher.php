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

$task = $this->task;
if ($task == 'edit'){
	$teacherProfile = $this->teacherProfile;
}else{
	$teacherProfile = array();
}




?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>


<div class="registration<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>
<div id="contestants-wrap">
<form action="<?php echo JRoute::_('index.php?option=com_education&task=teacher.register'); ?>" method="post" id="conForm" name="conForm" class="contestant-form-validate" enctype="multipart/form-data">
		<!--
        <div>
			<a style="float:left" href="ymsgr:sendim?vietnamnexttopmodel13"> <img id="yahooImg" src="http://opi.yahoo.com/online?u=vietnamnexttopmodel13&amp;t=1" title=" alt=" /></a>
			<span style="color: #808080; float:left"><?php echo JText::_( 'GEP REGISTER SUPPORT' );  ;?></span>
		</div>
        -->

        	<fieldset>
				<legend style="color:red; text-decoration:underline"><?php echo JText::_( 'GEP WEBSITE INFOR' );?></legend>
				<table class="contentTable paramlist" cellspacing="1" cellpadding="0">

					<tr>
						<td class="paramlist_key" valign="top" width="200px"><label id="mmusernamemsg" for="username" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'GEP USERNAME' ); ?>:</label>
						</td>

						<td class="paramlist_value"><input type="text" id="username" name="username" size="40" value="<?php echo ($task=='edit')?$teacherProfile->username:' '; ?>" class="required <?php echo ($task!='edit')?'validate-username':' '; ?>" maxlength="25" />
							<input type="hidden" name="usernamepass" id="usernamepass" value="N"/>
							<span id="errusernamemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
                    <tr>
						<td class="paramlist_key" valign="top" width="200px"><label id="mmemailmsg" for="email" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'GEP EMAIL' ); ?>:</label>
						</td>

						<td class="paramlist_value"><input type="text" id="email1" name="email1" size="40" value="<?php echo ($task=='edit')?$teacherProfile->email:' '; ?>" class="inputbox required <?php echo ($task!='edit')?'validate-email':'' ;?>" maxlength="100" />
						<input type="hidden" name="emailpass" id="emailpass" value="N"/>
						<span id="erremail1msg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
                    <tr>
						<td class="paramlist_key" valign="top" width="200px">	<label id="pwmsg" for="password1" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'GEP PASSWORD' ); ?>:</label>
						</td>
						<td class="paramlist_value"><input class="inputbox required validate-password" type="password" id="password1" name="password1" size="40" value="" />
						<span id="errpassword1msg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
                    <tr>
						<td class="paramlist_key" valign="top" width="200px"><label id="pw2msg" for="password2" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'GEP VERIFY PASSWORD' ); ?>:</label>
						</td>
						<td class="paramlist_value"><input class="inputbox required validate-passverify" type="password" id="password2" name="password2" size="40" value="" />
						<span id="errpassword2msg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
				</table>
				</fieldset>
				<fieldset>
				<legend style="color:red; text-decoration:underline"><?php echo JText::_( 'GEP TEACHER INFOR' );?></legend>
				<table class="contentTable paramlist" cellspacing="1" cellpadding="0">
					<tr>
						<td class="paramlist_key" valign="top" width="200px"><label id="mmnamemsg" for="mmname" class="label" ><span class="red">*</span><?php echo JText::_('GEP FULL_NAME');?></label>
						</td>

						<td class="paramlist_value"><input type="text" value="<?php echo ($task=='edit')?$teacherProfile->full_name:' '; ?>" id="name" name="name" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errnamemsg" class="reerror" style="display:none;">&nbsp;</span>
                        <!-- <p style="float:left; clear:both; margin-left:0px"><strong><i>(Nháº­p Há»� vÃ  TÃªn cÃ³ Ä'Ã¡nh dáº¥u tiáº¿ng Viá»‡t)</i></strong></p>-->
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="majormsg" for="major" class="label" ><span class="red">*</span><?php echo JText::_('GEP MAJOR');?> </label>
						</td>
						<td class="paramlist_value"><input  type="text" value="<?php echo ($task=='edit')?$teacherProfile->major:' '; ?>" id="major" name="major" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errmajormsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
                    <tr>
						<td class="paramlist_key" valign="top"><label id="experiencesmsg" for="experiences" class="label" ><span class="red">*</span><?php echo JText::_('GEP EXPERIENCES');?> </label>
						</td>
						<td class="paramlist_value"><input type="text" value="<?php echo ($task=='edit')?$teacherProfile->experiences:' '; ?>" id="experiences" name="experiences" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errexperiencesmsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
                    <tr>
						<td class="paramlist_key" valign="top"><label id="gendermsg" for="gender" class="label" ><span class="red">*</span><?php echo JText::_('GEP GENDER');?> </label>
						</td>
						<td class="paramlist_value"><select name="gender[]" class="select gender">
							<option value="male" <?php if ($task=='edit') echo ($teacherProfile->gender == 'male')?'selected':' ';?>>Male</option>
							<option value="female" <?php if ($task=='edit') echo ($teacherProfile->gender == 'female')?'selected':' ';?>>Female</option>
						</select>
						</select>
						<span id="errgendermsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="birth_daymsg" for="birth_day" class="label" ><span class="red">*</span><?php echo JText::_('GEP BIRTH_DAY');?> </label>
						</td>
						<td class="paramlist_value"><div class="conTips tipRight" style="display: inline-block;" title="Sinh nháº­t::Ná»¯ cÃ´ng dÃ¢n Viá»‡t Nam tá»« 18-25 tuá»•i">
						<select name="birth_day[]" class="select birth_day">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
						</select>&nbsp;&nbsp;&nbsp;&nbsp;
						<select name="birth_day[]" class="select validate-custom-date">
							<option value="1"><?php echo JText::_('JANUARY');?></option>
							<option value="2"><?php echo JText::_('FEBRUARY');?></option>
							<option value="3"><?php echo JText::_('MARCH');?></option>
							<option value="4"><?php echo JText::_('APRIL');?></option>
							<option value="5"><?php echo JText::_('MAY');?></option>
							<option value="6"><?php echo JText::_('JUNE');?></option>
							<option value="7"><?php echo JText::_('JULY');?></option>
							<option value="8"><?php echo JText::_('AUGUST');?></option>
							<option value="9"><?php echo JText::_('SEPTEMBER');?></option>
							<option value="10"><?php echo JText::_('OCTOBER');?></option>
							<option value="11"><?php echo JText::_('NOVEMBER');?></option>
							<option value="12"><?php echo JText::_('DECEMBER');?></option>
						</select>&nbsp;&nbsp;&nbsp;&nbsp;
						<select name="birth_day[]" class="select_small validate-custom-date">
                        	<?php
                            for ($i = 1953; $i <= 1995; $i++) {
								?>
                               <option value="<?php echo $i;?>"><?php echo $i;?></option>
                               <?php
                            }
							?>

						</select>&nbsp;&nbsp;
						<span id="errbirth_daymsg" class="reerror" style="display:none;">&nbsp;</span></div>
						</td>
					</tr>

					<tr>
						<td class="paramlist_key" valign="top"><label id="addressmsg" for="address" class="label" ><span class="red">*</span><?php echo JText::_('GEP CONTACT_ADDRESS');?> </label>
						</td>
						<td class="paramlist_value"><input type="text" value="<?php echo ($task=='edit')?$teacherProfile->address:' '; ?>" id="address" name="address" maxlength="100" size="40" class="conTips tipRight inputbox required" /> <span id="err_addressmsg"class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="home_phonemsg" for="home_phone" class="label" ><?php echo JText::_('GEP HOME_PHONE');?>  </label>
						</td>
						<td class="paramlist_value"><input  type="text" value="<?php echo ($task=='edit')?$teacherProfile->phone:' '; ?>" id="phone" name="phone" maxlength="100" size="40" class="conTips tipRight inputbox norequired" /> <span id="err_phonemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>

                    <tr>
						<td class="paramlist_key" valign="top"><label id="provincemsg" for="province" class="label" ><?php echo JText::_('GEP PROVINCE');?></label>
						</td>
						<td class="paramlist_value"><input  type="text" value="<?php echo ($task=='edit')?$teacherProfile->province:' '; ?> " id="province" name="province" maxlength="100" size="40" class="conTips tipRight inputbox" /> <span id="errprovincemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
                   <tr>
                        <td class="paramlist_key" valign="top"><label id="about_memsg" for="about_me" class="label" ><span class="red">*</span><?php echo JText::_('GEP SELF INTRODUCTION');?></label>
						</td>
						<td class="paramlist_value">
							<TEXTAREA COLS=34 ROWS=5  id="about_me" name="about_me" class="conTips tipRight required" /><?php echo ($task=='edit')?$teacherProfile->about_me:' '; ?></TEXTAREA>
							<span id="errabout_memsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<?php //if ($task!='edit'){?>
                    <tr>
						<td class="paramlist_key" valign="top"><label id="photo_msg" for="photo" class="label" ><span class="red">*</span><?php echo JText::_('GEP UPLOAD AVATAR');?>:</label>
						</td>
						<td class="paramlist_value">
								<input type="file" name="Filedata"  class="inputbox conTips tipRight required validate-avatar" id="file-upload"/>
							<span id="errFiledatamsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<?php //}?>
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
						<input class="button validateSubmit" type="submit" id="btnSubmit" value="<?php echo ($task!='edit')?JText::_('GEP REGISTER'):JText::_('GEP SAVE'); ?>" name="submit">
					</td>
				</tr>
			</tbody>
			</table>
			<input type="hidden" name="option" value="com_education" />
			<input type="hidden" name="task" value="teacher.register" />
			<input type="hidden" name="userid" value="<?php echo ($teacherProfile->userid > 0)?$teacherProfile->userid:" ";?>" />
			<input type="hidden" name="id" value="<?php echo ($teacherProfile->id > 0)?$teacherProfile->id:" ";?>" />
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
