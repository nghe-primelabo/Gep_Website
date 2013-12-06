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


   $app_id = "93642902150"; //change this
   $app_secret = "b8c343e33c2a9b1125609759238d2a29"; //change this
   $redirect_url = "http://localhost/index.php?option=com_education&view=form&layout=facebook"; //change this


   $code = $_REQUEST["code"];
   //session_start();

   if(empty($code))
   {
	header( 'Location: http://localhost/index.php' ) ; //change this
	exit(0);
   }

   $access_token_details = getAccessTokenDetails($app_id,$app_secret,$redirect_url,$code);
   if($access_token_details == null)
   {
		echo "Unable to get Access Token";
		header( 'Location: http://localhost/index.php' );
		exit(0);
   }

   if($_SESSION['state'] == null || ($_SESSION['state'] != $_REQUEST['state']))
   {
		die("May be CSRF attack");
		header( 'Location: http://localhost/index.php' );
   }

   	$_SESSION['access_token'] = $access_token_details['access_token']; //save token is session

   $user = getUserDetails($access_token_details['access_token']);

   if( ($user) and (checkFUsser($user->id) == 0) )
   {

		?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

		<div id="contestants-wrap">

		<form action="<?php echo JRoute::_('index.php?option=com_education&task=facebook.register'); ?>" method="post" id="conForm" name="conForm" class="contestant-form-validate" enctype="multipart/form-data">

        	<fieldset>
				<legend style="color:red; text-decoration:underline"><?php echo JText::_( 'GEP WEBSITE INFOR' );?></legend>
				<table class="contentTable paramlist" cellspacing="1" cellpadding="0">

					<tr>
						<td class="paramlist_key" valign="top" width="200px"><label id="mmusernamemsg" for="username" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'GEP USERNAME' ); ?>:</label>
						</td>

						<td class="paramlist_value"><input type="text" id="username" name="username" size="40" value="<?php echo $user->username; ?>" class="required validate-username" maxlength="25" />
							<input type="hidden" name="usernamepass" id="usernamepass" value="N"/>
							<span id="errusernamemsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
                    <tr>
						<td class="paramlist_key" valign="top" width="200px"><label id="mmemailmsg" for="email" class="label"><span style="color:#FF0000">*</span><?php echo JText::_( 'GEP EMAIL' ); ?>:</label>
						</td>

						<td class="paramlist_value"><input type="text" id="email1" name="email1" size="40" value="<?php echo $user->email;?>" class="inputbox required " maxlength="100" />
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

						<td class="paramlist_value"><input type="text" value="<?php echo $user->name;?>" id="name" name="name" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errnamemsg" class="reerror" style="display:none;">&nbsp;</span>
                        <!-- <p style="float:left; clear:both; margin-left:0px"><strong><i>(Nháº­p Há»� vÃ  TÃªn cÃ³ Ä'Ã¡nh dáº¥u tiáº¿ng Viá»‡t)</i></strong></p>-->
						</td>
					</tr>

                    <tr>
						<td class="paramlist_key" valign="top"><label id="gendermsg" for="gender" class="label" ><span class="red">*</span><?php echo JText::_('GEP GENDER');?> </label>
						</td>
						<td class="paramlist_value"><select name="gender[]" class="select gender">
							<option value="male" <?php echo ($user->gender == 'male')?'selected':' ';?>>Male</option>
							<option value="female" <?php echo ($user->gender == 'female')?'selected':' ';?>>Female</option>
						</select>
						</select>
						<span id="errgendermsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>
					<tr>
						<td class="paramlist_key" valign="top"><label id="birth_daymsg" for="birth_day" class="label" ><span class="red">*</span><?php echo JText::_('GEP BIRTH_DAY');?> </label>
						</td>
						<td class="paramlist_value"><input type="text" value="<?php echo $user->birthday; ?>" id="birth_day" name="birth_day" maxlength="100" size="40" class="conTips tipRight inputbox required" />
						<span id="errbirth_daysmsg" class="reerror" style="display:none;">&nbsp;</span>
						</td>

					</tr>

					<tr>
						<td class="paramlist_key" valign="top"><label id="addressmsg" for="address" class="label" ><span class="red">*</span><?php echo JText::_('GEP CONTACT_ADDRESS');?> </label>
						</td>
						<td class="paramlist_value"><input type="text" value="<?php echo $user->hometown->name; ?>" id="address" name="address" maxlength="100" size="40" class="conTips tipRight inputbox required" /> <span id="err_addressmsg"class="reerror" style="display:none;">&nbsp;</span>
						</td>
					</tr>


					<?php //if ($task!='edit'){?>
                    <tr>
						<td class="paramlist_key" valign="top"><label id="photo_msg" for="photo" class="label" ><span class="red">*</span><?php echo JText::_('GEP UPLOAD AVATAR');?>:</label>
						</td>
						<td class="paramlist_value">
                        		<img src="https://graph.facebook.com/<?php echo $user->id;?>/picture?type=large" />
								<input type="hidden" name="Filedata" value="https://graph.facebook.com/<?php echo $user->id;?>/picture?type=large"  />

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
			<input type="hidden" name="task" value="facebook.register" />
            <input type="hidden" name="fid" value="<?php echo $user->id;?>" />
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
<?php
   }else{

	   loginFUser($user->id);

   }
function loginFUser($fid){
	$db	=& JFactory::getDBO();
	$app	= JFactory::getApplication();

	$query = 'SELECT username, password'
	. ' FROM '.$db->nameQuote( '#__fusers' )
	. ' WHERE fid = '.$fid;
	$db->setQuery( $query);
	$row = $db->loadObject();
	$username = $row->username;
	$password = $row->password;

	// Get the data login
	$data = array();
	$data['username'] = $username;
	$data['password'] = $password;

	// Get the log in credentials.
	$credentials = array();
	$credentials['username'] = $username;
	$credentials['password'] = $password;
	//var_dump($credentials);exit;

	// Perform the log in.
	if (true === $app->login($credentials)) {
		// Success
		$app->setUserState('users.login.form.data', array());
		$app->redirect(JRoute::_($app->getUserState('users.login.form.return'), false));
	} else {
		// Login failed !
		$app->setUserState('users.login.form.data', $data);
		$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
	}

}
function checkFUsser($fid){
	$db	=& JFactory::getDBO();
	$query = 'SELECT fid'
	. ' FROM '.$db->nameQuote( '#__fusers' )
	. ' WHERE fid = '.$fid;
	$db->setQuery( $query);
	$row = $db->loadObject();
	$fid = $row->fid;
		//echo $id;exit;
	return (int)$fid;

}

function getAccessTokenDetails($app_id,$app_secret,$redirect_url,$code)
{
	$token_url = "https://graph.facebook.com/oauth/access_token?"
	  . "client_id=" . $app_id . "&redirect_uri=" . urlencode($redirect_url)
	  . "&client_secret=" . $app_secret . "&code=" . $code;

	$response = file_get_contents($token_url);
	$params = null;
	parse_str($response, $params);
	return $params;
}

function getUserDetails($access_token)
{
	$graph_url = "https://graph.facebook.com/me?access_token=". $access_token;
	$user = json_decode(file_get_contents($graph_url));
	if($user != null && isset($user->name))
	return $user;
	return null;
}


 ?>

