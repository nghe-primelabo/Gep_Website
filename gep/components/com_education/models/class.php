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
class EducationModelClass extends JModelForm
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
	public function register($fields)
	{
		$db = JFactory::getDBO();
		$class_name = $fields['class_name'];
		$class_des = $fields['class_des'];
		$userid = $fields['userid'];
		$query_new = "INSERT INTO #__classes (teacherid, class_name, class_des, published ) VALUES ("
	            	.$db->Quote($userid)
	            	. ', '.$db->Quote($class_name)
	            	. ', '.$db->Quote($class_des)
	              	. ', 1 )'
	            	;
	        //echo $query_new;exit;
            $db->setQuery($query_new);
            $db->query();
	}
}