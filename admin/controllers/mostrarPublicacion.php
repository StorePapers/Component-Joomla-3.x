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
 
// No direct access
defined( '_JEXEC' ) or die;

require_once JPATH_COMPONENT_ADMINISTRATOR.'/controllers/default.php';

class StorepapersControllerMostrarPublicacion extends StorepapersControllerDefault{	
	
	public function add($cachable = false){
			
		if(version_compare(JVERSION, '3.0.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// redirect
		$idc  = JRequest::getCmd('idc','0');
		$ida  = JRequest::getCmd('ida','0');
		$year = JRequest::getCmd('year','all');
		
		$option = JRequest::getCmd('option');		
		$url = "index.php?option=$option&view=insertarNuevaPublicacion&ida=$ida&idc=$idc&year=$year";
		$this->setRedirect($url);
		$this->redirect();			
	}
	
	public function edit($cachable = false){
			
		if(version_compare(JVERSION, '3.0.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// Inicializo variables	
		$ids	= JRequest::getVar('cid', array(), '', 'array');
		$option = JRequest::getCmd('option');
	
		// Compruebo accesos
		$idc  = JRequest::getCmd('idc','0');
		$ida  = JRequest::getCmd('ida','0');
		$year = JRequest::getCmd('year','all');
		foreach ($ids as $i){
			$url = "index.php?option=$option&view=editarPublicacion&idp=$i&ida=$ida&idc=$idc&year=$year";
		}
		
		// redirect
		$this->setRedirect($url);
		$this->redirect();			
	}
	
	public function remove($cachable = false){
			
		if(version_compare(JVERSION, '3.0.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// Inicializo variables		
		$ids	= JRequest::getVar('cid', array(), '', 'array');		
		$option = JRequest::getCmd('option');
	
		// Compruebo accesos
		$idc  = JRequest::getCmd('idc','0');
		$ida  = JRequest::getCmd('ida','0');
		$year = JRequest::getCmd('year','all');		
		foreach ($ids as $i){
			$url = "index.php?option=$option&view=borrarPublicacion&idp=$i&ida=$ida&idc=$idc&year=$year";
		}
		
		// redirect
		$this->setRedirect($url);
		$this->redirect();			
	}
	
	public function publish($cachable = false){
			
		if(version_compare(JVERSION, '3.0.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// Inicializo variables		
		$ids	= JRequest::getVar('cid', array(), '', 'array');		
		$option = JRequest::getCmd('option');
		
		$modelo =& $this->getThisModel();		
	
		// Compruebo accesos
		foreach ($ids as $idp){			
			$res = $modelo->setEstadoPublicacionPorID($idp, 1);				
		}
				
		// redirect
		$idc  = JRequest::getCmd('idc','0');
		$ida  = JRequest::getCmd('ida','0');
		$year = JRequest::getCmd('year','all');
		
		$url = "index.php?option=$option&view=mostrarPublicacion&ida=$ida&idc=$idc&year=$year";
		$this->setRedirect($url);
		$this->redirect();			
	}
	
	public function unpublish($cachable = false){
			
		if(version_compare(JVERSION, '3.0.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// Inicializo variables		
		$ids	= JRequest::getVar('cid', array(), '', 'array');		
		$option = JRequest::getCmd('option');
		
		$modelo =& $this->getThisModel();		
	
		// Compruebo accesos
		foreach ($ids as $idp){			
			$res = $modelo->setEstadoPublicacionPorID($idp, 0);				
		}
				
		// redirect		
		$idc  = JRequest::getCmd('idc','0');
		$ida  = JRequest::getCmd('ida','0');
		$year = JRequest::getCmd('year','all');
		
		$url = "index.php?option=$option&view=mostrarPublicacion&ida=$ida&idc=$idc&year=$year";
		$this->setRedirect($url);
		$this->redirect();			
	}	
}
?>
