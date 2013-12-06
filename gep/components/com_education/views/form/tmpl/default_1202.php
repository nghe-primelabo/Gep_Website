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
<form action="<?php echo JRoute::_('index.php?option=com_education&task=registration.register'); ?>" method="post" id="conForm" name="conForm" class="contestant-form-validate" enctype="multipart/form-data">
		<!--
        <div>
			<a style="float:left" href="ymsgr:sendim?vietnamnexttopmodel13"> <img id="yahooImg" src="http://opi.yahoo.com/online?u=vietnamnexttopmodel13&amp;t=1" title=" alt=" /></a>
			<span style="color: #808080; float:left"><?php echo JText::_( 'PRS REGISTER SUPPORT' );  ;?></span>
		</div>
        -->
		
				<fieldset>
				<legend style="color:red; text-decoration:underline"><?php echo JText::_( 'PRS CANDIDATE INFOR' );?></legend>
				<table class="contentTable paramlist" cellspacing="1" cellpadding="0">
					<tr>
						<td class="paramlist_key" valign="top" width="200px"><label id="mmnamemsg" for="mmname" class="label" ><span class="red">*</span><?php echo JText::_('PRS FULL_NAME');?></label>
						</td>

						<td class="paramlist_value"><input title="Họ và tên::Nhập họ và tên bạn vào đây!" type="text" value="<?php echo ($task!='edit')?$data['html_field']['name']:$contestantDetail->full_name; ?>" id="name" name="name" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errnamemsg" class="reerror" style="display:none;">&nbsp;</span>
                        <!-- <p style="float:left; clear:both; margin-left:0px"><strong><i>(Nhập Họ và Tên có đánh dấu tiếng Việt)</i></strong></p>-->
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="occupationmsg" for="occupation" class="label" ><span class="red">*</span><?php echo JText::_('PRS OCCUPATION');?> </label>
						</td>
						<td class="paramlist_value"><input title="Nghề nghiệp::Nghề nghiệp của bạn là gì?" type="text" value="<?php echo $contestantDetail->occupation;?>" id="occupation" name="occupation" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="erroccupationmsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>					
					<tr>
						<td class="paramlist_key" valign="top"><label id="birth_daymsg" for="birth_day" class="label" ><span class="red">*</span><?php echo JText::_('PRS BIRTH_DAY');?> </label>
						</td>
						<td class="paramlist_value"><div class="conTips tipRight" style="display: inline-block;" title="Sinh nhật::Nữ công dân Việt Nam từ 18-25 tuổi">
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
						<td class="paramlist_key" valign="top"><label id="contract_addressmsg" for="contract_address" class="label" ><span class="red">*</span><?php echo JText::_('PRS CONTACT_ADDRESS');?> </label>
						</td>
						<td class="paramlist_value"><input title="Địa chỉ hiện tại::Địa chỉ hiện tại" type="text" value="<?php echo $contestantDetail->contract_address;?>" id="contract_address" name="contract_address" maxlength="100" size="40" class="conTips tipRight inputbox required" /> <span id="errcontract_addressmsg"class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="home_phonemsg" for="home_phone" class="label" ><?php echo JText::_('PRS HOME_PHONE');?>  </label>
						</td>
						<td class="paramlist_value"><input title="Điện thoại cố định::Điện thoại cố định" type="text" value="<?php echo $contestantDetail->home_phone;?>" id="home_phone" name="home_phone" maxlength="100" size="40" class="conTips tipRight inputbox norequired" /> <span id="errhome_phonemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="mobile_phonemsg" for="mobile_phone" class="label" ><span class="red">*</span><?php echo JText::_('PRS MOBILE_PHONE');?></label>
						</td>
						<td class="paramlist_value"><input title="Điện thoại di động::Số điện thoại di động của bạn. Những người dùng khác sẽ liên lạc với bạn qua số điện thoại này." type="text" value="<?php echo $contestantDetail->mobile_phone;?>" id="mobile_phone" name="mobile_phone" maxlength="100" size="40" class="conTips tipRight inputbox validate-phone" /> <span id="errmobile_phonemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
                    <tr>
						<td class="paramlist_key" valign="top"><label id="provincemsg" for="province" class="label" ><?php echo JText::_('PRS PROVINCE');?></label>
						</td>
						<td class="paramlist_value"><input title="Điện thoại di động::Số điện thoại di động của bạn. Những người dùng khác sẽ liên lạc với bạn qua số điện thoại này." type="text" value="<?php echo $contestantDetail->province;?>" id="province" name="province" maxlength="100" size="40" class="conTips tipRight inputbox" /> <span id="errprovincemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="achievementmsg" for="achievement" class="label" ><?php echo JText::_('PRS ACHIEVEMENT');?></label>
						</td>
                        <td class="paramlist_value">
							<TEXTAREA COLS=34 ROWS=5 title="Thành tích::Thành tích bạn đã đạt được" id="achievement" name="achievement" class="conTips tipRight" /><?php echo $contestantDetail->achievement;?></TEXTAREA>
							<span id="errachievementmsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
                   </tr>
                   <tr>     
                        <td class="paramlist_key" valign="top"><label id="about_memsg" for="about_me" class="label" ><span class="red">*</span><?php echo JText::_('PRS ABOUT ME');?></label>
						</td>
						<td class="paramlist_value">
							<TEXTAREA COLS=34 ROWS=5 title="Về Bạn::Bạn hãy trình bày đôi chút về bản thân mình, sở thích, tính cách, ước mơ..." id="about_me" name="about_me" class="conTips tipRight required" /><?php echo $contestantDetail->about_me;?></TEXTAREA>
							<span id="errabout_memsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<?php if ($task!='edit'){?>
                    <tr>
						<td class="paramlist_key" valign="top"><label id="photo_msg" for="photo" class="label" ><span class="red">*</span><?php echo JText::_('PRS UPLOAD AVATAR');?>:</label>
						</td>
						<td class="paramlist_value">
								<input type="file" name="Filedata" title="Upload avatar::Hãy upload avatar của bạn <i>File định dạng jpg, jpeg, png, dưới 2MB</i>!" class="inputbox conTips tipRight required validate-avatar" id="file-upload"/>
							<span id="errFiledatamsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<?php }?>
					<tr>
						<td class="paramlist_key">&nbsp;
						</td>
						<td class="paramlist_value"><span class="valid_condition">
						<?php echo JText::_('PRS FIELD_REQUIRED');?></span>
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
						<input class="button validateSubmit" type="submit" id="btnSubmit" value="<?php echo ($task!='edit')?JText::_('PRS REGISTER'):JText::_('PRS SAVE'); ?>" name="submit">
					</td>
				</tr>
			</tbody>
			</table>
			<input type="hidden" name="option" value="com_education" />
			<input type="hidden" name="task" value="registration.register" />
			<input type="hidden" name="userid" value="<?php echo $contestantDetail->userid;?>" />
			<input type="hidden" name="id" value="<?php echo ($contestantDetail->id > 0)?$contestantDetail->id:0;?>" />
			<input type="hidden" name="gid" value="0" />
			<input type="hidden" id="authenticate" name="authenticate" value="1" />
			<input type="hidden" id="authkey" name="authkey" value="" />
           
		</form>
       
        <script type="text/javascript">
					cvalidate.init();
					cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("PRS REQUIRED ENTRY MISSING")); ?>');
					//cvalidate.restrictIpAdress();

					jQuery('#conForm' ).submit( function(){
					jQuery('#btnSubmit').hide();
					jQuery('#cwin-wait').show();
					if(jQuery('#authenticate').val() != '1')
					{
						//alert('mm.registrations.authenticate()');
						prs.registrations.authenticate();
						return false;
					}
				});
		</script>
        
</div>
</div>
