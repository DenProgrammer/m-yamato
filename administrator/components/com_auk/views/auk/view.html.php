<?php
/**
 * @version		$Id: view.html.php 20801 2011-02-21 19:22:18Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit an article.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class AukViewAuk extends JView
	{
		public function display($tpl = null)
		{
			$params = JComponentHelper::getParams( 'com_auk' );
			$userid = $params->get('userid'); 
			$passwd = $params->get('passwd'); 
			
			$this->assignRef('userid',$userid);
			$this->assignRef('passwd',$passwd);
		
			parent::display($tpl);
		}
	}