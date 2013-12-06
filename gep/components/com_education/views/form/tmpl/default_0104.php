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

<script src="http://projectrunway.com.vn/components/com_education/assets/jquery.tools.min.js"></script>

<div id="drawer">
 <?php echo JText::_('PR EMPTY FIELDS ERROR');?> <span style="color:red">(*)</span>
</div>

<!-- the form -->
<div id="contestants-wrap">
<form action="<?php echo JRoute::_('index.php?option=com_education&task=registration.register'); ?>" method="post" id="conForm" name="conForm" class="contestant-form-validate" enctype="multipart/form-data">

  <div id="wizard">
    <ul id="status">
      <li><strong>1.</strong> <?php echo JText::_('PR PERSONAL INFORMATION');?></li>
      <li><strong>2.</strong> <?php echo JText::_('PR ABOUT');?> 1</li>
      <li><strong>3.</strong> <?php echo JText::_('PR ABOUT');?> 2</li>
      <li><strong>4.</strong> <?php echo JText::_('PR ABOUT');?> 3</li>
     <!-- <li><strong>5.</strong> <?php echo JText::_('PR ABOUT');?> 4</li>-->
      <li><strong>5.</strong> <?php echo JText::_('PR FINISHED');?></li>
    </ul>

    <div class="items">

      <!-- page1 -->
      <div class="page">
      <!--
      <div style="font-size:16px!important; font-weight:bold; padding:10px;font-family:'Myriad Pro';color:#575151; border:1px solid #575151">
      		Để được lựa chọn trở thành thí sinh của Project Runway, bạn phải hoàn tất bảng đăng kí này một cách
chân thật, chính xác và đầy đủ nhất. Mọi sự sai sót đều có thể dẫn bạn đến việc bị loại ra khỏi chương 
trình, cũng như phải hoàn trả lại hết những giải thưởng bằng tiền mặt hoặc hiện vật mà bạn có thể 
nhận được trong thời gian tham gia chương trình.<br/>
Ghi chú: Trong bản đăng kí này, bạn sẽ được yêu cầu cung cấp thông tin liên lạc của nhiều người. Hãy 
lưu ý rằng, bằng việc đưa vào những thông tin về nhân thân như thế này, chúng tôi sẽ có quyền liên 
hệ người thân của bạn để tham khảo, kiểm soát và đối chiếu thông tin về bạn.
      </div>
      -->
	<h2>
	  <strong><?php echo JText::_('PR STEP');?> 1: </strong> <?php echo JText::_('PR PERSONAL INFORMATION');?>:	 
	</h2>
	<ul>
			<li class="required">
	   
			  <label id="namemsg" for="name" class="label" ><span class="red">*</span><?php echo JText::_('PR FULL_NAME');?><br />
			    <input title="Họ và tên::Nhập họ và tên bạn vào đây!" type="text" value="<?php echo ($task!='edit')?$data['html_field']['name']:$contestantDetail->name2; ?>" id="name" name="name" maxlength="100" size="40" class="conTips tipRight inputbox required" />
			  </label>
				<span id="errname2msg" class="reerror" style="display:none;">&nbsp;</span>
                <!-- <p style="float:left; clear:both; margin-left:0px"><strong><i>(Nhập Họ và Tên có đánh dấu tiếng Việt)</i></strong></p>-->
				</li>
    					<li  class="required">
							<label id="mmusernamemsg" for="username" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR USERNAME' ); ?>:</label>
						
							<input type="text" id="username" name="username" size="40" value="<?php echo ($task!='edit')?$data['html_field']['username']:$contestantDetail->username; ?>" class="required <?php echo ($task!='edit')?'validate-username':' '; ?>" maxlength="25" />
							<input type="hidden" name="usernamepass" id="usernamepass" value="N"/>
							<span id="errusernamemsg" class="reerror" style="display:none;">&nbsp;</span>
						</li>
					
				<li  class="required">
						<label id="pwmsg" for="password1" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR PASSWORD' ); ?>:</label>
					
						<input class="inputbox required validate-password" type="password" id="password1" name="password1" size="40" value="" />
						<span id="errpassword1msg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                     <li  class="required">
						<label id="mmemailmsg" for="email" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR EMAIL' ); ?>:</label>
					
						<input type="text" id="email1" name="email1" size="40" value="<?php echo ($task!='edit')? $data['html_field']['email1']:$contestantDetail->email1; ?>" class="inputbox required <?php echo ($task!='edit')?'validate-email':'' ;?>" maxlength="100" />
						<input type="hidden" name="emailpass" id="emailpass" value="N"/>
						<span id="erremail1msg" class="reerror" style="display:none;">&nbsp;</span>
					</li>	                     
					<li class="required"><label id="birth_daymsg" for="birth_day" class="label" ><span class="red">*</span><?php echo JText::_('PR BIRTH_DAY');?> </label>
						<div class="conTips tipRight" style="display: inline-block;">
						<select name="birth_day[]" class="select_small birth_day">
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
						<select name="birth_day[]" class="select_small validate-custom-date">
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
						</li>
					<li  class="required"><label id="id_numbermsg" for="id_number" class="label" ><span class="red">*</span><?php echo JText::_('PR ID_NUMBER');?> </label>
						<input title="CMND::Nhập vào số chứng minh nhân dân của bạn!" type="text" value="<?php echo $contestantDetail->id_number;?>" id="id_number" name="id_number" maxlength="100" size="40" class="conTips tipRight inputbox validate-cmnd" />
						<span id="errid_numbermsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li  class="required"><label id="lbldate_of_issue" for="date_of_issue" class="label" ><span class="red">*</span><?php echo JText::_('PR DATE_OF_ISSUE');?> </label>
						</td>
						<li  class="required"><div class="conTips tipRight" style="display: inline-block;" title="Ngày cấp::Ngày cấp của chứng minh nhân dân">
						<select name="date_of_issue[]" class="select_small date_of_issue">
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
						</select>&nbsp;&nbsp;&nbsp;&nbsp;<select name="date_of_issue[]" class="select_small validate-custom-date">
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
						<select name="date_of_issue[]" class="select_small validate-custom-date">
							<?php
                            for ($i = 1970; $i <= 2013; $i++) {
								?>
                               <option value="<?php echo $i;?>"><?php echo $i;?></option>
                               <?php
                            }
							?>
						</select>&nbsp;&nbsp;
						<span id="errdate_of_issuemsg" class="reerror" style="display:none;">&nbsp;</span></div>
						</li>
					<li  class="required"><label id="place_of_issuemsg" for="place_of_issue" class="label" ><span class="red">*</span><?php echo JText::_('PR PLACE_OF_ISSUE');?> </label>
						<input title="Nơi cấp::Nơi cấp giấy chứng minh nhân dân" type="text" value="<?php echo $contestantDetail->place_of_issue;?>" id="place_of_issue" name="place_of_issue" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errplace_of_issuemsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>			
					<li  class="required"><label id="permanent_place_of_residencemsg" for="permanent_place_of_residence" class="label" ><span class="red">*</span><?php echo JText::_('PR PERMANENT_PLACE_OF_RESIDENCE');?> </label>
						<input title="Địa chỉ thường trú::Địa chỉ thường trú" type="text" value="<?php echo $contestantDetail->permanent_place_of_residence;?>" id="permanent_place_of_residence" name="permanent_place_of_residence" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errpermanent_place_of_residencemsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li  class="required"><label id="contract_addressmsg" for="contract_address" class="label" ><span class="red">*</span><?php echo JText::_('PR CONTACT_ADDRESS');?> </label>
						<input title="Địa chỉ hiện tại::Địa chỉ hiện tại" type="text" value="<?php echo $contestantDetail->contract_address;?>" id="contract_address" name="contract_address" maxlength="100" size="40" class="conTips tipRight inputbox required" /> <span id="errcontract_addressmsg"class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li><label id="home_phonemsg" for="home_phone" class="label" ><?php echo JText::_('PR HOME_PHONE');?>  </label>
						<input title="Điện thoại cố định::Điện thoại cố định" type="text" value="<?php echo $contestantDetail->home_phone;?>" id="home_phone" name="home_phone" maxlength="100" size="40" class="conTips tipRight inputbox norequired" /> <span id="errhome_phonemsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li  class="required"><label id="mobile_phonemsg" for="mobile_phone" class="label" ><span class="red">*</span><?php echo JText::_('PR MOBILE_PHONE');?></label>
						<input title="Điện thoại di động::Số điện thoại di động của bạn. Những người dùng khác sẽ liên lạc với bạn qua số điện thoại này." type="text" value="<?php echo $contestantDetail->mobile_phone;?>" id="mobile_phone" name="mobile_phone" maxlength="100" size="40" class="conTips tipRight inputbox validate-phone" /> <span id="errmobile_phonemsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                   
                     <li class="required">
                     	<label id="socialnetworkmsg" for="socialnetwork" class="label" ><span class="red"></span><?php echo JText::_('PR SOCIAL NETWORK');?> </label>
                        <li class="ahalf">
  <?php echo JText::_('PR SOCIAL NETWORK FACEBOOK');?>
						<input title="Mạng xã hội::Tài khoản facebook của bạn là gì?" type="text" value="<?php echo $contestantDetail->socialnetwork;?>" id="socialnetwork1" name="socialnetwork1" maxlength="100" size="20" class="conTips tipRight inputbox2 required" />
                        </li>
                         <li class="ahalf">
  <?php echo JText::_('PR SOCIAL NETWORK TWITTER');?>
						<input title="Mạng xã hội::Tài khoản twitter của bạn là gì?" type="text" value="<?php echo $contestantDetail->socialnetwork;?>" id="socialnetwork2" name="socialnetwork2" maxlength="100" size="20" class="conTips tipRight inputbox2 required" />
                        </li>
                        <li class="ahalf">
  <?php echo JText::_('PR SOCIAL NETWORK ZINGME');?>
						<input title="Mạng xã hội::Tài khoảng Zing Me của bạn là gì?" type="text" value="<?php echo $contestantDetail->socialnetwork;?>" id="socialnetwork3" name="socialnetwork3" maxlength="100" size="20" class="conTips tipRight inputbox2 required" />
                        </li>
                        <li class="ahalf">
  <?php echo JText::_('PR SOCIAL NETWORK OTHER');?>
						<input title="Mạng xã hội::Tài khoản mạng xã hội khác mà bạn tham gia?" type="text" value="<?php echo $contestantDetail->socialnetwork;?>" id="socialnetwork4" name="socialnetwork4" maxlength="100" size="20" class="conTips tipRight inputbox2 required" />
                        </li>                       
                     </li>
                     <li class="required">
                     <label id="occupationmsg" for="occupation" class="label" ><span class="red">*</span><?php echo JText::_('PR OCCUPATION');?> </label>
						<input title="Nghề nghiệp::Nghề nghiệp của bạn là gì?" type="text" value="<?php echo $contestantDetail->occupation;?>" id="occupation" name="occupation" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="erroccupationmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                    					
					<?php if ($task!='edit'){?>
                   <li><label id="photo_msg" for="photo" class="label" ><span class="red"></span><?php echo JText::_('PR UPLOAD AVATAR');?>:</label>						
					<input type="file" name="Filedata" title="Upload avatar::Hãy upload avatar của bạn <i>File định dạng jpg, jpeg, png, dưới 2MB</i>!" class="inputbox conTips tipRight required validate-avatar" id="file-upload"/>		
                    <span id="errFiledatamsg" class="reerror" style="display:none;">&nbsp;</span>
				   </li>
					<?php }?>
                   
                     <li class="required">
                   
                     		<label id="sketch_design1msg" for="sketch_design1" class="label" ><span class="red">*</span><?php echo JText::_('PR SKETCH_DESIGN1');?>: ( <?php echo JText::_('PR SKETCH_DESIGN FORMAT');?>)</label>						
					<input type="file" name="sketch_design1" class="inputbox conTips tipRight required validate-avatar" id="sketch_design1"/>		
					</li>
                     <li class="required">
                     		<label id="sketch_design2msg" for="sketch_design2" class="label" ><span class="red">*</span><?php echo JText::_('PR SKETCH_DESIGN2');?>:</label>						
					<input type="file" name="sketch_design2" class="inputbox conTips tipRight required validate-avatar" id="sketch_design2"/>		
					</li>
                     <li>
                     		<label id="sketch_design3msg" for="sketch_design3" class="label" ><span class="red"></span><?php echo JText::_('PR SKETCH_DESIGN3');?>:</label>						
					<input type="file" name="sketch_design3" class="inputbox conTips tipRight required validate-avatar" id="sketch_design3"/>		
					</li>
                     <li>
                     		<label id="sketch_design4msg" for="sketch_design4" class="label" ><span class="red"></span><?php echo JText::_('PR SKETCH_DESIGN4');?>:</label>						
					<input type="file" name="sketch_design4" class="inputbox conTips tipRight required validate-avatar" id="sketch_design4"/>		
					</li>
                     <li>
                     		<label id="sketch_design5msg" for="sketch_design5" class="label" ><span class="red"></span><?php echo JText::_('PR SKETCH_DESIGN5');?>:</label>						
					<input type="file" name="sketch_design5" class="inputbox conTips tipRight required validate-avatar" id="sketch_design5"/>		
					</li>
                     <p style="font-size:14px"><strong class="red"><?php echo JText::_('PR SKETCH_DESIGN NOTE TITLE');?>:</strong> <?php echo JText::_('PR SKETCH_DESIGN NOTE');?></p>
                    
					<li  class="required">
						<span class="valid_condition">
						<?php echo JText::_('PR FIELD_REQUIRED');?></span>
					</li>
				
	     		 </li>
                    		
              	<li>
                    	 <button type="button" class="next right"><?php echo JText::_('PR NEXT');?></button>
                 </li>
           </ul>     

      </div>

      <!-- page2 -->
      <div class="page">

	<h2>    	 
	  <strong><?php echo JText::_('PR STEP');?> 2: </strong> <?php echo JText::_('PR ABOUT');?> 1:<b></b>	 
	</h2>

	<ul class="page2">
	  <!-- address -->
	  <li class="required">
	   
			  <label id="studying_workingmsg" for="studying_working" class="label" ><span class="red">*</span><?php echo JText::_('PR STUDYING WORKING');?>
			    <TEXTAREA COLS=34 ROWS=2 title="Nơi học tập/Cơ quan công tác::Nơi học tập/Cơ quan công tác? - Địa chỉ, điện thoại? " id="studying_working" name="studying_working" class="conTips tipRight required" /><?php echo $contestantDetail->studying_working;?></TEXTAREA>
			  </label>
				<span id="errnamemsg" class="reerror" style="display:none;">&nbsp;</span>
                <!-- <p style="float:left; clear:both; margin-left:0px"><strong><i>(Nhập Họ và Tên có đánh dấu tiếng Việt)</i></strong></p>-->
				</li>
    					<li  class="required">
							<label id="who_contactmsg" for="who_contact" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR WHO CONTACT' ); ?></label>
						
							 <TEXTAREA COLS=34 ROWS=2 title="Liên hệ khi cần::Khi cần báo tin cho ai? Ở đâu?" id="who_contact" name="who_contact" class="conTips tipRight required" /><?php echo $contestantDetail->who_contact;?></TEXTAREA>
							<span id="errusernamemsg" class="reerror" style="display:none;">&nbsp;</span>
						</li>
					
				<li  class="required">
						<label id="pwmsg" for="marriage" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR MARRIAGE' ); ?></label>
					  
                        <?php echo JText::_( 'PR SINGLE' ); ?>
						<input class="inputbox required" type="checkbox" id="marriage" name="marriage[]" size="40" value="1" />
                        
                         <?php echo JText::_( 'PR MARRIED' ); ?>
                        <input class="inputbox required" type="checkbox" id="marriage" name="marriage[]" size="40" value="2" />
                         
                          <?php echo JText::_( 'PR DIVORCE' ); ?>
                        <input class="inputbox required" type="checkbox" id="marriage" name="marriage[]" size="40" value="3" />
                        
                          <?php echo JText::_( 'PR SEPARATED' ); ?>
                        <input class="inputbox required" type="checkbox" id="marriage" name="marriage[]" size="40" value="4" />
						<span id="errpassword1msg" class="reerror" style="display:none;">&nbsp;</span>
					</li>	                     
					<li><label id="childsmsg" for="childs" class="label" ><span class="red"></span><?php echo JText::_('PR HOW MANY CHILDS');?> </label>
						<input title="Số con::Bạn có bao nhiêu người con?" type="text" value="<?php echo $contestantDetail->childs;?>" id="childs" name="childs" maxlength="100" size="40" class="conTips tipRight inputbox" />
						<span id="errchildsmsg" class="reerror" style="display:none;">&nbsp;</span>
						</li>
					<li><label id="educationmsg" for="education" class="label" ><span class="red"></span><?php echo JText::_('PR EDUCATION');?> </label>
						
                        <?php echo JText::_( 'PR HIGH SCHOOL' ); ?>
						<input class="inputbox required" type="checkbox" id="education" name="education[]" size="40" value="1" />
                      
                         <?php echo JText::_( 'PR VOCATIONAL TRAINING' ); ?>
                        <input class="inputbox required" type="checkbox" id="education" name="education[]" size="40" value="2" />
                         
                         <?php echo JText::_( 'PR COLLEGE' ); ?>
                        <input class="inputbox required" type="checkbox" id="education" name="education[]" size="40" value="3" />
                       
                         <?php echo JText::_( 'PR UNDERGRADUATE' ); ?>
                        <input class="inputbox required" type="checkbox" id="education" name="education[]" size="40" value="4" />
                       
                        <?php echo JText::_( 'PR POST GRADUATE' ); ?>
                        <input class="inputbox required" type="checkbox" id="education" name="education[]" size="40" value="5" />
						<span id="errid_numbermsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                    <li><label id="another_educationmsg" for="another_education" class="label" ><?php echo JText::_('PR EDUCATION ANOTHER');?> </label>
						<input title="Khác::Trình độ khác của bạn" type="text" value="<?php echo $contestantDetail->another_education;?>" id="another_education" name="another_education" maxlength="100" size="40" class="conTips tipRight inputbox validate-cmnd" />
						<span id="erranother_educationmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li ><label id="lbldate_of_issue" for="date_of_issue" class="label" ><span class="red"></span><?php echo JText::_('PR FOREIGN LANGUAGE');?> </label>
						</td>
						<li  class="required">
						<?php echo JText::_( 'PR NO' ); ?>
						<input class="inputbox required" type="radio" id="foreign_language" name="foreign_language[]" size="40" value="1" />
                         <?php echo JText::_( 'PR YES' ); ?>
                        <input class="inputbox required" type="radio" id="foreign_language" name="foreign_language[]" size="40" value="2" />
						<span id="errdate_of_issuemsg" class="reerror" style="display:none;">&nbsp;</span>
						</li>
                         <li><label id="foreign_language_yesmsg" for="foreign_language_yes" class="label" ><?php echo JText::_('PR FOREIGN LANGUAGE YES');?> </label>
						 <TEXTAREA COLS=34 ROWS=2 title="Ngoại ngữ::Ngoại ngữ gì? và trình độ?" id="foreign_language_yes" name="foreign_language_yes" class="conTips tipRight required" /><?php echo $contestantDetail->foreign_language_yes;?></TEXTAREA>
						<span id="errforeign_language_yesmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li><label id="place_of_issuemsg" for="place_of_issue" class="label" ><span class="red">*</span><?php echo JText::_('PR HOW TO KNOW');?> </label>
						  <?php echo JText::_( 'PR TV' ); ?>
						<input class="inputbox required" type="checkbox" id="how_to_know" name="how_to_know[]" size="40" value="1" />
                         
                         <?php echo JText::_( 'PR NEWSPAPER' ); ?>
                        <input class="inputbox required" type="checkbox" id="how_to_know" name="how_to_know[]" size="40" value="2" />
                         
                         <?php echo JText::_( 'PR INTERNET' ); ?>
                        <input class="inputbox required" type="checkbox" id="how_to_know" name="how_to_know[]" size="40" value="3" />
                         
                         <?php echo JText::_( 'PR FRIEND' ); ?>
                        <input class="inputbox_small required" type="checkbox" id="how_to_know" name="how_to_know[]" size="40" value="4" />
                        <?php echo JText::_( 'PR ANOTHER' ); ?>
                        <input class="inputbox" type="text" id="how_to_know" name="how_to_know[]" size="20" value="" />
						<span id="errplace_of_issuemsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>			
					<li  class="required"><label id="why_join_usmsg" for="why_join_us" class="label" ><span class="red">*</span><?php echo JText::_('PR WHY JOIN US');?> </label>
						 <TEXTAREA COLS=34 ROWS=2 title="Lý do::Tại sao bạn tham gia chương trình?" id="why_join_us" name="why_join_us" class="conTips tipRight required" /><?php echo $contestantDetail->why_join_us;?></TEXTAREA>
						<span id="errwhy_join_usmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li  class="required"><label id="about_yourselfsmsg" for="about_yourself" class="label" ><span class="red">*</span><?php echo JText::_('PR ABOUT_YOURSELF');?> </label>
						 <TEXTAREA COLS=34 ROWS=2 id="about_yourself" name="about_yourself" class="conTips tipRight required" /><?php echo $contestantDetail->about_yourself;?></TEXTAREA>
                          <span id="about_yourselfmsg"class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li  class="required"><label id="why_choose_youmsg" for="why_choose_you" class="label" ><span class="red">*</span><?php echo JText::_('PR WHY WE CHOOSE YOU');?>  </label>
						<TEXTAREA COLS=34 ROWS=2 title="Lý do::Tại sao chương trình chọn bạn?" id="why_choose_you" name="why_choose_you" class="conTips tipRight required" /><?php echo $contestantDetail->why_choose_you;?></TEXTAREA>
                         <span id="errhome_phonemsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li  class="required"><label id="is_designermsg" for="is_designer" class="label" ><span class="red">*</span><?php echo JText::_('PR ARE YOU DESIGNER');?></label>
                    	<?php echo JText::_( 'PR YES' ); ?>
                        
						<input class="inputbox required" type="radio" id="is_designer" name="is_designer[]" size="40" value="1" />
                         <?php echo JText::_( 'PR NO' ); ?>
                        <input class="inputbox required" type="radio" id="is_designer" name="is_designer[]" size="40" value="2" />
                         <span id="erris_designermsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                    <li><label id="is_designer_yesmsg" for="is_designer_yes" class="label" ><?php echo JText::_('PR ARE YOU DESIGNER YES');?></label>
						<input title="Là Nhà Thiết Kế::Bạn đã thiết kế được bao lâu?" type="text" value="<?php echo $contestantDetail->is_designer_yes;?>" id="is_designer_yes" name="is_designer_yes" maxlength="100" size="40" class="conTips tipRight inputbox validate-phone" /> <span id="erris_designer_yesmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                    <li>
						<label id="living_by_designer_jobmsg" for="living_by_designer_job" class="label"><span style="color:#FF0000"></span><?php echo JText::_( 'PR LIVING BY DESIGNER JOB' ); ?>:</label>
					
						<TEXTAREA COLS=34 ROWS=2 title="Nghề Nghiệp::Bạn có đang kiếm sống bằng nghề thiết kế không?" id="living_by_designer_job" name="living_by_designer_job" class="conTips tipRight required" /><?php echo $contestantDetail->living_by_designer_job;?></TEXTAREA>
						<span id="errliving_by_designer_jobmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>                     
                     <li>
                     <label id="living_by_designer_job_yesmsg" for="living_by_designer_job_yes" class="label" ><?php echo JText::_('PR YOUR JOB NOW');?> </label>
						<TEXTAREA COLS=34 ROWS=2 title="Nghề Nghiệp::Công việc nào đem thu nhập cho bạn?" id="living_by_designer_job_yes" name="living_by_designer_job_yes" class="conTips tipRight required" /><?php echo $contestantDetail->living_by_designer_job;?></TEXTAREA>
						<span id="errliving_by_designer_job_yesmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                    					
					
					<li  class="required">
						<span class="valid_condition">
						<?php echo JText::_('PR FIELD_REQUIRED');?></span>
					</li>
				
	      
                    		
              	<li>
                    <button type="button" class="prev" style="float:left">
              			&laquo; <?php echo JText::_('PR BACK');?>
                    </button>
                    <button type="button" class="next right">
                          <?php echo JText::_('PR NEXT');?> &raquo;
                    </button>
                 </li>
	  <br clear="all" />
	</ul>

      </div>
        <!-- page3 -->
      <div class="page">

	<h2>
    	 <strong><?php echo JText::_('PR STEP');?> 3: </strong> <?php echo JText::_('PR ABOUT');?>2 :<b></b>	
	 	 
	</h2>

	<ul class="page2">
	  <!-- address -->
	  <li>
	   
			  <label id="where_be_trainedmsg" for="where_be_trained" class="label" ><span class="red">*</span><?php echo JText::_('PR WHERE BE TRAINED');?>
               <?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="where_be_trained" name="where_be_trained[]" size="40" value="1" />
                         <?php echo JText::_( 'PR NO' ); ?>
                        <input class="inputbox required" type="radio" id="where_be_trained" name="where_be_trained[]" size="40" value="2" />
			  </label>
				<span id="errwhere_be_trainedmsg" class="reerror" style="display:none;">&nbsp;</span>
                    <li>
                        <label id="where_be_trained_nomsg" for="where_be_trained_no" class="label" ><?php echo JText::_('PR WHERE BE TRAINED NO');?> </label>
                            <TEXTAREA COLS=34 ROWS=2 id="where_be_trained_no" name="where_be_trained_no" class="conTips tipRight required" /><?php echo $contestantDetail->where_be_trained_no;?></TEXTAREA>
                    </li>  
                    <li>
                        <label id="where_be_trained_yesmsg" for="where_be_trained_yes" class="label" ><?php echo JText::_('PR WHERE BE TRAINED YES');?> </label>
                            
                    </li> 
                    <li   >
							<label id="where_be_trained_school_namemsg" for="where_be_trained_school_name" class="label"><span style="color:#FF0000"></span><?php echo JText::_( 'PR SCHOOL NAME' ); ?>:</label>
						
							<input type="text" id="where_be_trained_school_name" name="where_be_trained_school_name" size="40" value="<?php echo ($task!='edit')?$data['html_field']['username']:$contestantDetail->where_be_trained_school_name; ?>" class="required <?php echo ($task!='edit')?'validate-username':' '; ?>" maxlength="150" />
							
							<span id="errwhere_be_trained_school_namemsg" class="reerror" style="display:none;">&nbsp;</span>
						</li>
					
				<li   >
						<label id="graduate" for="graduate" class="label"><span style="color:#FF0000"></span><?php echo JText::_( 'PR GRADUATION' ); ?>:</label>
					
						<?php echo JText::_( 'PR CHUA' ); ?>
			   <input class="inputbox required" type="radio" id="graduate" name="graduate[]" size="40" value="1" />
                         <?php echo JText::_( 'PR ROI' ); ?>
                        <input class="inputbox required" type="radio" id="graduate" name="graduate[]" size="40" value="2" />
                        <?php echo JText::_( 'PR GRADUATE YEAR' ); ?>
                        <input class="inputbox required" type="text" id="graduate_years" name="graduate_years" size="20" value="" />
						<span id="errgraduate_yearsmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>	                  
				</li>
                 <li>
                        <label id="graduated_qualificationmsg" for="graduated_qualification" class="label" ><span class="red"></span><?php echo JText::_('PR GRADUATED QUALIFICATION');?> </label>
                            <TEXTAREA COLS=34 ROWS=2 id="graduated_qualification" name="graduated_qualification" class="conTips tipRight required" /><?php echo $contestantDetail->graduated_qualification;?></TEXTAREA>
                    </li>  
    					                  
					<li  class="required"><label id="some_taskmsg" for="birth_day" class="label" ><span class="red">*</span><?php echo JText::_('PR SOME TASKS');?> </label>
                    	<li  class="required">
                        <?php echo JText::_( 'PR CAT' ); ?>
                        <span style="float:right; margin-right:200px">
						<?php echo JText::_( 'PR VERY GOOD' ); ?>
			   <input class="inputbox required" type="radio" id="some_taskcat" name="some_taskcat[]" size="40" value="1" />
                         <?php echo JText::_( 'PR KNOWN A LITTEL' ); ?>
                        <input class="inputbox required" type="radio" id="some_taskcat" name="some_taskcat[]" size="40" value="2" />
                        <?php echo JText::_( 'PR DO NOT KNOWN' ); ?>
                        <input class="inputbox required" type="radio" id="some_taskcat" name="some_taskcat[]" size="40" value="2" />
                        </span>
                        </li>
                   <li  class="required">
                        <?php echo JText::_( 'PR SEW' ); ?>
                        <span style="float:right; margin-right:200px">
						<?php echo JText::_( 'PR VERY GOOD' ); ?>
			   <input class="inputbox required" type="radio" id="some_taskmay" name="some_taskmay[]" size="40" value="1" />
                         <?php echo JText::_( 'PR KNOWN A LITTEL' ); ?>
                        <input class="inputbox required" type="radio" id="some_taskmay" name="some_taskmay[]" size="40" value="2" />
                         <?php echo JText::_( 'PR DO NOT KNOWN' ); ?>
                        <input class="inputbox required" type="radio" id="some_taskmay" name="some_taskmay[]" size="40" value="2" />
                        </span>
                        </li>
                      <li  class="required">
                        <?php echo JText::_( 'PR SKETCH' ); ?>
                        <span style="float:right; margin-right:200px">
						<?php echo JText::_( 'PR VERY GOOD' ); ?>
			   <input class="inputbox required" type="radio" id="some_taskkhauva" name="some_taskkhauva[]" size="40" value="1" />
                          <?php echo JText::_( 'PR KNOWN A LITTEL' ); ?>
                        <input class="inputbox required" type="radio" id="some_taskkhauva" name="some_taskkhauva[]" size="40" value="2" />
                        <?php echo JText::_( 'PR DO NOT KNOWN' ); ?>
                        <input class="inputbox required" type="radio" id="some_taskkhauva" name="some_taskkhauva[]" size="40" value="2" />
                        </span>
                        </li>
                     <li  class="required">
                        <?php echo JText::_( 'PR MAKE YOUR OWN PATTERN' ); ?>
                        <span style="float:right; margin-right:200px">
						<?php echo JText::_( 'PR VERY GOOD' ); ?>
			   <input class="inputbox required" type="radio" id="some_tasktumay" name="some_tasktumay[]" size="40" value="1" />
                         <?php echo JText::_( 'PR KNOWN A LITTEL' ); ?>
                        <input class="inputbox required" type="radio" id="some_tasktumay" name="some_tasktumay[]" size="40" value="2" />
                         <?php echo JText::_( 'PR DO NOT KNOWN' ); ?>
                        <input class="inputbox required" type="radio" id="some_tasktumay" name="some_tasktumay[]" size="40" value="2" />
                        </span>
                        </li>
                      <li  class="required">
                        <?php echo JText::_( 'PR VEPHAT HOA' ); ?>
                        <span style="float:right; margin-right:200px">
						<?php echo JText::_( 'PR VERY GOOD' ); ?>
			   <input class="inputbox required" type="radio" id="some_taskphathoa" name="some_taskphathoa[]" size="40" value="1" />
                          <?php echo JText::_( 'PR KNOWN A LITTEL' ); ?>
                        <input class="inputbox required" type="radio" id="some_taskphathoa" name="some_taskphathoa[]" size="40" value="2" />
                        <?php echo JText::_( 'PR DO NOT KNOWN' ); ?>
                        <input class="inputbox required" type="radio" id="some_taskphathoa" name="some_taskphathoa[]" size="40" value="2" />
                        </span>
                        </li>   
                        
						</li>
					<li  class="required"><label id="fashion_workshopmsg" for="fashion_workshop" class="label" ><span class="red">*</span><?php echo JText::_('PR FASHION DESIGN WORKSHOP');?> </label>
						<?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="fashion_workshop" name="fashion_workshop[]" size="40" value="1" />
                         <?php echo JText::_( 'PR NO' ); ?>
                        <input class="inputbox required" type="radio" id="fashion_workshop" name="fashion_workshop[]" size="40" value="2" />
						<span id="errfashion_workshopmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li><label id="lblfashion_workshop_yes" for="fashion_workshop_yes" class="label" ><span class="red"></span><?php echo JText::_('PR FASHION DESIGN WORKSHOP YES');?> </label>
						</td>
						<li   > <TEXTAREA COLS=34 ROWS=4 id="fashion_workshop_yes" name="fashion_workshop_yes" class="conTips tipRight required" /><?php echo $contestantDetail->fashion_workshop_yes;?></TEXTAREA>
						</li>
					<li  class="required"><label id="your_fashion_brandmsg" for="your_fashion_brand" class="label" ><span class="red">*</span><?php echo JText::_('PR YOUR FASHION BRAND');?> </label>
						<?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="your_fashion_brand" name="your_fashion_brand[]" size="40" value="1" />
                         <?php echo JText::_( 'PR NO' ); ?>
                        <input class="inputbox required" type="radio" id="your_fashion_brand" name="your_fashion_brand[]" size="40" value="2" />
						<span id="erryour_fashion_brandmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>	
                    <li   ><label id="lblyour_fashion_brand_yes" for="your_fashion_brand_yes" class="label" ><span class="red"> </span><?php echo JText::_('PR YOUR FASHION BRAND YES');?> </label>
						</td>
						<li   > <TEXTAREA COLS=34 ROWS=2 id="your_fashion_brand_yes" name="your_fashion_brand_yes" class="conTips tipRight required" /><?php echo $contestantDetail->your_fashion_brand_yes;?></TEXTAREA>
						</li>		
					
					<li><label id="your_fashion_brand_howlongmsg" for="your_fashion_brand_howlong" class="label" ><span class="red"></span><?php echo JText::_('PR YOUR FASHION BRAND HOW LONG');?> </label>
						<input type="text" value="<?php echo $contestantDetail->your_fashion_brand_howlong;?>" id="your_fashion_brand_howlong" name="your_fashion_brand_howlong" maxlength="100" size="40" class="conTips tipRight inputbox required" /> <span id="erryour_fashion_brand_howlongmsg"class="reerror" style="display:none;">&nbsp;</span>
					</li>					
					<li  class="required">
						<label id="your_product_salemsg" for="your_product_sale" class="label"><span style="color:#FF0000">* </span><?php echo JText::_( 'PR YOUR PRODUCT SELL' ); ?></label>
					
						<TEXTAREA COLS=34 ROWS=2 id="your_product_sale" name="your_product_sale" class="conTips tipRight required" /><?php echo $contestantDetail->your_product_sale;?></TEXTAREA>
						
						<span id="erryour_product_salemsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                     
                     <li  >
                     <label id="biggest_revenuemsg" for="biggest_revenue" class="label" ><span class="red"> </span><?php echo JText::_('PR YOUR BIGGEST REVENUE');?> </label>
						<input type="text" value="<?php echo $contestantDetail->biggest_revenue;?>" id="occupation" name="biggest_revenue" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errbiggest_revenuemsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                    					
					
					<li   >
						<span class="valid_condition">
						<?php echo JText::_('PR FIELD_REQUIRED');?></span>
					</li>
				
	      
                    		
              	<li>
                    <button type="button" class="prev" style="float:left">
              			&laquo; <?php echo JText::_('PR BACK');?>
                    </button>
                    <button type="button" class="next right">
                          <?php echo JText::_('PR NEXT');?> &raquo;
                    </button>
                 </li>
	  <br clear="all" />
	</ul>

      </div>
         <!-- page4 -->
      <div class="page">

	<h2>
     <strong><?php echo JText::_('PR STEP');?> 4: </strong> <?php echo JText::_('PR ABOUT');?>3 :<b></b>	 
	</h2>

	<ul class="page2">
	  <!-- address -->
	  <li  >
	   
			  <label id="women_manmsg" for="women_man" class="label" ><span class="red"> </span><?php echo JText::_('PR WOMEN MAN');?>
			    <input type="text" value="<?php echo ($task!='edit')?$data['html_field']['women_man']:$contestantDetail->women_man; ?>" id="women_man" name="women_man" maxlength="100" size="40" class="conTips tipRight inputbox required" />
			  </label>
				<span id="errwomen_manmsg" class="reerror" style="display:none;">&nbsp;</span>
                <!-- <p style="float:left; clear:both; margin-left:0px"><strong><i>(Nhập Họ và Tên có đánh dấu tiếng Việt)</i></strong></p>-->
				</li>
    					<li>
							<label id="yourfiedsmsg" for="yourfieds" class="label"><span style="color:#FF0000">* </span><?php echo JText::_( 'PR YOUR FIEDS' ); ?>:</label>
						
                        <input class="inputbox required" type="checkbox" id="yourfieds" name="yourfieds[]" size="40" value="1" />
							
                            <?php echo JText::_( 'PR WOMAN READY TO WEAR' ); ?>
                         <br /> 
						 <input class="inputbox required" type="checkbox" id="yourfieds" name="yourfieds[]" size="40" value="2" />
                        
                          <?php echo JText::_( 'PR EVENINGWEAR' ); ?>
                          <br /> 
                       <input class="inputbox required" type="checkbox" id="yourfieds" name="yourfieds[]" size="40" value="3" />
                         
                          <?php echo JText::_( 'PR AVANT GARDE' ); ?>
                          <br /> 
                          <input class="inputbox required" type="checkbox" id="yourfieds" name="yourfieds[]" size="40" value="4" />
                        
                         <?php echo JText::_( 'PR MENWEAR' ); ?>
                          <br /> 
                      	 <input class="inputbox required" type="checkbox" id="yourfieds" name="yourfieds[]" size="40" value="5" />
                        
                         <?php echo JText::_( 'PR ACCESSORIES' ); ?>
                          <br /> 
                          <input class="inputbox required" type="checkbox" id="yourfieds" name="yourfieds[]" size="40" value="6" />                       
                        
                         <?php echo JText::_( 'PR FIELDS ORTHER' ); ?>
                          <br /> 
                        <input class="inputbox required" type="text" id="yourfieds" name="yourfieds[]" size="40" value="" />                       
							<span id="erryourfiedsmsg" class="reerror" style="display:none;">&nbsp;</span>
						</li>					
				<li  class="required">
						<label id="pwmsg" for="password1" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR YOUR OPINION DESIGNER' ); ?>:</label>
					
						<TEXTAREA COLS=34 ROWS=2 id="youropinion" name="youropinion" class="conTips tipRight required" /><?php echo $contestantDetail->youropinion;?></TEXTAREA>
						<span id="erryouropinionmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>	                     
					<li  class="required"><label id="yourrelative_ideasmsg" for="yourrelative_ideas" class="label" ><span class="red">*</span><?php echo JText::_('PR YOUR RELATIVE IDEAS');?> </label>
						<TEXTAREA COLS=34 ROWS=2 id="yourrelative_ideas" name="yourrelative_ideas" class="conTips tipRight required" /><?php echo $contestantDetail->yourrelative_ideas;?></TEXTAREA>
						</li>
					<li   ><label id="special_talentmsg" for="special_talent" class="label" ><span class="red"> </span><?php echo JText::_('PR SPECIAL TALENT');?> </label>
						<TEXTAREA COLS=34 ROWS=2 id="special_talent" name="special_talent" class="conTips tipRight required" /><?php echo $contestantDetail->special_talent;?></TEXTAREA>
						<span id="errspecial_talentmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li   ><label id="lblyour_designer_idol" for="your_designer_idol" class="label" ><span class="red"> </span><?php echo JText::_('PR YOUR DESIGNER IDOL');?> </label>
						</td>
						<li   ><TEXTAREA COLS=34 ROWS=2 id="your_designer_idol" name="your_designer_idol" class="conTips tipRight required" /><?php echo $contestantDetail->your_designer_idol;?></TEXTAREA>
						</li>
					<li   ><label id="place_of_issuemsg" for="place_of_issue" class="label" ><span class="red"> </span><?php echo JText::_('PR WORK WITH YOUR IDOL');?> </label>
						<?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="work_with_idol" name="work_with_idol[]" size="40" value="1" />
                         <?php echo JText::_( 'Chưa' ); ?>
                        <input class="inputbox required" type="radio" id="work_with_idol" name="work_with_idol[]" size="40" value="2" />
						<span id="errwork_with_idolmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>			
					<li   ><label id="work_with_idol_yesmsg" for="work_with_idol_yes" class="label" ><span class="red"> </span><?php echo JText::_('PR WORK WITH YOUR IDOL YES');?> </label>
						<TEXTAREA COLS=34 ROWS=2 id="work_with_idol_yes" name="work_with_idol_yes" class="conTips tipRight required" /><?php echo $contestantDetail->work_with_idol_yes;?></TEXTAREA>
                        
                        <span id="errwork_with_idol_yesmsg"class="reerror" style="display:none;">&nbsp;</span>
					</li>
					
					<li   ><label id="dislike_designermsg" for="dislike_designer" class="label" ><span class="red"> </span><?php echo JText::_('PR DISLIKE DESIGNER');?></label>
						<TEXTAREA COLS=34 ROWS=2 id="dislike_designer" name="dislike_designer" class="conTips tipRight required" /><?php echo $contestantDetail->dislike_designer;?></TEXTAREA>
                        <span id="errdislike_designermsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                    <li   >
						<label id="fashion_magazinemsg" for="fashion_magazine" class="label"><span style="color:#FF0000"> </span><?php echo JText::_( 'PR LIKE FASHION MAGAZINE' ); ?>:</label>
					
						<TEXTAREA COLS=34 ROWS=2 id="fashion_magazine" name="fashion_magazine" class="conTips tipRight required" /><?php echo $contestantDetail->fashion_magazine;?></TEXTAREA>
						<span id="errfashion_magazinemsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>                                                    					
					<li   >
						<span class="valid_condition">
						<?php echo JText::_('PR FIELD_REQUIRED');?></span>
					</li>
				
	      
                    		
              	<li>
                    <button type="button" class="prev" style="float:left">
              			&laquo; <?php echo JText::_('PR BACK');?>
                    </button>
                    <button type="button" class="next right">
                          <?php echo JText::_('PR NEXT');?> &raquo;
                    </button>
                 </li>
	  <br clear="all" />
	</ul>

      </div>
         <!-- page5 -->
      <div class="page">

	<h2>
	 
       <strong><?php echo JText::_('PR STEP');?> 5: </strong> <?php echo JText::_('PR ABOUT');?>4 :<b></b>	 
	</h2>

	<ul class="page2">
	  <!-- address -->
	  <li  >
	   
			  <label id="liketv_showmsg" for="liketv_show" class="label" ><span class="red"> </span><?php echo JText::_('PR LIKE TV SHOW');?>
			   <TEXTAREA COLS=34 ROWS=2 id="liketv_show" name="liketv_show" class="conTips tipRight required" /><?php echo $contestantDetail->liketv_show;?></TEXTAREA>
			  </label>
				<span id="errliketv_showmsg" class="reerror" style="display:none;">&nbsp;</span>
                <!-- <p style="float:left; clear:both; margin-left:0px"><strong><i>(Nhập Họ và Tên có đánh dấu tiếng Việt)</i></strong></p>-->
				</li>
    					<li  class="required">
							<label id="youintv_showmsg" for="youintv_show" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR YOU IN TV SHOW' ); ?>:</label>
						
							<?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="youintv_show" name="youintv_show[]" size="40" value="1" />
                         <?php echo JText::_( 'PR CHUA' ); ?>
                        <input class="inputbox required" type="radio" id="youintv_show" name="youintv_show[]" size="40" value="2" />
                        
							<span id="erryouintv_showmsg" class="reerror" style="display:none;">&nbsp;</span>
						</li>
					
				<li   >
						<label id="youintv_show_yes" for="youintv_show_yes" class="label"><span style="color:#FF0000"> </span><?php echo JText::_( 'PR YOU IN TV SHOW YES' ); ?>:</label>
					
						 <TEXTAREA COLS=34 ROWS=2 id="youintv_show_yes" name="youintv_show_yes" class="conTips tipRight required" /><?php echo $contestantDetail->youintv_show_yes;?></TEXTAREA>
						<span id="erryouintv_show_yesmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                                  
					<li  class="required"><label id="winner_fashion_showmsg" for="winner_fashion_show" class="label" ><span class="red">*</span><?php echo JText::_('PR WINNER IN FASHION SHOW');?> </label>
						
							<?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="winner_fashion_show" name="winner_fashion_show[]" size="40" value="1" />
                         <?php echo JText::_( 'PR CHUA' ); ?>
                        <input class="inputbox required" type="radio" id="winner_fashion_show" name="winner_fashion_show[]" size="40" value="2" />
						</li>
					<li   ><label id="winner_fashion_show_yesmsg" for="winner_fashion_show_yes" class="label" ><span class="red"> </span><?php echo JText::_('PR WINNER IN FASHION SHOW YES');?> </label>
						 <TEXTAREA COLS=34 ROWS=2 id="winner_fashion_show_yes" name="winner_fashion_show_yes" class="conTips tipRight required" /><?php echo $contestantDetail->winner_fashion_show_yes;?></TEXTAREA>
						<span id="errwinner_fashion_show_yesmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li   ><label id="lblwith_profesional_designer" for="with_profesional_designer" class="label" ><span class="red"> </span><?php echo JText::_('PR WORK WITH PROFESIONAL DESIGNER');?> </label>
						</td>
						<li   ><?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="with_profesional_designer" name="with_profesional_designer[]" size="40" value="1" />
                         <?php echo JText::_( 'PR NO' ); ?>
                        <input class="inputbox required" type="radio" id="with_profesional_designer" name="with_profesional_designer[]" size="40" value="2" />
						</li>
					<li   ><label id="with_profesional_designer_yesmsg" for="with_profesional_designer_yes" class="label" ><span class="red"> </span><?php echo JText::_('PR WORK WITH PROFESIONAL DESIGNER YES');?> </label>
						 <TEXTAREA COLS=34 ROWS=2 id="with_profesional_designer_yes" name="with_profesional_designer_yes" class="conTips tipRight required" /><?php echo $contestantDetail->with_profesional_designer_yes;?></TEXTAREA>
						<span id="errwith_profesional_designer_yesmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>			
					<li  class="required"><label id="tienan_tiensumsg" for="tienan_tiensu" class="label" ><span class="red">*</span><?php echo JText::_('PR TIEN AN TIEN SU');?> </label>
						<?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="tienan_tiensu" name="tienan_tiensu[]" size="40" value="1" />
                         <?php echo JText::_( 'PR NO' ); ?>
                        <input class="inputbox required" type="radio" id="tienan_tiensu" name="tienan_tiensu[]" size="40" value="2" />
						<span id="errtienan_tiensumsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
					<li   ><label id="tienan_tiensu_yesmsg" for="tienan_tiensu_yes" class="label" ><span class="red"> </span><?php echo JText::_('PR TIEN AN TIEN SU YES');?> </label>
						 <TEXTAREA COLS=34 ROWS=2 id="tienan_tiensu_yes" name="tienan_tiensu_yes" class="conTips tipRight required" /><?php echo $contestantDetail->tienan_tiensu_yes;?></TEXTAREA>
                          <span id="errtienan_tiensu_yesmsg"class="reerror" style="display:none;">&nbsp;</span>
					</li>
					
					<li  class="required"><label id="health_issuesmsg" for="health_issues" class="label" ><span class="red">*</span><?php echo JText::_('PR HEALTH ISSUES');?></label>
						<?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="health_issues" name="health_issues[]" size="40" value="1" />
                         <?php echo JText::_( 'PR NO' ); ?>
                        <input class="inputbox required" type="radio" id="health_issues" name="health_issues[]" size="40" value="2" />
                         <span id="errhealth_issuesmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                    <li   >
						<label id="health_issues_yesmsg" for="health_issues_yes" class="label"><span style="color:#FF0000"> </span><?php echo JText::_( 'PR HEALTH ISSUES YES' ); ?>:</label>
					
						 <TEXTAREA COLS=34 ROWS=2 id="health_issues_yes" name="health_issues_yes" class="conTips tipRight required" /><?php echo $contestantDetail->health_issues_yes;?></TEXTAREA>
						<span id="erremail1msg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                     <li  class="required">
						<label id="be_selectedmsg" for="be_selected" class="label"><span style="color:#FF0000"> *</span><?php echo JText::_( 'PR BE SELECTED' ); ?>:</label>
					
						<?php echo JText::_( 'PR YES' ); ?>
			   <input class="inputbox required" type="radio" id="be_selected" name="be_selected[]" size="40" value="1" />
                         <?php echo JText::_( 'PR NO' ); ?>
                        <input class="inputbox required" type="radio" id="be_selected" name="be_selected[]" size="40" value="2" />
						<span id="errbe_selectedmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                     <li   >
						<label id="be_selected_yesmsg" for="be_selected_yes" class="label"><span style="color:#FF0000"> </span><?php echo JText::_( 'PR BE SELECTED YES' ); ?>:</label>
					
						 <TEXTAREA COLS=34 ROWS=2 id="be_selected_yes" name="be_selected_yes" class="conTips tipRight required" /><?php echo $contestantDetail->be_selected_yes;?></TEXTAREA>
						<span id="errbe_selected_yesmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
                     <li>
						<label id="casting_placemsg" for="casting_place" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR CASTING PLACE' ); ?>:</label>
					
						<?php echo JText::_( 'PR HANOI' ); ?>
                      
						<input class="inputbox required" type="checkbox" id="casting_place" name="casting_place[]" size="40" value="1" />
                         <?php echo JText::_( 'PR HCM' ); ?>
                       
                        <input class="inputbox required" type="checkbox" id="casting_place" name="casting_place[]" size="40" value="2" />
                        <?php echo JText::_( 'PR ANOTHER' ); ?>
                        <input class="inputbox required" type="text" id="casting_place" name="casting_place[]" size="20" value="" />
						<span id="erremail1msg" class="reerror" style="display:none;">&nbsp;</span>
					</li>                                                                 					
					<li   >
						<span class="valid_condition">
						<?php echo JText::_('PR FIELD_REQUIRED');?></span>
					</li> 
                    <li>
                    	<h2>
                          <strong><?php echo JText::_('PR I COMMIT');?> : <b></b>	 
                        </h2>
                        <p>
                        <?php echo JText::_('PR I COMMIT CONTENT');?>    
                        </p>	
                        <p style="margin-top:30px">
                          <button type="button" class="prev"><?php echo JText::_('PR BACK');?></button>
                      
                                            <input class="next right button validateSubmit" type="submit" id="btnSubmit" value="<?php echo ($task!='edit')?JText::_('PR REGISTER'):JText::_('PR SAVE'); ?>" name="submit"></p>
                                        </li>     
                                                          		
              
	  <br clear="all" />
	</ul>

      </div>

     
    </div><!--items-->

  </div><!--wizard-->
	<input type="hidden" name="option" value="com_education" />
    <input type="hidden" name="task" value="registration.register" />
    <input type="hidden" name="userid" value="<?php echo $contestantDetail->userid;?>" />
    <input type="hidden" name="id" value="<?php echo ($contestantDetail->id > 0)?$contestantDetail->id:0;?>" />
    <input type="hidden" name="gid" value="0" />
    <input type="hidden" id="authenticate" name="authenticate" value="1" />
    <input type="hidden" id="authkey" name="authkey" value="" />
</form>
</div>

<script>
  $(function() {
      var root = $("#wizard").scrollable();
  
      // some variables that we need
    var api = root.scrollable(), drawer = $("#drawer");

    // validation logic is done inside the onBeforeSeek callback
    api.onBeforeSeek(function(event, i) {
	
	//alert(i);
	 if(i == 3){
	 	$("#wizard").css("height", "580px!important");
	 }
	 
    // we are going 1 step backwards so no need for validation
    if (api.getIndex() < i) {

		         // 1. get current page
				 //alert(api.getIndex());
				 if(api.getIndex() == 2){
					 $("#wizard").css("height", "1090px!important");
				 }				
		         var page = root.find(".page").eq(api.getIndex()),

				 // 2. .. and all required fields inside the page
				 inputs = page.find(".required :input").removeClass("error"),
				
				 // 3. .. which are empty
				 isValid = false;
				  empty = inputs.filter(function() {
			 		return (( $(this).val().replace(/\s*/g, '') == '' ) && ( $(this).val().length <=3 ));
			 });

		         // if there are empty fields, then
		         if (empty.length) {
					//  if (1==2) {

			 // slide down the drawer
			 drawer.slideDown(function()  {

			 // colored flash effect
			 drawer.css("backgroundColor", "#fff");
			 setTimeout(function() { drawer.css("backgroundColor", "#fff"); }, 1000);
			 });

			 // add a CSS class name "error" for empty & required fields
			 empty.addClass("error");

			 // cancel seeking of the scrollable by returning false
			 return false;

		         // everything is good
		         } else {

			 // hide the drawer
			 drawer.slideUp();
		         }

	                 }

	                 // update status bar
	                 $("#status li").removeClass("active").eq(i).addClass("active");

                         });
                         
                             // if tab is pressed on the next button seek to next page
    root.find("button.next").keydown(function(e) {
    if (e.keyCode == 9) {

    // seeks to next tab by executing our validation routine
    api.next();
    e.preventDefault();
    }
    });
                           });
</script>
<script>
		function 
		var checkboxes = $(':checkbox.myCheckboxGroup');

		checkboxes.click(function(){
		
		  var self = this;
		
		  checkboxes.each(function(){
		
			if(this!=self) this.checked = ''
		
		  })

})
</script>
<!--
 <script type="text/javascript">
					cvalidate.init();
					cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("PR REQUIRED ENTRY MISSING")); ?>');
					//cvalidate.restrictIpAdress();

					jQuery('#conForm' ).submit( function(){
					jQuery('#btnSubmit').hide();
					jQuery('#cwin-wait').show();
					if(jQuery('#authenticate').val() != '1')
					{
						//alert('mm.registrations.authenticate()');
						pr.registrations.authenticate();
						return false;
					}
				});
		</script>
-->