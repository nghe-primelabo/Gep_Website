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

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

/**
 * Registration model class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class EducationModelRegistration extends JModelForm
{
	/**
	 * @var		object	The user registration data.
	 * @since	1.6
	 */
	protected $data;

	/**
	 * Method to activate a user account.
	 *
	 * @param	string		The activation token.
	 * @return	mixed		False on failure, user object on success.
	 * @since	1.6
	 */
	public function activate($token)
	{
		$config	= JFactory::getConfig();
		$userParams	= JComponentHelper::getParams('com_users');
		$db		= $this->getDbo();

		// Get the user id based on the token.
		$db->setQuery(
			'SELECT '.$db->quoteName('id').' FROM '.$db->quoteName('#__users') .
			' WHERE '.$db->quoteName('activation').' = '.$db->Quote($token) .
			' AND '.$db->quoteName('block').' = 1' .
			' AND '.$db->quoteName('lastvisitDate').' = '.$db->Quote($db->getNullDate())
		);
		$userId = (int) $db->loadResult();

		// Check for a valid user id.
		if (!$userId) {
			$this->setError(JText::_('COM_USERS_ACTIVATION_TOKEN_NOT_FOUND'));
			return false;
		}

		// Load the users plugin group.
		JPluginHelper::importPlugin('user');

		// Activate the user.
		$user = JFactory::getUser($userId);

		// Admin activation is on and user is verifying their email
		if (($userParams->get('useractivation') == 2) && !$user->getParam('activate', 0))
		{
			$uri = JURI::getInstance();

			// Compile the admin notification mail values.
			$data = $user->getProperties();
			$data['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
			$user->set('activation', $data['activation']);
			$data['siteurl']	= JUri::base();
			$base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
			$data['activate'] = $base.JRoute::_('index.php?option=com_users&task=registration.activate&token='.$data['activation'], false);
			$data['fromname'] = $config->get('fromname');
			$data['mailfrom'] = $config->get('mailfrom');
			$data['sitename'] = $config->get('sitename');
			$user->setParam('activate', 1);
			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACTIVATE_WITH_ADMIN_ACTIVATION_SUBJECT',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_ACTIVATE_WITH_ADMIN_ACTIVATION_BODY',
				$data['sitename'],
				$data['name'],
				$data['email'],
				$data['username'],
				$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation']
			);

			// get all admin users
			$query = 'SELECT name, email, sendEmail, id' .
						' FROM #__users' .
						' WHERE sendEmail=1';

			$db->setQuery( $query );
			$rows = $db->loadObjectList();

			// Send mail to all users with users creating permissions and receiving system emails
			foreach( $rows as $row )
			{
				$usercreator = JFactory::getUser($id = $row->id);
				if ($usercreator->authorise('core.create', 'com_users'))
				{
					$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBody);

					// Check for an error.
					if ($return !== true) {
						$this->setError(JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED'));
						return false;
					}
				}
			}
		}

		//Admin activation is on and admin is activating the account
		elseif (($userParams->get('useractivation') == 2) && $user->getParam('activate', 0))
		{
			$user->set('activation', '');
			$user->set('block', '0');

			$uri = JURI::getInstance();

			// Compile the user activated notification mail values.
			$data = $user->getProperties();
			$user->setParam('activate', 0);
			$data['fromname'] = $config->get('fromname');
			$data['mailfrom'] = $config->get('mailfrom');
			$data['sitename'] = $config->get('sitename');
			$data['siteurl']	= JUri::base();
			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACTIVATED_BY_ADMIN_ACTIVATION_SUBJECT',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_ACTIVATED_BY_ADMIN_ACTIVATION_BODY',
				$data['name'],
				$data['siteurl'],
				$data['username']
			);

			$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

			// Check for an error.
			if ($return !== true) {
				$this->setError(JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED'));
				return false;
			}
		}
		else
		{
			$user->set('activation', '');
			$user->set('block', '0');
		}

		// Store the user object.
		if (!$user->save()) {
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_ACTIVATION_SAVE_FAILED', $user->getError()));
			return false;
		}

		return $user;
	}

	/**
	 * Method to get the registration form data.
	 *
	 * The base form data is loaded and then an event is fired
	 * for users plugins to extend the data.
	 *
	 * @return	mixed		Data object on success, false on failure.
	 * @since	1.6
	 */
	public function getData()
	{
		if ($this->data === null) {

			$this->data	= new stdClass();
			$app	= JFactory::getApplication();
			$params	= JComponentHelper::getParams('com_users');

			// Override the base user data with any data in the session.
			$temp = (array)$app->getUserState('com_users.registration.data', array());
			foreach ($temp as $k => $v) {
				$this->data->$k = $v;
			}

			// Get the groups the user should be added to after registration.
			$this->data->groups = array();

			// Get the default new user group, Registered if not specified.
			$system	= $params->get('new_usertype', 2);

			$this->data->groups[] = $system;

			// Unset the passwords.
			unset($this->data->password1);
			unset($this->data->password2);

			// Get the dispatcher and load the users plugins.
			$dispatcher	= JDispatcher::getInstance();
			JPluginHelper::importPlugin('user');

			// Trigger the data preparation event.
			$results = $dispatcher->trigger('onContentPrepareData', array('com_users.registration', $this->data));

			// Check for errors encountered while preparing the data.
			if (count($results) && in_array(false, $results, true)) {
				$this->setError($dispatcher->getError());
				$this->data = false;
			}
		}
		//var_dump($this->data);exit;

		return $this->data;
	}

	/**
	 * Method to get the registration form.
	 *
	 * The base form is loaded from XML and then an event is fired
	 * for users plugins to extend the form with extra fields.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		//echo "i am at get form";exit;
		//var_dump($loadData);exit;
		// Get the form.
		$form = $this->loadForm('com_education.registration', 'registration', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		return $this->getData();
	}

	/**
	 * Override preprocessForm to load the user plugin group instead of content.
	 *
	 * @param	object	A form object.
	 * @param	mixed	The data expected for the form.
	 * @throws	Exception if there is an error in the form event.
	 * @since	1.6
	 */
	protected function preprocessForm(JForm $form, $data, $group = 'user')
	{
		$userParams	= JComponentHelper::getParams('com_users');

		//Add the choice for site language at registration time
		if ($userParams->get('site_language') == 1 && $userParams->get('frontend_userparams') == 1)
		{
			$form->loadFile('sitelang', false);
		}

		parent::preprocessForm($form, $data, $group);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		// Get the application object.
		$app	= JFactory::getApplication();
		$params	= $app->getParams('com_users');

		// Load the parameters.
		$this->setState('params', $params);
	}

	/**
	 * Method to save the form data.
	 *
	 * @param	array		The form data.
	 * @return	mixed		The user id on success, false on failure.
	 * @since	1.6
	 */
	public function register($data)
	{
		$config = JFactory::getConfig();
		$db		= $this->getDbo();
		$params = JComponentHelper::getParams('com_users');

		$userid = JRequest::getVar('userid', 0);

		// Initialise the table with JUser.
		$user = new JUser;


		// Prepare the data for the user object.
		$data['email']		= $data['email1'];
		$data['email2']		= $data['email1'];
		$data['password']	= $data['password1'];
		$data['password2']	= $data['password1'];
		$data['id']			= $userid;
		$data['groups']		= array(2);
		$useractivation = $params->get('useractivation');
		$sendpassword = $params->get('sendpassword', 1);

		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		$size = strlen( $chars );
		for( $i = 0; $i < 5; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		//return $str;


		//$email = \"somebody@somesite.com\"; // Valid email address
		// Set up regular expression strings to evaluate the value of email variable against
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		// Run the preg_match() function on regex against the email address
		if (preg_match($regex, $data['email'])) {
		    $data['email'] = $data['email'];
		} else {
		     $data['email'] = 'noemail'.$str.'@yahoo.com';
		}

		//var_dump($data); exit;

		// Check if the user needs to activate their account.
		/*if (($useractivation == 1) || ($useractivation == 2)) {
			$data['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
			$data['block'] = 1;
		}*/

		// Bind the data.
		//var_dump($data);exit;
		if (!$user->bind($data)) {
			//echo "i am here"; exit;
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
			//return false;
		}


		// Load the users plugin group.
		JPluginHelper::importPlugin('user');

      // var_dump($data);exit;
		// Store the data.
		if (!$user->save()) {
			//echo "i am here"; exit;
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
			//return false;
		}
		if ($userid > 0){
			$this->saveEditStudent($userid, $data);
		}else{
			$this->saveStudent($user->id, $data);
		}

		// Compile the notification mail values.
		$data = $user->getProperties();
		$data['fromname']	= $config->get('fromname');
		$data['mailfrom']	= $config->get('mailfrom');
		$data['sitename']	= $config->get('sitename');
		$data['siteurl']	= JUri::root();

		// Handle account activation/confirmation emails.
		if ($useractivation == 2)
		{
			// Set the link to confirm the user email.
			$uri = JURI::getInstance();
			$base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
			$data['activate'] = $base.JRoute::_('index.php?option=com_users&task=registration.activate&token='.$data['activation'], false);

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			if ($sendpassword)
			{
				$emailBody = JText::sprintf(
					'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY',
					$data['name'],
					$data['sitename'],
					$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
					$data['siteurl'],
					$data['username'],
					$data['password_clear']
				);
			}
			else
			{
				$emailBody = JText::sprintf(
					'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY_NOPW',
					$data['name'],
					$data['sitename'],
					$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
					$data['siteurl'],
					$data['username']
				);
			}
		}
		elseif ($useractivation == 1)
		{
			// Set the link to activate the user account.
			$uri = JURI::getInstance();
			$base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
			$data['activate'] = $base.JRoute::_('index.php?option=com_users&task=registration.activate&token='.$data['activation'], false);

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			if ($sendpassword)
			{
				$emailBody = JText::sprintf(
					'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY',
					$data['name'],
					$data['sitename'],
					$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
					$data['siteurl'],
					$data['username'],
					$data['password_clear']
				);
			}
			else
			{
				$emailBody = JText::sprintf(
					'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY_NOPW',
					$data['name'],
					$data['sitename'],
					$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
					$data['siteurl'],
					$data['username']
				);
			}
		}
		else
		{

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_BODY',
				$data['name'],
				$data['sitename'],
				$data['siteurl']
			);
		}

		// Send the registration email.
		$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

		//Send Notification mail to administrators
		if (($params->get('useractivation') < 2) && ($params->get('mail_to_admin') == 1)) {
			$emailSubject = JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBodyAdmin = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY',
				$data['name'],
				$data['username'],
				$data['siteurl']
			);

			// get all admin users
			$query = 'SELECT name, email, sendEmail' .
					' FROM #__users' .
					' WHERE sendEmail=1';

			$db->setQuery( $query );
			$rows = $db->loadObjectList();

			// Send mail to all superadministrators id
			foreach( $rows as $row )
			{
				$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);

				// Check for an error.
				if ($return !== true) {
					$this->setError(JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED'));
					return false;
				}
			}
		}
		// Check for an error.
		if ($return !== true) {
			$this->setError(JText::_('COM_USERS_REGISTRATION_SEND_MAIL_FAILED'));

			// Send a system message to administrators receiving system mails
			$db = JFactory::getDBO();
			$q = "SELECT id
				FROM #__users
				WHERE block = 0
				AND sendEmail = 1";
			$db->setQuery($q);
			$sendEmail = $db->loadColumn();
			if (count($sendEmail) > 0) {
				$jdate = new JDate();
				// Build the query to add the messages
				$q = "INSERT INTO ".$db->quoteName('#__messages')." (".$db->quoteName('user_id_from').
				", ".$db->quoteName('user_id_to').", ".$db->quoteName('date_time').
				", ".$db->quoteName('subject').", ".$db->quoteName('message').") VALUES ";
				$messages = array();

				foreach ($sendEmail as $userid) {
					$messages[] = "(".$userid.", ".$userid.", '".$jdate->toSql()."', '".JText::_('COM_USERS_MAIL_SEND_FAILURE_SUBJECT')."', '".JText::sprintf('COM_USERS_MAIL_SEND_FAILURE_BODY', $return, $data['username'])."')";
				}
				$q .= implode(',', $messages);
				$db->setQuery($q);
				$db->query();
			}
			return false;
		}

		if ($useractivation == 1)
			return "useractivate";
		elseif ($useractivation == 2)
			return "adminactivate";
		else
			return $user->id;

		//$this->addavatar($user->id);
	}
	function addavatar($userid){

		//echo 'i am at addavatar';exit;

		$mainframe =& JFactory::getApplication();
		jimport('joomla.filesystem.file');
		jimport('joomla.utilities.utility');
		$post		= JRequest::get('post');

		CFactory::load( 'helpers' , 'image' );

		// Load avatar library
		CFactory::load( 'libraries' , 'avatar' );

		$file		= JRequest::getVar( 'Filedata' , '' , 'FILES' , 'array' );
		$file1		= JRequest::getVar( 'sketch_design1' , '' , 'FILES' , 'array' );
		$file2		= JRequest::getVar( 'sketch_design2' , '' , 'FILES' , 'array' );
		$file3		= JRequest::getVar( 'sketch_design3' , '' , 'FILES' , 'array' );
		$file4		= JRequest::getVar( 'sketch_design4' , '' , 'FILES' , 'array' );
		$file5		= JRequest::getVar( 'sketch_design5' , '' , 'FILES' , 'array' );

		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		$size = strlen( $chars );
		for( $i = 0; $i < 5; $i++ ) {
			$randStr .= $chars[ rand( 0, $size - 1 ) ];
		}

		if( !empty( $file1['tmp_name'] ) ){

			//Clean up filename to get rid of strange characters like spaces etc
			$filename1 = $randStr.JFile::makeSafe($file1['name']);

			//Set up the source and destination of the file
			$src1 = $file1['tmp_name'];
			$path_sketch_design1 = JPATH_ROOT . DS . 'images' . DS . 'sketch_design' . DS;
			$dest1 = $path_sketch_design1 . $filename1;

			//echo $src1;
			//echo $dest1;exit;

			if ( JFile::upload($src1, $dest1) ) {
			   	$db = JFactory::getDBO();
				$query = "UPDATE #__candidates SET"
	            	. '`sketch_design1`='.$db->Quote($filename1)
	            	. ' WHERE `userid` ='.$db->Quote($userid)
	            	;
	       		$db->setQuery($query);
            	$db->query();
			}


		}
		if(!empty( $file2['tmp_name'] ) ){

			//Clean up filename to get rid of strange characters like spaces etc
			$filename2 = $randStr.JFile::makeSafe($file2['name']);

			//Set up the source and destination of the file
			$src2 = $file2['tmp_name'];
			$path_sketch_design2 = JPATH_ROOT . DS . 'images' . DS . 'sketch_design';
			$dest2 = $path_sketch_design2 . $filename2;

			if ( JFile::upload($src2, $dest2) ) {
			   	$db = JFactory::getDBO();
				$query = "UPDATE #__candidates SET"
	            	. '`sketch_design2`='.$db->Quote($filename2)
	            	. ' WHERE `userid` ='.$db->Quote($userid)
	            	;
	       		$db->setQuery($query);
            	$db->query();
			}


		}
		if( !empty( $file3['tmp_name'] ) ){

			//Clean up filename to get rid of strange characters like spaces etc
			$filename3 = $randStr.JFile::makeSafe($file3['name']);

			//Set up the source and destination of the file
			$src3 = $file3['tmp_name'];
			$path_sketch_design3 = JPATH_ROOT . DS . 'images' . DS . 'sketch_design';
			$dest3 = $path_sketch_design3 . $filename3;

			if ( JFile::upload($src3, $dest3) ) {
			   	$db = JFactory::getDBO();
				$query = "UPDATE #__candidates SET"
	            	. '`sketch_design3`='.$db->Quote($filename3)
	            	. ' WHERE `userid` ='.$db->Quote($userid)
	            	;
	       		$db->setQuery($query);
            	$db->query();
			}


		}
		if( !empty( $file4['tmp_name'] ) ){

			//Clean up filename to get rid of strange characters like spaces etc
			$filename4 = $randStr.JFile::makeSafe($file4['name']);

			//Set up the source and destination of the file
			$src4 = $file4['tmp_name'];
			$path_sketch_design4 = JPATH_ROOT . DS . 'images' . DS . 'sketch_design';
			$dest4 = $path_sketch_design4 . $filename4;

			if ( JFile::upload($src4, $dest4) ) {
			   	$db = JFactory::getDBO();
				$query = "UPDATE #__candidates SET"
	            	. '`sketch_design4`='.$db->Quote($filename4)
	            	. ' WHERE `userid` ='.$db->Quote($userid)
	            	;
	       		$db->setQuery($query);
            	$db->query();
			}


		}
		if( !empty( $file5['tmp_name'] ) ){

			//Clean up filename to get rid of strange characters like spaces etc
			$filename5 = $randStr.JFile::makeSafe($file5['name']);

			//Set up the source and destination of the file
			$src5 = $file5['tmp_name'];
			$path_sketch_design5 = JPATH_ROOT . DS . 'images' . DS . 'sketch_design';
			$dest5 = $path_sketch_design5 . $filename5;

			if ( JFile::upload($src5, $dest5) ) {
			   	$db = JFactory::getDBO();
				$query = "UPDATE #__candidates SET"
	            	. '`sketch_design5`='.$db->Quote($filename5)
	            	. ' WHERE `userid` ='.$db->Quote($userid)
	            	;
	       		$db->setQuery($query);
            	$db->query();
			}


		}

		if( !isset( $file['tmp_name'] ) || empty( $file['tmp_name'] ) )
		{
			$mainframe->enqueueMessage(JText::_('MM NO POST DATA'), 'error');
		}
		else
		{
			if( !cValidImage($file['tmp_name'] ) )
			{
				$mainframe->enqueueMessage(JText::_('MM IMAGE FILE NOT SUPPORTED'), 'error');
			}
			else
			{
				//echo "else valide image";exit;
				$imageSize		= cImageGetSize( $file['tmp_name'] );

				//var_dump($imageSize);exit;

				// @todo: configurable width?
				$imageMaxWidth	= 250;

				/*if( $imageSize->width > $imageMaxWidth )
				{
					$mainframe->enqueueMessage( JText::sprintf('MM IMAGE WIDTH LARGER' , $imageSize->width , $imageMaxWidth ) );
				}*/

				// Get a hash for the file name.
				$fileName		= JUtility::getHash( $file['tmp_name'] . time() );
				//echo $fileName;exit;
				$hashFileName	= JString::substr( $fileName , 0 , 24 );

				//@todo: configurable path for avatar storage?
				$storage			= JPATH_ROOT . DS . 'images' . DS . 'avatar';
				$storageImage		= $storage . DS . $hashFileName . cImageTypeToExt( $file['type'] );
				$storageThumbnail	= $storage . DS . 'thumb_' . $hashFileName . cImageTypeToExt( $file['type'] );
				$image				= 'images/avatar/' . $hashFileName . cImageTypeToExt( $file['type'] );
				$thumbnail			= 'images/avatar/' . 'thumb_' . $hashFileName . cImageTypeToExt( $file['type'] );

				//$userModel			=$this->getModel( 'user ');

				// Generate full image
				if(!cImageResizePropotional( $file['tmp_name'] , $storageImage , $file['type'] , $imageMaxWidth ) )
				{
					$mainframe->enqueueMessage(JText::sprintf('MM ERROR MOVING UPLOADED FILE' , $storageImage), 'error');
				}
				// Generate thumbnail
				if(!cImageCreateThumb( $file['tmp_name'] , $storageThumbnail , $file['type'] ))
				{
					$mainframe->enqueueMessage(JText::sprintf('MM ERROR MOVING UPLOADED FILE' , $storageThumbnail), 'error');
				}
				//connect and insert into database


				$db = JFactory::getDBO();
				$query = "UPDATE #__candidates SET"
	            	. '`avatar`='.$db->Quote($image)
	            	. ', `thumb`='.$db->Quote($thumbnail)
	            	. ' WHERE `userid` ='.$db->Quote($userid)
	            	;
	        $db->setQuery($query);
            $db->query();

			}
		}
		//redirect to successful page

	}
	function saveStudent($userid, $fields){

		$db = JFactory::getDBO();

		//var_dump($fields);exit;

		//control the avatar file
		$mainframe =& JFactory::getApplication();
		jimport('joomla.filesystem.file');
		jimport('joomla.utilities.utility');
		//$post		= JRequest::get('post');

		CFactory::load( 'helpers' , 'image' );

		// Load avatar library
		CFactory::load( 'libraries' , 'avatar' );

		$file		= JRequest::getVar( 'Filedata' , '' , 'FILES' , 'array' );


		if( !isset( $file['tmp_name'] ) || empty( $file['tmp_name'] ) )
		{
			$mainframe->enqueueMessage(JText::_('MM NO POST DATA'), 'error');
		}
		else
		{
			if( !cValidImage($file['tmp_name'] ) )
			{
				$mainframe->enqueueMessage(JText::_('MM IMAGE FILE NOT SUPPORTED'), 'error');
			}
			else
			{
				//echo "else valide image";exit;
				$imageSize		= cImageGetSize( $file['tmp_name'] );


				// @todo: configurable width?
				$imageMaxWidth	= 200;

				/*if( $imageSize->width > $imageMaxWidth )
				{
					$mainframe->enqueueMessage( JText::sprintf('MM IMAGE WIDTH LARGER' , $imageSize->width , $imageMaxWidth ) );
				}*/

				// Get a hash for the file name.
				$fileName		= JUtility::getHash( $file['tmp_name'] . time() );
				//echo $fileName;exit;
				$hashFileName	= JString::substr( $fileName , 0 , 24 );

				//@todo: configurable path for avatar storage?
				$storage			= JPATH_ROOT . DS . 'images' . DS . 'students';
				$storageImage		= $storage . DS . $hashFileName . cImageTypeToExt( $file['type'] );
				$storageThumbnail	= $storage . DS . 'thumb_' . $hashFileName . cImageTypeToExt( $file['type'] );
				$image				= 'images/students/' . $hashFileName . cImageTypeToExt( $file['type'] );
				$thumbnail			= 'images/students/' . 'thumb_' . $hashFileName . cImageTypeToExt( $file['type'] );



				//$userModel			=$this->getModel( 'user ');

				// Generate full image
				if(!cImageResizePropotional( $file['tmp_name'] , $storageImage , $file['type'] , $imageMaxWidth ) )
				{
					$mainframe->enqueueMessage(JText::sprintf('MM ERROR MOVING UPLOADED FILE' , $storageImage), 'error');
				}
				// Generate thumbnail
				if(!cImageCreateThumb( $file['tmp_name'] , $storageThumbnail , $file['type'] ))
				{
					$mainframe->enqueueMessage(JText::sprintf('MM ERROR MOVING UPLOADED FILE' , $storageThumbnail), 'error');
				}
			}
		}

		//The place for storing the database

		$curYear = date('Y');
		$curYear = 2013;
		$birth_day = formatdata($fields['birth_day']);
		$gender = $fields['gender'][0];
		$full_name = $fields['name'];
		$parent_name = $fields['parent_name'];
		$birth_day = $birth_day;
		$address = $fields['address'];
		$phone = $fields['phone'];
		$province = $fields['province'];
		$email = $fields['email'];
		$about_me = $fields['about_me'];

		$query_new = "INSERT INTO #__students (userid, year, full_name, parent_name, birth_day, gender, address, phone, province, email, about_me, avatar, thumb, published ) VALUES ("
	            	.$db->Quote($userid)
	            	. ', '.$db->Quote($curYear)
	            	. ', '.$db->Quote($full_name)
	               	. ', '.$db->Quote($parent_name)
	            	. ', '.$db->Quote($birth_day)
	            	. ', '.$db->Quote($gender)
	            	. ', '.$db->Quote($address)
	            	. ', '.$db->Quote($phone)
	            	. ', '.$db->Quote($province)
	            	. ', '.$db->Quote($email)
	            	. ', '.$db->Quote($about_me)
	            	. ', '.$db->Quote($image)
	            	. ', '.$db->Quote($thumbnail)
	            	. ', 1 )'
	            	;
	        //echo $query_new;exit;
            $db->setQuery($query_new);
            $db->query();
    }
    function saveEditStudent($userid, $fields){

		$db = JFactory::getDBO();

		//var_dump($fields);exit;

		//control the avatar file
		$mainframe =& JFactory::getApplication();
		jimport('joomla.filesystem.file');
		jimport('joomla.utilities.utility');
		//$post		= JRequest::get('post');

		CFactory::load( 'helpers' , 'image' );

		// Load avatar library
		CFactory::load( 'libraries' , 'avatar' );

		$file		= JRequest::getVar( 'Filedata' , '' , 'FILES' , 'array' );


		if( !isset( $file['tmp_name'] ) || empty( $file['tmp_name'] ) )
		{
			$mainframe->enqueueMessage(JText::_('MM NO POST DATA'), 'error');
		}
		else
		{
			if( !cValidImage($file['tmp_name'] ) )
			{
				$mainframe->enqueueMessage(JText::_('MM IMAGE FILE NOT SUPPORTED'), 'error');
			}
			else
			{
				//echo "else valide image";exit;
				$imageSize		= cImageGetSize( $file['tmp_name'] );


				// @todo: configurable width?
				$imageMaxWidth	= 200;

				/*if( $imageSize->width > $imageMaxWidth )
				{
					$mainframe->enqueueMessage( JText::sprintf('MM IMAGE WIDTH LARGER' , $imageSize->width , $imageMaxWidth ) );
				}*/

				// Get a hash for the file name.
				$fileName		= JUtility::getHash( $file['tmp_name'] . time() );
				//echo $fileName;exit;
				$hashFileName	= JString::substr( $fileName , 0 , 24 );

				//@todo: configurable path for avatar storage?
				$storage			= JPATH_ROOT . DS . 'images' . DS . 'students';
				$storageImage		= $storage . DS . $hashFileName . cImageTypeToExt( $file['type'] );
				$storageThumbnail	= $storage . DS . 'thumb_' . $hashFileName . cImageTypeToExt( $file['type'] );
				$image				= 'images/students/' . $hashFileName . cImageTypeToExt( $file['type'] );
				$thumbnail			= 'images/students/' . 'thumb_' . $hashFileName . cImageTypeToExt( $file['type'] );



				//$userModel			=$this->getModel( 'user ');

				// Generate full image
				if(!cImageResizePropotional( $file['tmp_name'] , $storageImage , $file['type'] , $imageMaxWidth ) )
				{
					$mainframe->enqueueMessage(JText::sprintf('MM ERROR MOVING UPLOADED FILE' , $storageImage), 'error');
				}
				// Generate thumbnail
				if(!cImageCreateThumb( $file['tmp_name'] , $storageThumbnail , $file['type'] ))
				{
					$mainframe->enqueueMessage(JText::sprintf('MM ERROR MOVING UPLOADED FILE' , $storageThumbnail), 'error');
				}
			}
		}

		//The place for storing the database

		$curYear = date('Y');
		$curYear = 2013;
		$birth_day = formatdata($fields['birth_day']);
		$gender = $fields['gender'][0];
		$full_name = $fields['name'];
		$parent_name = $fields['parent_name'];
		$birth_day = $birth_day;
		$address = $fields['address'];
		$phone = $fields['phone'];
		$province = $fields['province'];
		$email = $fields['email'];
		$about_me = $fields['about_me'];
		 $query = "UPDATE #__students SET"
	            	. '`year`='.$db->Quote($curYear)
	            	. ', `full_name`='.$db->Quote($full_name)
	            	. ', `parent_name`='.$db->Quote($parent_name)
	            	. ', `birth_day`='.$db->Quote($birth_day)
	            	. ', `gender`='.$db->Quote($gender)
	            	. ', `address`='.$db->Quote($address)
	            	. ', `phone`='.$db->Quote($phone)
	            	. ', `province`='.$db->Quote($province)
	            	. ', `email`='.$db->Quote($email)
	            	. ', `about_me`='.$db->Quote($about_me)
	            	. ', `avatar`='.$db->Quote($image)
	            	. ', `thumb`='.$db->Quote($thumbnail)
	            	. ', `published`=1'
	            	. ' WHERE `userid` ='.$db->Quote($userid)
	            	;

	       // echo $query;exit;
            $db->setQuery($query);
            $db->query();
    }
    function isUserNameExists($filter = array()){
		$db			= &$this->getDBO();
		$found		= false;

// 		$query = "(SELECT `username`";
// 		$query .= " FROM #__users";
// 		$query .= " WHERE UCASE(`username`) = UCASE(".$db->Quote($filter['username'])."))";
// 		$query .= " UNION ";
// 		$query .= "(SELECT `username`";
// 		$query .= " FROM #__community_register";
// 		$query .= " WHERE UCASE(`username`) = UCASE(".$db->Quote($filter['username'])."))";

		/*
		 * DO NOT USE UNION. It will failed if the user joomla table's collation type was
		 * diferent from jomsocial tables's collation type
		 */

		$query = "SELECT `username`";
		$query .= " FROM #__users";
		$query .= " WHERE UCASE(`username`) = UCASE(".$db->Quote($filter['username']).")";

		$db->setQuery( $query );
		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}
		$result = $db->loadObjectList();
		$found = (count($result) == 0) ? false : true;

		return $found;

  }
  function isEmailExists($filter = array()){
		$db			= &$this->getDBO();
		$found		= false;

// 		$query = "(SELECT `email`";
// 		$query .= " FROM #__users";
// 		$query .= " WHERE UCASE(`email`) = UCASE(".$db->Quote($filter['email'])."))";
// 		$query .= " UNION";
// 		$query .= "(SELECT `email`";
// 		$query .= " FROM #__community_register";
// 		$query .= " WHERE UCASE(`email`) = UCASE(".$db->Quote($filter['email'])."))";

		$query = "SELECT `email`";
		$query .= " FROM #__users";
		$query .= " WHERE UCASE(`email`) = UCASE(".$db->Quote($filter['email']).")";

		$db->setQuery( $query );
		//echo $db->getQuery($query);
		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}
		$result = $db->loadObjectList();
		$found = (count($result) == 0) ? false : true;

		return $found;

	}
	function addAuthKey ($authKey='')
	{
	    $db    =& $this->getDBO();

		//get current session id.
		$mySess 	=& JFactory::getSession();
		$token		= $mySess->get('MM_REG_TOKEN','');

		$nowDate = JFactory::getDate();
		$nowDate = $nowDate->toMysql();

		$obj = new stdClass();
		$obj->token			= $token;
		$obj->auth_key		= $authKey;
		$obj->created		= $nowDate;
		$obj->ip			= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

		$db->insertObject('#__candidates_register_auth_token', $obj);

		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}

		return true;
	}

}