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
defined('_JEXEC') or die('Restricted access');
jimport('joomla.utilities.date');


$birth_day = new JDate($this->profile[0]->birth_day);
$birth_day = $birth_day->toFormat(JText::_('%d/%m/%Y'));
$my = &JFactory::getUser();


?>
<script type="text/javascript" src="<?php echo JURI::base().'media/system/js/jquery.poshytip.min.js'?>"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#tooltiphelp').poshytip({
		className: 'tip-darkgray',
		content: '<div class="tooltip_content">Vì lý do hiện nay có rất nhiều hồ sơ ảo và Spam, nên BTC yêu cầu tất cả ứng viên đăng ký online phải kích hoạt tài khoản của mình bằng tin nhắn SMS . Hãy nhắn tin <span style="color:red"><strong>MS</strong></span> gửi đến <span style="color:red"><strong>8769</strong></span> (15000đ/tin nhắn) để kích hoạt tài khoản của mình. <strong>Chú ý: <span style="color:red">chỉ những hồ sơ đã được kích hoạt mới là hồ sơ hợp lệ!</span></strong></div>',
		showTimeout: 500,
		hideTimeout: 500,
		alignTo: 'cursor',
		alignX: 'right',
		alignY: 'top',
		offsetY: 40,
		offsetX: -70,
		allowTipHover: true,
		fade: true,
		slide: false
	});
	jQuery('#tooltiprereg').poshytip({
		className: 'tip-darkgray',
		content: '<div class="tooltip_content">Bạn đã tham gia cuộc thi Top Model Online Để đăng ký tham gia lại vui lòng nhắn tin <span style="color:red"><strong>MS</strong></span> gửi đến <span style="color:red"><strong>8769</strong></span> (15000đ/tin nhắn) để tiếp tục tham gia cuộc thi.',
		hideTimeout: 500,
		alignTo: 'cursor',
		alignX: 'right',
		alignY: 'top',
		offsetY: 40,
		offsetX: -70,
		allowTipHover: true,
		fade: true,
		slide: false
	});
	jQuery('#votetooltipbutton').poshytip({
			className: 'tip-darkgray',
			content: '<div class="tooltip_content">Click vào đây để bình chọn cho thí sinh mà bạn yêu thích nhất<br/> <strong style="color:red"><u>Ghi Chú:</u></strong><i>Bạn có thể bình chọn nhiều thí sinh trong ngày và chỉ bình chọn cho một thí sinh 1 lần/ngày mà thôi</i></div>',
			showTimeout: 500,
			hideTimeout: 500,
			alignTo: 'cursor',
			alignX: 'right',
			alignY: 'top',
			offsetY: 40,
			offsetX: -70,
			allowTipHover: true,
			fade: true,
			slide: false
		});

});
</script>
<?php //var_dump($this->profile);
	//var_dump($this->profile[0]->avatar);

?>
<div class="canDetail">

	<table class="contestanttable" border="0">
		<tr>
		<td class="contestantimagetd" style="text-align:left" >
			<img src="<?php echo ($this->profile[0]->avatar!='')?$this->profile[0]->avatar:'images/contestantsavatar/default_thumb.png';?>" width="250px;" />
			<?php
				/*	if( isMine($this->profile[0]->userid, $my->id) || ( isContestantAdmin() ) ){
					?>
					<a href="<?php echo JURI::base().'index.php?option=com_education&view=register&layout=reavatar&task=edit&userid='.$profile->userid;?>" >
					<span class="edit_profile_link"><?php echo JText::_('MM EDIT PROFILE PICTURE');?></span>
					</a>
					<?php
						}
					*/
				?>


			<?php //echo $html;?>

		</td>

		<td style="text-align: left;" class="contestantinfotd1">

			<div class="leftvideo">
			<p class="contestantinfor" style="clear: both;"><span id="infobold1"><strong><?php echo $this->profile[0]->full_name;?></strong></span></p>
			<p class="contestantinfor" style="clear: both;"><span id="infobold">Birth Day: </span><?php echo $birth_day;?></p>
			<p class="contestantinfor"><span id="infobold">From:</span> <?php echo $this->profile[0]->province; ?></p>
			<p class="contestantinfor"><span id="infobold">Parent Name:</span> <?php echo $this->profile[0]->parent_name;?></p>

			<div class="edit_profile_link1" style="float:right; clear:both">
			<?php
				if( isMine($this->profile[0]->userid, $my->id) || ( isContestantAdmin() ) ){
			?>
						<a href="<?php echo JURI::base().'index.php?option=com_education&view=form&task=edit&userid='.$this->profile[0]->userid;?>" style="padding-right:15px!important">
							<span class="edit_profile" style="padding-right:20px!important"><?php echo JText::_('GEP EDIT PROFILE');?></span>
						</a>
			<?php
			}
			?>
			<?php
				if( isContestantAdmin() ){
			?>

							<span class="edit_profile" onclick="mm.candidates.activeCandidadate('<?php echo $profile->userid; ?>');"><?php echo JText::_('MM ADD CANDIDATE');?></span>

			<?php
			}
			?>
			</div>

		</div>
		<?php
					//var_dump($my->id);
		 ?>
         <div style="height:15px; clear:both">&nbsp;</div>
		 <div class="about_me_title">
				Something about yourself:
			</div>
			<div class="about_me_text"><?php echo $this->profile[0]->about_me; ?></div>
			<div class="canDetailPhotoPart">
				<div class="module_longred new-img" style="clear:both; float:left; width:207px; margin-top:15px">

					<!-- <div class="about_me_title">Hình Ảnh Mới Nhất</div>-->

				</div>
			</div>
            <!--
            <div class="intro-video">
            	<h3>Video tự giới thiệu</h3>
                <div class="video">
                	<img src="components/com_contestants/images/video.png" border="0" />
                </div>
            </div>
            -->
		</td>
	</tr>
	<tr>
		<td colspan="2" width="700px">
			<div style="width:100px; float:right!important; margin-top:1px; margin-right:43px">
			<?php
				$module = &JModuleHelper::getModule('mod_mmbookmarker');
				$htmlbookmark = JModuleHelper::renderModule($module);
				echo $htmlbookmark; //echo "nghe";exit;
			?>
			</div>
			<div style="clear: both; padding-top: 15px; width:100%">
				<?php
							$comments = JPATH_SITE . DS .'components' . DS . 'com_jcomments' . DS . 'jcomments.php';
							//echo $comments;exit;
							  if (file_exists($comments)) {
								require_once($comments);
								echo JComments::showComments($this->profile[0]->id, 'com_education', ' Candidate ');
							  }
					?>

			</div>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<?php if ( isMine($this->profile[0]->userid, $my->id) ) {

 ?>

<script type="text/javascript">
jQuery(document).ready(function(){


	//alert('nghe');
	var profileStatus = jQuery('#profileStatus');
	var statusText    = jQuery('#profileStatusText');
	var saveStatus    = jQuery('#save-status');
	//alert(saveStatus);
    var editStatus    = jQuery('#edit-status');
    var setBlankModeTimer;


    statusText.data('MM_PROFILE_STATUS_INSTRUCTION', '<?php echo addslashes(JText::_('MM PROFILE STATUS INSTRUCTION')); ?>')

    function setBlankMode() {
        if (jQuery.trim(statusText.val())=='')
        {
            profileStatus.removeClass('editMode')
                         .addClass('blankMode');
            statusText.val(statusText.data('MM_PROFILE_STATUS_INSTRUCTION'));
            updateTextarea();
        } else {
            profileStatus.removeClass('editMode');
        	statusText.val(statusText.data('oldStatusText'));
            updateTextarea();
        }
    }

    function setEditMode()
    {
		//alert('set edit mode');
    	statusText.data('oldStatusText', statusText.val());

        if (profileStatus.hasClass('blankMode'))
        {
            statusText.val('');
        } else {
            statusText.select();
        }

        profileStatus.removeClass('blankMode')
                     .addClass('editMode');

        updateTextarea();
    }

    function updateTextarea()
    {
        mm.utils.textAreaWidth(statusText);
        //mm.utils.autogrow(statusText);
    }

    // First time init
    setBlankMode();
    updateTextarea();

	//alert(statusText);

    statusText.focus(function()
    {
		//alert('focus');
        setEditMode();
    }).blur(function()
    {
        setBlankModeTimer = setTimeout(function(){setBlankMode();}, 200);
    });

    saveStatus.click(function()
    {
		//alert('savestatus click');
    	clearTimeout(setBlankModeTimer);

        var newStatusText = statusText.val();

		//alert(newStatusText.val());

        if (newStatusText!=statusText.data('oldStatusText'))
        {
			//alert(statusText.val());
            jaxcontestant.call_contestants('contestants', 'status', 'ajaxUpdate', statusText.val());
            jQuery('#profile-status-message').html(newStatusText);
        }

        profileStatus.removeClass('editMode');
    });

    editStatus.click(function()
    {
        statusText.trigger('focus');
    });
});
</script>
<?php } else { ?>
<script type="text/javascript" language="javascript">
jQuery(document).ready(function(){
	var statusText = jQuery('#profileStatusText');
	setTimeout(function(){
		mm.utils.textAreaWidth(statusText);
	}, 1000);
});
</script>
<?php } ?>

<!--
<script type="text/javascript">

// Create the tooltips only on document load
jQuery(document).ready(function()
{

   jQuery('#tooltiphelp')
      .hover(function()
      {
         // Destroy currrent tooltip if present
          if(jQuery(this).data("qtip")) jQuery(this).qtip("destroy");
         jQuery(this).html('Hồ sơ chưa kích hoạt') // Set the links HTML to the current opposite corner
            .qtip({
               content: 'Vì lý do hiện nay có rất nhiều hồ sơ ảo và Spam, nên BTC yêu cầu tất cả ứng viên đăng ký online phải kích hoạt tài khoản của mình bằng tin nhắn SMS . Hãy nhắn tin <span style="color:red"><strong>MS</strong></span> gửi đến <span style="color:red"><strong>6558</strong></span> (5000đ/tin nhắn) để kích hoạt tài khoản của mình. <strong>Chú ý: <span style="color:red">chỉ những hồ sơ đã được kích hoạt mới là hồ sơ hợp lệ!</span></strong>', // Set the tooltip content to the current corner
               position: {
                  corner: {
                     tooltip: 'bottomRight', // Use the corner...
                     target: 'bottomRight' // ...and opposite corner
                  }
               },
               show: {
                  when: false, // Don't specify a show event
                  ready: true // Show the tooltip when ready
               },
               hide: 'mouseover',
               style: {
                  border: {
                     width: 5,
                     radius: 10
                  },
                  padding: 10,
                  textAlign: 'center',
                  tip: true, // Give it a speech bubble tip with automatic corner detection
                  name: 'dark' // Style it according to the preset 'cream' style
               }
            });

         //i++; // Increase the counter
      });

});
</script>
-->
