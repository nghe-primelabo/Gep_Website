<?php
/**
 * @copyright (C) 2010 Multimedia JSC - All rights reserved!
 * @license Copyrighted Commercial Software
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class CWindow
{
	/**
	 * Load messaging javascript header
	 */
	function load()
	{
		static $loaded = false;

		if( !$loaded )
		{
			//$config	=& CFactory::getConfig();

			require_once( JPATH_ROOT . DS . 'components' . DS . 'com_contestants' . DS . 'libraries' . DS . 'core.php' );

			$js = '/assets/window-1.0';
			$js .= '.js';
			CAssets::attach($js, 'js');

			CFactory::load( 'libraries' , 'template' );
			CTemplate::addStyleSheet( 'style' );

			$css = '/assets/window.css';
			CAssets::attach($css, 'css');
		}
	}
}