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

jimport('joomla.application.component.modellist');
jimport('joomla.application.categories');

/**
 * Joomprosubs Component Joomprosub Model
 *
 * @package		Joomla.Site
 * @subpackage	com_joomprosubs
 */
class EducationModelCategory extends JModelList
{
	/**
	 * Category items data
	 *
	 * @var array
	 */

	var $_stupagination = null;
	var $_stutotal = null;

	var $_teapagination = null;
	var $_teatotal = null;

	var $_clapagination = null;
	var $_clatotal = null;



	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'g.title', 'group_title',
				'duration', 'a.duration'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 * @since	1.6
	 */
	protected function getListQuery()
	{

	}
	function getStudents() {
		$app	= JFactory::getApplication();
		$db     = JFactory::getDBO();

		$context			= 'com_education.list.';
		$searchValue				= $app->getUserStateFromRequest( $context.'search',			'search',			'',			'string' );

		$where = array();
		if ($searchValue) {
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $searchValue, true ).'%', false );
			$where[] = '( a.full_name LIKE '.$searchEscaped.' OR a.email LIKE '.$searchEscaped.' OR u.username LIKE '.$searchEscaped.')';			}

		$where[] = 'a.published=1 ';
		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$limit = $app->getUserStateFromRequest('education.limit', 'limit', $app->getCfg('list_limit'), 'int');
		$limitstart	= $app->getUserStateFromRequest('education.limitstart', 'limitstart', 0, 'int');

		$totalSql = "SELECT COUNT(*) FROM #__students AS a ".$where;

		//echo $totalSql;

		$db->setQuery($totalSql);
		$this->_stutotal = $db->loadResult();


         $query  =  "SELECT a.* FROM #__students AS a LEFT JOIN #__users AS u ON a.userid = u.id ".$where;
		//echo $query;
         $db->setQuery( $query, $limitstart, $limit );
         $rows = $db->loadObjectList();
         $output['rows'] = $rows;
         $output['search'] = $searchValue;
        // var_dump($output);
         return($output);
	}
	function &getStuPagination()
	{
		$app	= JFactory::getApplication();
		// Lets load the content if it doesn't already exist
		if (empty($this->_stupagination))
		{
			jimport('joomla.html.pagination');
			$limit = $app->getUserStateFromRequest('education.limit', 'limit', $app->getCfg('list_limit'), 'int');
			$limitstart	= $app->getUserStateFromRequest('education.limitstart', 'limitstart', 0, 'int');

			$this->_stupagination = new JPagination( $this->_stutotal, $limitstart, $limit);
		}
		return $this->_stupagination;
	}
	function getTeachers() {
		$app	= JFactory::getApplication();
		$db     = JFactory::getDBO();

		$context			= 'com_education.list.teacher';
		$searchValue				= $app->getUserStateFromRequest( $context.'search',			'search',			'',			'string' );

		$where = array();
		if ($searchValue) {
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $searchValue, true ).'%', false );
			$where[] = '( t.full_name LIKE '.$searchEscaped.' OR t.email LIKE '.$searchEscaped.' OR u.username LIKE '.$searchEscaped.')';			}

		$where[] = 't.published=1';
		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$limit = $app->getUserStateFromRequest('education.limit', 'limit', $app->getCfg('list_limit'), 'int');
		$limitstart	= $app->getUserStateFromRequest('education.limitstart', 'limitstart', 0, 'int');

		$totalSql = "SELECT COUNT(*) FROM #__teachers AS t ".$where;

		//echo $totalSql;

		$db->setQuery($totalSql);
		$this->_teatotal = $db->loadResult();


         $query  =  "SELECT t.* FROM #__teachers AS t LEFT JOIN #__users AS u ON t.userid = u.id ".$where;
		//echo $query;
         $db->setQuery( $query, $limitstart, $limit );
         $rows = $db->loadObjectList();
         $output['rows'] = $rows;
         $output['search'] = $searchValue;
        // var_dump($output);
         return($output);
	}
	function &getTeaPagination()
	{
		$app	= JFactory::getApplication();
		// Lets load the content if it doesn't already exist
		if (empty($this->_teapagination))
		{
			jimport('joomla.html.pagination');
			$limit = $app->getUserStateFromRequest('education.limit', 'limit', $app->getCfg('list_limit'), 'int');
			$limitstart	= $app->getUserStateFromRequest('education.limitstart', 'limitstart', 0, 'int');

			$this->_teapagination = new JPagination( $this->_teatotal, $limitstart, $limit);
		}
		return $this->_teapagination;
	}
	function getClasses() {
		$app	= JFactory::getApplication();
		$db     = JFactory::getDBO();

		$context			= 'com_education.list.class';
		$searchValue				= $app->getUserStateFromRequest( $context.'search',			'search',			'',			'string' );

		$where = array();
		if ($searchValue) {
			$searchEscaped = $db->Quote( '%'.$db->getEscaped( $searchValue, true ).'%', false );
			$where[] = '( c.class_name LIKE '.$searchEscaped.' OR c.class_des LIKE '.$searchEscaped.')';			}

		$where[] = 'c.published=1';
		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		$limit = $app->getUserStateFromRequest('education.limit', 'limit', $app->getCfg('list_limit'), 'int');
		$limitstart	= $app->getUserStateFromRequest('education.limitstart', 'limitstart', 0, 'int');

		$totalSql = "SELECT COUNT(c.*) FROM #__classes AS c ".$where;

		//echo $totalSql;

		$db->setQuery($totalSql);
		$this->_clatotal = $db->loadResult();


         $query  =  "SELECT c.* FROM #__classes AS c ".$where;
		//echo $query;
         $db->setQuery( $query, $limitstart, $limit );
         $rows = $db->loadObjectList();
         $output['rows'] = $rows;
         $output['search'] = $searchValue;
        // var_dump($output);
         return($output);
	}
	function &getClaPagination()
	{
		$app	= JFactory::getApplication();
		// Lets load the content if it doesn't already exist
		if (empty($this->_clapagination))
		{
			jimport('joomla.html.pagination');
			$limit = $app->getUserStateFromRequest('education.limit', 'limit', $app->getCfg('list_limit'), 'int');
			$limitstart	= $app->getUserStateFromRequest('education.limitstart', 'limitstart', 0, 'int');

			$this->_clapagination = new JPagination( $this->_clatotal, $limitstart, $limit);
		}
		return $this->_clapagination;
	}
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();
		$params	= JComponentHelper::getParams('com_joomprosubs');

		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = JRequest::getInt('limitstart', 0, '');
		$this->setState('list.start', $limitstart);

		$orderCol	= JRequest::getCmd('filter_order', 'title');
		if (!in_array($orderCol, $this->filter_fields)) {
			$orderCol = 'ordering';
		}
		$this->setState('list.ordering', $orderCol);

		$listOrder	=  JRequest::getCmd('filter_order_Dir', 'ASC');
		if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', ''))) {
			$listOrder = 'ASC';
		}
		$this->setState('list.direction', $listOrder);

		$this->setState('list.filter', JRequest::getString('filter-search'));

		$id = JRequest::getInt('id', 0);
		$this->setState('category.id', $id);

		$user = JFactory::getUser();
		if ((!$user->authorise('core.edit.state', 'com_joomprosubs')) &&  (!$user->authorise('core.edit', 'com_joomprosubs'))){
			// limit to published for people who can't edit or edit.state.
			$this->setState('filter.state',	1);

			// Filter by start and end dates.
			$this->setState('filter.publish_date', true);
		}
	}

	/**
	 * Method to get category data for the current category
	 *
	 * @param	int		An optional ID
	 *
	 * @return	object
	 */
	public function getCategory()
	{

	}
} // end of class