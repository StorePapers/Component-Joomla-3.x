<?php
/**
 *
 * This file is part of StorePapers
 *
 * Copyright (C) 2008-2015  Francisco Ruiz (contact@storepapers.com)
 *
 * StorePapers is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 *
 * StorePapers is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class StorePapersController extends JControllerLegacy
{	
	public function display($cachable = false, $urlparams = false)
	{
		$paramsC 	= JComponentHelper::getParams('com_storepapers');
		$cache 		= $paramsC->get( 'enable_cache', 0 );
		$cachable 	= false;
		if ($cache == 1) {
			$cachable 	= true;
		}
		
		$document 	= JFactory::getDocument();
		
		JRequest::setVar('view', 'search'); // force it to be the search view

		return parent::display($cachable, $urlparams);
	}
	
	function search()
	{	
		$uri = JURI::getInstance();		
		$post = JRequest::get( 'post' );

		// set Itemid id for links from menu
		$app	= JFactory::getApplication();
		$menu	= $app->getMenu();
		$items	= $menu->getItems('link', 'index.php?option=com_storepapers&view=search');

		if(isset($items[0])) {
			$post['Itemid'] = $items[0]->id;
		} elseif (JRequest::getInt('Itemid') > 0) { //use Itemid from requesting page only if there is no existing menu
			$post['Itemid'] = JRequest::getInt('Itemid');
		}
		$uri->setVar('view', 'search');
		$uri->setVar('Itemid', $post['Itemid']);
		
		$post['limit']  = JRequest::getUInt('limit', null, 'post');
		if ($post['limit'] === null) 
			unset($post['limit']);
		else
			$uri->setVar('limit', $post['limit']);
		
		$uri->setVar('ida', $post['ida']);
		$uri->setVar('idc', $post['idc']);
		$uri->setVar('year', $post['year']);

		$this->setRedirect(JRoute::_('index.php'.$uri->toString(array('query', 'fragment')), false));	
	}
}
