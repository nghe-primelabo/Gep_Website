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
<style>
	 body {
		padding:50px 80px;
		font-family:"Lucida Grande","bitstream vera sans","trebuchet ms",sans-serif,verdana;
	}
	
	/* get rid of those system borders being generated for A tags */
	a:active {
		outline:none;
	}
	
	:focus {
		-moz-outline-style:none;
	}
	
/* scrollable root element */
#wizard {
    background:#fff url(/media/img/gradient/h600.png) repeat scroll 0 0;
    border:5px solid #789;
    font-size:12px;
	min-height:550px;
    margin:20px auto;
    width:570px;
    overflow:hidden;
    position:relative;

    /* rounded corners for modern browsers */
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
}

/* scrollable items */
#wizard .items {
    width:20000em;
    clear:both;
    position:absolute;
}

/* single item */
#wizard .page {
    padding:20px 30px;
    width:500px;
    float:left;
}

/* title */
#wizard h2 {
    border-bottom:1px dotted #ccc;
    font-size:22px;
    font-weight:normal;
    margin:10px 0 0 0;
    padding-bottom:15px;
}

#wizard h2 em {
    display:block;
    font-size:14px;
    color:#666;
    font-style:normal;
    margin-top:5px;
}

/* input fields */
#wizard ul {
    padding:0px !important;
    margin:0px !important;
}
#wizard ul.page2{
	height:800px!important;   
}

#wizard li {
    list-style-type:none;
    list-style-image:none;
    margin-bottom:5px;
}

#wizard label {
    font-size:16px;
    display:block;
}

#wizard label strong {
    color:#789;
    position:relative;
    top:-1px;
}

#wizard label em {
    font-size:11px;
    color:#666;
    font-style:normal;
}

#wizard .text {
    width:100%;
    padding:5px;
    border:1px solid #ccc;
    color:#456;
    letter-spacing:1px;
}

#wizard select {
    border:1px solid #ccc;
    width:94%;
    padding:4px;
}

#wizard label span {
    color:#b8128f;
    font-weight:bold;
    position:relative;
    top:4px;
    font-size:20px;
}

#wizard .double label {
    width:50%;
    float:left;
}

#wizard .double .text {
    width:93%;
}

#wizard .clearfix {
    clear:left;
    padding-top:10px;
}

#wizard .right {
    float:right;
}

/* validation error message bar */
#drawer {
    background:#fff url(/media/img/gradient/h80.png) repeat-x scroll 0 0;
    _background-color:#fff;
    overflow:visible;
    position:fixed;
    left:0;
    top:0;
    text-align:center;
    padding:15px;
    font-size:18px;
    border-bottom:2px solid #789;
    width:100%;
    display:none;
    z-index:2;
}

#wizard .error {
    border:1px solid red;
}

#wizard #status {
    margin:0px !important;
    height:35px;
    background:#123 url(/media/img/gradient/h30.png) repeat-x;
    padding-left:25px !important;
    _background:#123;
}

#status li {
    list-style-type:none;
    list-style-image:none;
    float:left;
    color:#fff;
    padding:10px 30px;
}

#status li.active {
    background-color:#b8128f;
    font-weight:normal;
}
	  
</style>
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>

<div id="drawer">
  Vui lòng điền thông tin cho các phần có dấu <span style="color:red">(*)</span>
</div>

<!-- the form -->
<form action="#">

  <div id="wizard">

    <ul id="status">
      <li><strong>2.</strong> Đăng Ký Tài Khoản</li>
      <li><strong>3.</strong> Thông Tin Liên Lạc</li>
      <li><strong>4.</strong> Hoàn Tất</li>
    </ul>

    <div class="items">

      <!-- page1 -->
      <div class="page">

	<h2>
	  <strong>Bước 1: </strong> Đăng Ký Tài Khoản:
      	 
	</h2>

	<ul>
    					<li  class="required">
							<label id="mmusernamemsg" for="username" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR USERNAME' ); ?>:</label>
						
							<input type="text" id="username" name="username" size="40" value="<?php echo ($task!='edit')?$data['html_field']['username']:$contestantDetail->username; ?>" class="required <?php echo ($task!='edit')?'validate-username':' '; ?>" maxlength="25" />
							<input type="hidden" name="usernamepass" id="usernamepass" value="N"/>
							<span id="errusernamemsg" class="reerror" style="display:none;">&nbsp;</span>
						</li>
					<li  class="required">
						<label id="mmemailmsg" for="email" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR EMAIL' ); ?>:</label>
					
						<input type="text" id="email1" name="email1" size="40" value="<?php echo ($task!='edit')? $data['html_field']['email1']:$contestantDetail->email1; ?>" class="inputbox required <?php echo ($task!='edit')?'validate-email':'' ;?>" maxlength="100" />
						<input type="hidden" name="emailpass" id="emailpass" value="N"/>
						<span id="erremail1msg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
				<li  class="required">
						<label id="pwmsg" for="password1" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR PASSWORD' ); ?>:</label>
					
						<input class="inputbox required validate-password" type="password" id="password1" name="password1" size="40" value="" />
						<span id="errpassword1msg" class="reerror" style="display:none;">&nbsp;</span>
					</li>
				<li  class="required">
						<label id="pw2msg" for="password2" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'PR VERIFY PASSWORD' ); ?>:</label>
					
						<input class="inputbox required validate-passverify" type="password" id="password2" name="password2" size="40" value="" />
						<span id="errpassword2msg" class="reerror" style="display:none;">&nbsp;</span>
				</li>
              	<li>
                    	 <button type="button" class="next right">Tiếp theo</button>
                 </li>
           </ul>     

      </div>

      <!-- page2 -->
      <div class="page">

	<h2>
	  <strong>Bước 2: </strong> Thông tin liên hệ <b></b>	 
	</h2>

	<ul class="page2">
	  <!-- address -->
	  <li class="required">
	   
						<label id="mmnamemsg" for="mmname" class="label" ><span class="red">*</span><?php echo JText::_('PR FULL_NAME');?></label>
						<input title="Họ và tên::Nhập họ và tên bạn vào đây!" type="text" value="<?php echo ($task!='edit')?$data['html_field']['name']:$contestantDetail->full_name; ?>" id="name" name="name" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errnamemsg" class="reerror" style="display:none;">&nbsp;</span>
                        <!-- <p style="float:left; clear:both; margin-left:0px"><strong><i>(Nhập Họ và Tên có đánh dấu tiếng Việt)</i></strong></p>-->
						</li>
					 <li class="required">
                     <label id="occupationmsg" for="occupation" class="label" ><span class="red">*</span><?php echo JText::_('PR OCCUPATION');?> </label>
						<input title="Nghề nghiệp::Nghề nghiệp của bạn là gì?" type="text" value="<?php echo $contestantDetail->occupation;?>" id="occupation" name="occupation" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="erroccupationmsg" class="reerror" style="display:none;">&nbsp;</span>
					</li>			
					 <li class="required"><label id="birth_daymsg" for="birth_day" class="label" ><span class="red">*</span><?php echo JText::_('PR BIRTH_DAY');?> </label>
						<div class="conTips tipRight" style="display: inline-block;" title="Sinh nhật::Nữ công dân Việt Nam từ 18-25 tuổi">
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
						<select name="birth_day[]" class="select validate-custom-date">							
							<option value="1988">1987</option>
                            <option value="1988">1988</option>
							<option value="1989">1989</option>
							<option value="1990">1990</option>
							<option value="1991">1991</option>
							<option value="1992">1992</option>
							<option value="1993">1993</option>
                            <option value="1993">1994</option>
                            <option value="1994">1995</option>
						</select>&nbsp;&nbsp;
						<span id="errbirth_daymsg" class="reerror" style="display:none;">&nbsp;</span></div>
						</li>
					<tr>
						<td class="paramlist_key" valign="top"><label id="id_numbermsg" for="id_number" class="label" ><span class="red">*</span><?php echo JText::_('PR ID_NUMBER');?> </label>
						</td>
						<td class="paramlist_value"><input title="CMND::Nhập vào số chứng minh nhân dân của bạn!" type="text" value="<?php echo $contestantDetail->id_number;?>" id="id_number" name="id_number" maxlength="100" size="40" class="conTips tipRight inputbox validate-cmnd" />
						<span id="errid_numbermsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="lbldate_of_issue" for="date_of_issue" class="label" ><span class="red">*</span><?php echo JText::_('PR DATE_OF_ISSUE');?> </label>
						</td>
						<td class="paramlist_value"><div class="conTips tipRight" style="display: inline-block;" title="Ngày cấp::Ngày cấp của chứng minh nhân dân">
						<select name="date_of_issue[]" class="select date_of_issue">
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
						</select>&nbsp;&nbsp;&nbsp;&nbsp;<select name="date_of_issue[]" class="select validate-custom-date">
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
						<select name="date_of_issue[]" class="select validate-custom-date">
							<option value="1997">1997</option>
							<option value="1998">1998</option>
							<option value="1999">1999</option>
							<option value="2000">2000</option>
							<option value="2001">2001</option>
							<option value="2002">2002</option>
							<option value="2003">2003</option>
							<option value="2004">2004</option>
							<option value="2005">2005</option>
							<option value="2006">2006</option>
							<option value="2007">2007</option>
							<option value="2008">2008</option>
							<option value="2009">2009</option>
							<option value="2010">2010</option>
							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
						</select>&nbsp;&nbsp;
						<span id="errdate_of_issuemsg" class="reerror" style="display:none;">&nbsp;</span></div>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="place_of_issuemsg" for="place_of_issue" class="label" ><span class="red">*</span><?php echo JText::_('PR PLACE_OF_ISSUE');?> </label>
						</td>
						<td class="paramlist_value"><input title="Nơi cấp::Nơi cấp giấy chứng minh nhân dân" type="text" value="<?php echo $contestantDetail->place_of_issue;?>" id="place_of_issue" name="place_of_issue" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errplace_of_issuemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>				
					<tr>
						<td class="paramlist_key" valign="top"><label id="permanent_place_of_residencemsg" for="permanent_place_of_residence" class="label" ><span class="red">*</span><?php echo JText::_('PR PERMANENT_PLACE_OF_RESIDENCE');?> </label>
						</td>
						<td class="paramlist_value"><input title="Địa chỉ thường trú::Địa chỉ thường trú" type="text" value="<?php echo $contestantDetail->permanent_place_of_residence;?>" id="permanent_place_of_residence" name="permanent_place_of_residence" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errpermanent_place_of_residencemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="contract_addressmsg" for="contract_address" class="label" ><span class="red">*</span><?php echo JText::_('PR CONTACT_ADDRESS');?> </label>
						</td>
						<td class="paramlist_value"><input title="Địa chỉ hiện tại::Địa chỉ hiện tại" type="text" value="<?php echo $contestantDetail->contract_address;?>" id="contract_address" name="contract_address" maxlength="100" size="40" class="conTips tipRight inputbox required" /> <span id="errcontract_addressmsg"class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="home_phonemsg" for="home_phone" class="label" ><?php echo JText::_('PR HOME_PHONE');?>  </label>
						</td>
						<td class="paramlist_value"><input title="Điện thoại cố định::Điện thoại cố định" type="text" value="<?php echo $contestantDetail->home_phone;?>" id="home_phone" name="home_phone" maxlength="100" size="40" class="conTips tipRight inputbox norequired" /> <span id="errhome_phonemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="mobile_phonemsg" for="mobile_phone" class="label" ><span class="red">*</span><?php echo JText::_('PR MOBILE_PHONE');?></label>
						</td>
						<td class="paramlist_value"><input title="Điện thoại di động::Số điện thoại di động của bạn. Những người dùng khác sẽ liên lạc với bạn qua số điện thoại này." type="text" value="<?php echo $contestantDetail->mobile_phone;?>" id="mobile_phone" name="mobile_phone" maxlength="100" size="40" class="conTips tipRight inputbox validate-phone" /> <span id="errmobile_phonemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="about_memsg" for="about_me" class="label" ><span class="red">*</span><?php echo JText::_('PR ABOUT ME');?></label>
						</td>
						<td class="paramlist_value">
							<TEXTAREA COLS=34 ROWS=5 title="Về Bạn::Bạn hãy trình bày đôi chút về bản thân mình, sở thích, tính cách, ước mơ..." id="about_me" name="about_me" class="conTips tipRight required" /><?php echo $contestantDetail->about_me;?></TEXTAREA>
							<span id="errabout_memsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<?php if ($task!='edit'){?>
                    <tr>
						<td class="paramlist_key" valign="top"><label id="photo_msg" for="photo" class="label" ><span class="red">*</span><?php echo JText::_('PR UPLOAD AVATAR');?>:</label>
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
						<?php echo JText::_('PR FIELD_REQUIRED');?></span>
						</td>
					</tr>
				</table>
				</fieldset>
	  </li>
      <li class="clearfix">
	    <button type="button" class="prev" style="float:left">
              &laquo; Back
            </button>
	    <button type="button" class="next right">
              Proceed &raquo;
            </button>
	  </li>
	  <br clear="all" />
	</ul>

      </div>

      <!-- page3 -->
      <div class="page">

	<h2>
	  <strong>Step 3: </strong> Congratulations! <b></b>
	  <em>You are now a happy member of the Open Source community</em>
	</h2>


	<img src="/media/img/title/eye.png"
             style="margin:30px 0 0 140px" />

	<p style="margin-top:30px">
	  <button type="button" class="prev">&laquo; Back</button>
	</p>

      </div>

    </div><!--items-->

  </div><!--wizard-->

</form>

<script>
  $(function() {
      var root = $("#wizard").scrollable();
  
      // some variables that we need
    var api = root.scrollable(), drawer = $("#drawer");

    // validation logic is done inside the onBeforeSeek callback
    api.onBeforeSeek(function(event, i) {
	
	//alert(i);
	 if(i == 0){
	 	$("#wizard").css("height", "580px");
	 }
    
    // we are going 1 step backwards so no need for validation
    if (api.getIndex() < i) {

		         // 1. get current page
				 //alert(api.getIndex());
				 if(api.getIndex() == 0){
					 $("#wizard").css("height", "1200px");
				 }
				
		         var page = root.find(".page").eq(api.getIndex()),

			 // 2. .. and all required fields inside the page
			 inputs = page.find(".required :input").removeClass("error"),

			 // 3. .. which are empty
			 empty = inputs.filter(function() {
			 return $(this).val().replace(/\s*/g, '') == '';
			 });

		         // if there are empty fields, then
		         if (empty.length) {

			 // slide down the drawer
			 drawer.slideDown(function()  {

			 // colored flash effect
			 drawer.css("backgroundColor", "#229");
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
