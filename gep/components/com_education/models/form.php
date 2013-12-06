<?php
/**
 * @version		01
 * @package		Gep.Site
 * @subpackage	com_education
 * @author Nguyen Xuan Nghe - nxnghe@gmail.com
 * @copyright	Copyright (C) 2013 Prime Labo Technology. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

JLoader::register('EducationModelRegister',
	JPATH_COMPONENT_ADMINISTRATOR.'/models/form.php');

/**
 * Joomprosubs model.
 *
 * @package		Joomla.Site
 * @subpackage	com_joomprosubs
 */
class EducationModelForm extends EducationModelRegister
{

	/**
	 *
	 * Method to add or update the subscription mapping table
	 * If the row already exists, update the start and end date.
	 * If the row doesn't exist, add a new row.
	 *
	 * @param JObject $subscription	Subscription object
	 * @param JUser $user User object
	 * @return	Boolean	true on success, false on failure
	 */
	public function updateSubscriptionMapping($subscription, $user)
	{
		// Check that we have valid inputs
		if (((int) $subscription->id) && ((int) $subscription->duration )
				&& ((int) $user->id)) {

			$today = JFactory::getDate()->toMySQL();
			$endDate = JFactory::getDate('+ ' . (int) $subscription->duration . ' days')->toMySQL();

			// Check whether the row exists
			$mapRow = $this->getMapRow($subscription->id, $user->id);
			if ($mapRow === false) {
				// We have a database error
				return false;
			} else if ($mapRow) {
				// The row already exists, so update it
				if (!$this->updateMapRow($subscription->id, $user->id, $today, $endDate)) {
					return false;
				}
			} else {
				// The row doesn't exist, so add a new map row
				if (!$this->addMapRow($subscription->id, $user->id, $today, $endDate)) {
					return false;
				}
			}

			// At this point, we have successfully updated the database
			return true;
		}
	}
	function getDetail($id) {

         $db     = JFactory::getDBO();
         $query  =  "SELECT s.*, u.username FROM #__students AS s LEFT JOIN #__users as u On s.userid = u.id WHERE s.published= 1 AND s.userid =$id";

        // echo $query;

         $db->setQuery($query);
         $output = $db->loadObject();
         return($output);
	}
	function getTeacherProfile($id) {

         $db     = JFactory::getDBO();
         $query  =  "SELECT t.*, u.username FROM #__teachers AS t LEFT JOIN #__users as u On t.userid = u.id WHERE t.published= 1 AND t.userid =$id";
         $db->setQuery($query);
         $output = $db->loadObject();
         return($output);
	}

	protected function addMapRow ($subID, $userID, $startDate, $endDate)
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->insert($db->nameQuote('#__joompro_sub_mapping'));
		$query->set('subscription_id = ' . (int) $subID);
		$query->set('user_id = ' . (int) $userID);
		$query->set('start_date = ' . $db->quote($startDate));
		$query->set('end_date = ' . $db->quote($endDate));
		$db->setQuery($query);
		if ($db->query()) {
			return true;
		} else {
			$this->setError(JText::_('COM_JOOMPROSUBS_ADD_MAP_ROW_FAIL'));
			return false;
		}
	}

	protected function getMapRow($subID, $userID)
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->select('subscription_id, user_id, start_date, end_date');
		$query->from($db->nameQuote('#__joompro_sub_mapping'));
		$query->where('subscription_id = ' . (int) $subID);
		$query->where('user_id = ' . (int) $userID);
		$db->setQuery($query);
		$data = $db->loadObject();
		if ($db->getErrorNum()) {
			$this->setError(JText::_('COM_JOOMPROSUBS_GET_MAP_ROW_FAIL'));
			return false;
		} else {
			return $data;
		}
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
		$app = JFactory::getApplication();

		// Load state from the request.
		$pk = JRequest::getInt('sub_id');
		$this->setState('joomprosub.sub_id', $pk);
		// Add compatibility variable for default naming conventions.
		$this->setState('form.id', $pk);

		$return = JRequest::getVar('return', null, 'default', 'base64');

		if (!JUri::isInternal(base64_decode($return))) {
			$return = null;
		}

		$this->setState('return_page', base64_decode($return));

		// Load the parameters.
		$params	= $app->getParams();
		$this->setState('params', $params);
		$this->setState('layout', JRequest::getCmd('layout'));
	}

	protected function updateMapRow($subID, $userID, $startDate, $endDate)
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->update($db->nameQuote('#__joompro_sub_mapping'));
		$query->set('start_date = ' . $db->quote($startDate));
		$query->set('end_date = ' . $db->quote($endDate));
		$query->where('subscription_id = ' . (int) $subID);
		$query->where('user_id = ' . (int) $userID);
		$db->setQuery($query);
		if ($db->query()) {
			return true;
		} else {
			$this->setError(JText::_('COM_JOOMPROSUBS_UPDATE_MAP_ROW_FAIL'));
			return false;
		}
	}

}
