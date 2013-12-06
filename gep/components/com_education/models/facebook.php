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
class EducationModelFacebook extends JModelForm
{
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
	 * Method to save the form data.
	 *
	 * @param	array		The form data.
	 * @return	mixed		The user id on success, false on failure.
	 * @since	1.6
	 */
	public function register($data)
	{
		$config = JFactory::getConfig();
		$app	= JFactory::getApplication();
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
		$this->saveFUser($user->id, $data);

		// Populate the data array:
		$data['return'] = base64_decode(JRequest::getVar('return', '', 'POST', 'BASE64'));


		// Set the return URL if empty.
		if (empty($data['return'])) {
			$data['return'] = 'index.php?option=com_users&view=profile';
		}

		// Set the return URL in the user state to allow modification by plugins
		$app->setUserState('users.login.form.return', $data['return']);

		// Get the log in options.
		$options = array();
		$options['remember'] = JRequest::getBool('remember', false);
		$options['return'] = $data['return'];

		// Get the log in credentials.
		$credentials = array();
		$credentials['username'] = $data['username'];
		$credentials['password'] = $data['password1'];

		//var_dump($credentials);exit;

		// Perform the log in.
		if (true === $app->login($credentials, $options)) {
			// Success
			$app->setUserState('users.login.form.data', array());
			$app->redirect(JRoute::_($app->getUserState('users.login.form.return'), false));
		} else {
			// Login failed !
			$data['remember'] = (int)$options['remember'];
			$app->setUserState('users.login.form.data', $data);
			$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
		}
	}

	function saveFUser($userid, $fields){

		$db = JFactory::getDBO();

		$fid = $fields['fid'];
		$username = $fields['username'];
		$password = $fields['password1'];
		$birth_day = $fields['birth_day'];
		$gender = $fields['gender'][0];
		$full_name = $fields['name'];
		$birth_day = $birth_day;
		$address = $fields['address'];
		$email = $fields['email'];
		$avatar = $fields['Filedata'];

		$query_new = "INSERT INTO #__fusers (fid, userid, username, password, full_name, birth_day, gender, address, email, avatar ) VALUES ("
	            	.$db->Quote($fid)
	            	. ', '.$db->Quote($userid)
	            	. ', '.$db->Quote($username)
	               	. ', '.$db->Quote($password)
	               	. ', '.$db->Quote($full_name)
	            	. ', '.$db->Quote($birth_day)
	            	. ', '.$db->Quote($gender)
	            	. ', '.$db->Quote($address)
	            	. ', '.$db->Quote($email)
	               	. ', '.$db->Quote($avatar)
	            	. ' )'
	            	;
	        //echo $query_new;exit;
            $db->setQuery($query_new);
            $db->query();
    }
}