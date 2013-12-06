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
class EducationControllerClass extends EducationController
{
	/**
	 * Method to activate a user.
	 *
	 * @return	boolean		True on success, false on failure.
	 * @since	1.6
	 */


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
		$model	= $this->getModel('Class', 'EducationModel');
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

		$this->setRedirect(JRoute::_('index.php?option=com_education&view=condetail&layout=teacher&userid='.$requestData['userid'], false));

		return true;
	}
}
