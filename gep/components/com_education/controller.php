<?php
/**
 * @version		01
 * @package		Gep.Site
 * @subpackage	com_education
 * @author Nguyen Xuan Nghe - nxnghe@gmail.com
 * @copyright	Copyright (C) 2013 Prime Labo Technology. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Education Component Controller
 *
 */
class EducationController extends JController
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean       If true, the view output will be cached
	 * @param	array         An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController   This object to support chaining.
	 */
	public function display($cachable = false, $urlparams = false)
	{

		include(JPATH_COMPONENT.DS.'assets'.DS.'functions.php');
		//include(JPATH_COMPONENT.DS.'assets'.DS.'ajax_contestants.php');


		$document	=& JFactory::getDocument();
		$document->addStyleSheet( JURI::base() . 'components/com_education/assets/window.css', 'text/css');
		$document->addStyleSheet( JURI::base() . 'components/com_education/assets/style.css', 'text/css');
		$document->addScript( JURI::root() . 'media/system/js/jquery-1.4.2.min.js', 'text/javascript');
		$document->addScript( JURI::root() . 'media/system/js/jquery.nc.js', 'text/javascript');
		$document->addScript(JURI::base().'components/com_education/assets/window-1.0.js');
		$document->addScript(JURI::base().'components/com_education/assets/ajax_1.3_contestants.js');
		$document->addScript(JURI::base().'components/com_education/assets/front.js');
		$document->addScript(JURI::base().'components/com_education/assets/jquery.tools.min.js');
		$document->addScript(JURI::base().'components/com_education/assets/validate-1.5.js');
		$document->addScript(JURI::base().'media/system/js/jquery.poshytip.min.js');

		// Initialise variables.
		$cachable	= true;
		$user		= JFactory::getUser();

		// Set the default view name and format from the Request.
		// Note we are using sub_id to avoid collisions with the router and the return page.
		$id	= JRequest::getInt('sub_id');
		$vName = JRequest::getCmd('view', 'form');
		JRequest::setVar('view', $vName);

		if ($user->get('id')) {
			$cachable = false;
		}

		$safeurlparams = array(
			'id'				=> 'INT',
			'limit'				=> 'INT',
			'limitstart'		=> 'INT',
			'filter_order'		=> 'CMD',
			'filter_order_Dir'	=> 'CMD',
			'lang'				=> 'CMD'
		);

		// Check for edit form.
		if ($vName == 'form' && !$this->checkEditId('com_education.edit.subscription', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			return JError::raiseError(403, JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
		}

		return parent::display($cachable,$safeurlparams);
	}
}
