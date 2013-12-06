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
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the JoomproSubs component
 *
 */
class EducationViewForm extends JView
{
	protected $state;
	protected $item;
	protected $category;

	function display($tpl = null)
	{

		//echo "i am here form";exit;
		$app = JFactory::getApplication();
		$params = $app->getParams();
		$user = JFactory::getUser();

		$layout = JRequest::getVar('layout', null);
		$task = JRequest::getVar('task', null);
		$userid = JRequest::getInt('userid', 0);

		$model 	   = $this->getModel();



		// Get some data from the models
		//$item = $this->get('Item');
		//$this->form = $this->get('Form');
		//var_dump($this->form);
		//var_dump($this->form);exit;
		/*$authorised = $user->authorise('core.edit', 'com_candidate.category.' . $item->catid);
		if ($authorised !== true) {
			JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			return false;
		}*/

		//$this->form->bind($item);

		//var_dump($this->form);exit;

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}

		//Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

		$this->params = $params;
		$this->user = $user;
		if( ($layout == 'teacher') and ($task == 'edit') ){
			$teacherProfile = $model->getTeacherProfile($userid);
			//var_dump($teacherProfile);
			$this->assignRef('teacherProfile', $teacherProfile);

		}elseif($task == 'edit'){
			$profile = $model->getDetail($userid);
			$this->assignRef('profile', $profile);
		}
		$this->assignRef('task', $task);
		$this->assignRef('userid', $userid);

		$this->_prepareDocument();
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app = JFactory::getApplication();
		$menus = $app->getMenu();
		$pathway = $app->getPathway();
		$title = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		$head = JText::_('COM_JOOMPROSUBS_FORM_SUBMIT_SUB');

		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', $head);
		}

		$title = $this->params->def('page_title', $head);
		if ($app->getCfg('sitename_pagetitles', 0)) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
} // end of class
