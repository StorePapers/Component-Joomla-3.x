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
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');

//The DS constant has been removed. If you really need it you can use DIRECTORY_SEPARATOR instead.
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// Access check
if(version_compare(JVERSION, '3.0.0', 'ge')) {	
	$user = JFactory::getUser();
	if (!$user->authorise('core.manage', 'com_storepapers') && !$user->authorise('core.admin', 'com_storepapers')) {
		return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	}
}

// Get the view and controller from the request, or set to default if they weren't set
JRequest::setVar('c', JRequest::getCmd('view','storepapers')); // Black magic: Get controller based on the selected view

// Load the appropriate controller
$c = JRequest::getCmd('c','storepapers');
$path = JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.$c.'.php';
//$alt_path = JPATH_COMPONENT_ADMINISTRATOR.DS.'plugins'.DS.'controllers'.DS.$c.'.php';
if(JFile::exists($path))
{
	// The requested controller exists and there you load it...
	require_once($path);
}
/*elseif(JFile::exists($alt_path))
{
	require_once($alt_path);
}*/
else
{
	$c = 'Default';
	$path = JPATH_COMPONENT_ADMINISTRATOR.'/controllers/default.php';
	if(!JFile::exists($path)) {
		JError::raiseError('500',JText::_('Unknown controller').' '.$c);
	}
	require_once $path;
}

// Instanciate and execute the controller
jimport('joomla.utilities.string');
$c = 'StorepapersController'.ucfirst($c);
$controller = new $c();
$controller->execute(JRequest::getCmd('task','display'));

// Redirect if set by the controller
$controller->redirect();
?> 
