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
class EducationViewCategory extends JView
{
	protected $state;
	protected $items;
	protected $category;
	protected $children;
	protected $pagination;

	function display($tpl = null)
	{
		$app		= JFactory::getApplication();
		$params		= $app->getParams();
		$layout = JRequest::getVar('layout', null);
		$model 	   = $this->getModel();
		if ($layout == 'teacher') {
			$teachers = $model->getTeachers();
			$teapagination = $model->getTeaPagination();
			$this->assignRef('teachers', $teachers);
			$this->assignRef('teapagination', $teapagination);
		}elseif ($layout == 'class'){
			$classes = $model->getClasses();
			$clapagination = $model->getClaPagination();
			$this->assignRef('classes', $classes);
			$this->assignRef('clapagination', $clapagination);
		}else{
			$students = $model->getStudents();
			$stupagination = $model->getStuPagination();
			//echo $stupagination->getListFooter();
			$this->assignRef('students', $students);
			$this->assignRef('stupagination', $stupagination);
		}
		parent::display($tpl);
		//echo "i am here"; exit;
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app = JFactory::getApplication();
		$menu = $app->getMenu()->getActive();
		$pathway = $app->getPathway();
		$title = null;

		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else {
			$this->params->def('page_heading', JText::_('COM_JOOMPROSUBS_DEFAULT_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0)) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->category->metadesc) {
			$this->document->setDescription($this->category->metadesc);
		}
		elseif (!$this->category->metadesc && $this->params->get('menu-meta_description')) {
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->category->metakey) {
			$this->document->setMetadata('keywords', $this->category->metakey);
		}
		elseif (!$this->category->metakey && $this->params->get('menu-meta_keywords')) {
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots')) {
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}

		if ($app->getCfg('MetaTitle') == '1') {
			$this->document->setMetaData('title', $this->category->getMetadata()->get('page_title'));
		}

		if ($app->getCfg('MetaAuthor') == '1') {
			$this->document->setMetaData('author', $this->category->getMetadata()->get('author'));
		}

		$mdata = $this->category->getMetadata()->toArray();

		foreach ($mdata as $k => $v)
		{
			if ($v) {
				$this->document->setMetadata($k, $v);
			}
		}
	}
} // end of class
