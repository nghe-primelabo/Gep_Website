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

require_once JPATH_COMPONENT.'/controller.php';
include(JPATH_COMPONENT.DS.'assets'.DS.'functions.php');
include(JPATH_COMPONENT.DS.'assets'.DS.'ajax_contestants.php');
include(JPATH_COMPONENT.DS.'libraries/core.php');

/**
 * Registration controller class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class EducationControllerRegistration extends EducationController
{
	/**
	 * Method to activate a user.
	 *
	 * @return	boolean		True on success, false on failure.
	 * @since	1.6
	 */
	public function activate()
	{
		$user		= JFactory::getUser();
		$uParams	= JComponentHelper::getParams('com_users');

		// If the user is logged in, return them back to the homepage.
		if ($user->get('id')) {
			$this->setRedirect('index.php');
			return true;
		}

		// If user registration or account activation is disabled, throw a 403.
		if ($uParams->get('useractivation') == 0 || $uParams->get('allowUserRegistration') == 0) {
			JError::raiseError(403, JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'));
			return false;
		}

		$model = $this->getModel('Registration', 'UsersModel');
		$token = JRequest::getVar('token', null, 'request', 'alnum');

		// Check that the token is in a valid format.
		if ($token === null || strlen($token) !== 32) {
			JError::raiseError(403, JText::_('JINVALID_TOKEN'));
			return false;
		}

		// Attempt to activate the user.
		$return = $model->activate($token);

		// Check for errors.
		if ($return === false) {
			// Redirect back to the homepage.
			$this->setMessage(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $model->getError()), 'warning');
			$this->setRedirect('index.php');
			return false;
		}

		$useractivation = $uParams->get('useractivation');

		// Redirect to the login screen.
		if ($useractivation == 0)
		{
			$this->setMessage(JText::_('COM_USERS_REGISTRATION_SAVE_SUCCESS'));
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=login', false));
		}
		elseif ($useractivation == 1)
		{
			$this->setMessage(JText::_('COM_USERS_REGISTRATION_ACTIVATE_SUCCESS'));
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=login', false));
		}
		elseif ($return->getParam('activate'))
		{
			$this->setMessage(JText::_('COM_USERS_REGISTRATION_VERIFY_SUCCESS'));
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=registration&layout=complete', false));
		}
		else
		{
			$this->setMessage(JText::_('COM_USERS_REGISTRATION_ADMINACTIVATE_SUCCESS'));
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=registration&layout=complete', false));
		}
		return true;
	}

	/**
	 * Method to register a user.
	 *
	 * @return	boolean		True on success, false on failure.
	 * @since	1.6
	 */
	public function register()
	{
		//JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		//echo "i am here"; exit;

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('Registration', 'EducationModel');

		// Get the user data.
		$requestData = JRequest::get( 'post' );


		// Validate the posted data.
		$form	= $model->getForm();

		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		// Attempt to save the data.
		$return	= $model->register($requestData);

		$this->setRedirect(JRoute::_('index.php?option=com_education&view=form&layout=thankyou', false));

		return true;
	}

	function ajaxSetMessage(){


	   $data = getPostData();
	   //var_dump($data);exit;
	   $fieldName = $data[0];
	   $txtLabel = $data[1];
	   $strMessage = $data[2];

       $objResponse   = new JAXResponseContestant();

       $langMsg = '';
       if(! empty($strMessage)){
           $langMsg = (empty($strParam)) ? JText::_($strMessage) : JText::sprintf($strMessage, $strParam);
       }

	   $myLabel = ($txtLabel == 'Field') ? JText::_('GEP_FIELD') : $txtLabel;

	   //echo $fieldName;exit;

       $langMsg = (empty($txtLabel)) ? $langMsg : $myLabel.'_'.$langMsg;
       if($fieldName == 'password2' ){
       	$langMsg = JText::_('GEP PASSWORD NOT SAME');
       }elseif($fieldName == 'id_number'){
       	$langMsg = JText::_('GEP INVALID NUMBER CARD');
       }elseif($fieldName == 'mobile_phone'){
       	$langMsg = JText::_('GEP INVALID PHONE');
       }else{
       		$langMsg = JText::_('GEP_FIELD_GEP_INVALID_VALUE');
       }


       $objResponse->addScriptCall('jQuery("#err'.$fieldName.'msg").html("<br />'.$langMsg.'");');
       $objResponse->addScriptCall('jQuery("#err'.$fieldName.'msg").show();');

       return $objResponse->sendResponse();
	}
	function ajaxCheckUserName(){

		//echo "i am at check username";exit;
		$data = getPostData();
		$objResponse   = new JAXResponseContestant();

	    $username	= $data[0];
	    $ipaddress	= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
	    $model		=& $this->getModel('registration');

	    //var_dump($model);exit;

	    $isInvalid	= false;
	    $msg		= '';

	    CFactory::load( 'helpers' , 'user' );
	    if(! empty($username))
	    {
		    if(! cValidUsername($username))
		    {
		    	$isInvalid	= true;
		    	$msg		= JText::_('GEP IMGEPOPER USERNAME');
		    }
		}


	    if(! empty($username) && !$isInvalid){
	    	//echo $username;exit;
	        $isInvalid = $model->isUserNameExists(array('username'=>$username, 'ip'=>$ipaddress));
			$msg = JText::sprintf('GEP USERNAME EXIST', $username);
	    }

	    if($isInvalid){
	    	//echo $isInvalid;exit;
			$objResponse->addScriptCall('jQuery("#username").addClass("invalid");');
			$objResponse->addScriptCall('jQuery("#errusernamemsg").show();');
			$objResponse->addScriptCall('jQuery("#errusernamemsg").html("<br/>'.$msg.'");');
			$objResponse->addScriptCall('jQuery("#usernamepass").val("N");');
			$objResponse->addScriptCall('false;');
        } else {
        	//echo $isInvalid;exit;
			$objResponse->addScriptCall('jQuery("#username").removeClass("invalid");');
			$objResponse->addScriptCall('jQuery("#errusernamemsg").html("&nbsp");');
			$objResponse->addScriptCall('jQuery("#errusernamemsg").hide();');
			$objResponse->addScriptCall('jQuery("#usernamepass").val("'.$username.'");');
			$objResponse->addScriptCall('true;');
        }

        return $objResponse->sendResponse();
	}
	function ajaxCheckUserNameTab(){

		//echo "i am at check username";exit;
		$data = getPostData();

		//var_dump($data);exit;

		$objResponse   = new JAXResponseContestant();

	    $username	= $data[0];
	    $ipaddress	= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
	    $model		=& $this->getModel('registration');

	    //var_dump($model);exit;

	    $isInvalid	= false;
	    $msg		= '';

	    CFactory::load( 'helpers' , 'user' );
	    if(! empty($username))
	    {
		    if(! cValidUsername($username))
		    {
		    	$isInvalid	= true;
		    	$msg		= JText::_('GEP IMPROPER USERNAME');
		    }
		}


	    if(! empty($username) && !$isInvalid){
	    	//echo $username;exit;
	        $isInvalid = $model->isUserNameExists(array('username'=>$username, 'ip'=>$ipaddress));

	    }

	    if($isInvalid){
	    	$objResponse->addScriptCall('true;');
        } else {
        	$objResponse->addScriptCall('false;');
        }

        return $objResponse->sendResponse();
	}


	function ajaxCheckEmail(){
		$data = getPostData();
	    $objResponse   = new JAXResponseContestant();

	    $email 		= $data[0];
	    $ipaddress	= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
	    $model 		=& $this->getModel('registration');

	    $isExists = false;
	    if(! empty($email)){
	        $isExists = $model->isEmailExists(array('email'=>$email, 'ip'=>$ipaddress));
	    }

	    $msg = JText::sprintf('GEP EMAIL EXIST', $email);

	    if($isExists){
			$objResponse->addScriptCall('jQuery("#email1").addClass("invalid");');
			$objResponse->addScriptCall('jQuery("#erremail1msg").show();');
			$objResponse->addScriptCall('jQuery("#erremail1msg").html("<br/>'.$msg.'");');
			$objResponse->addScriptCall('jQuery("#emailpass").val("N");');
			$objResponse->addScriptCall('false;');
        } else {
			$objResponse->addScriptCall('jQuery("#email1").removeClass("invalid");');
			$objResponse->addScriptCall('jQuery("#erremail1msg").html("&nbsp");');
			$objResponse->addScriptCall('jQuery("#erremail1msg").hide();');
			$objResponse->addScriptCall('jQuery("#emailpass").val("'.$email.'");');
			$objResponse->addScriptCall('true;');
        }

        return $objResponse->sendResponse();
	}
	function ajaxGenerateAuthKey(){
		//echo "this is nghe";exit;
	    $objResponse   = new JAXResponseContestant();

	    $authKey	= "";
	    $ipaddress	= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

		$mySess 	=& JFactory::getSession();

	    $newToken	= $mySess->getToken(true);
		$mySess->set('MM_REG_TOKEN', $newToken);

	    if(! $mySess->has('MM_REG_TOKEN'))
	    {
	    	$message = JText::_('MM REG AUTH ERROR');
	    	$objResponse->addScriptCall("mm.registrations.showWarning('".$message."');");

	    	// Renable the submit button
	    	$objResponse->addScriptCall("jQuery('#btnSubmit').show();");
	    	$objResponse->addScriptCall("jQuery('#cwin-wait').hide();");
	    	$objResponse->addScriptCall("try{console.log('".$mySess->getId()."');}catch(e){}");
			return $objResponse->sendResponse();
	    }



	    //$token		= JUtility::getToken();
		$token	= $mySess->get('MM_REG_TOKEN','');

	    //generate a dynamic authentication key
	    $authKey	= md5(uniqid(rand(), true));

	    $model 		=& $this->getModel('register');

	    if($model->addAuthKey($authKey))
	    {
	    	//echo "add auth key";exit;
		    $objResponse->addScriptCall("mm.registrations.assignAuthKey('conForm','authkey','".$authKey."');");
		    $objResponse->addScriptCall("jQuery('#authenticate').val('1');");
		    $objResponse->addScriptCall("jQuery('#btnSubmit').click();");
	    }
	    else
	    {
	    	$message = JText::_('MM REG AUTH ERROR');
	    	$objResponse->addScriptCall("mm.registrations.showWarning('".$message."');");
	    }
        return $objResponse->sendResponse();
	}

	function ajaxAssignAuthKey()
	{
	    $objResponse   = new JAXResponseContestant();

	    $authKey	= "";
	    $ipaddress	= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

		$mySess 	=& JFactory::getSession();
		$token		= $mySess->get('MM_REG_TOKEN','');

		//echo $token;exit;

	    $model 		=& $this->getModel('register');
	    $authKey	= $model->getAuthKey ($token, $ipaddress);

	    $objResponse->addScriptCall("mm.registrations.assignAuthKey('conForm','authkey','".$authKey."');");
	    $objResponse->addScriptCall("jQuery('#authenticate').val('1');");
	    $objResponse->addScriptCall("jQuery('#btnSubmit').click();");

        return $objResponse->sendResponse();
	}

}
