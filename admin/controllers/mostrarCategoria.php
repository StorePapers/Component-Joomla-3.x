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

class StorepapersControllerMostrarCategoria extends StorepapersControllerDefault{	
	
	public function add($cachable = false){
			
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// redirect
		$option = JRequest::getCmd('option');		
		$url = 'index.php?option='.$option.'&view=insertarNuevaCategoria';
		$this->setRedirect($url);
		$this->redirect();			
	}
	
	public function edit($cachable = false){
			
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// Inicializo variables		
		$ids	= JRequest::getVar('cid', array(), '', 'array');		
		$option = JRequest::getCmd('option');
	
		// Compruebo accesos
		foreach ($ids as $i){
			$url = 'index.php?option='.$option.'&view=editarCategoria&idc='.$i;
		}
		
		// redirect
		$this->setRedirect($url);
		$this->redirect();			
	}
	
	public function remove($cachable = false){
			
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// Inicializo variables		
		$ids	= JRequest::getVar('cid', array(), '', 'array');		
		$option = JRequest::getCmd('option');
	
		// Compruebo accesos
		foreach ($ids as $i){
			$url = 'index.php?option='.$option.'&view=borrarCategoria&idc='.$i;
		}
		
		// redirect
		$this->setRedirect($url);
		$this->redirect();			
	}
	
	public function publish($cachable = false){
			
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
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
		foreach ($ids as $idc){
			
			$row = $modelo->getCategoria($idc);
			$res = $modelo->setEstadoPublicacionPorCategoria($idc, 1);				
			if($res == 1)				
				$this->setMessage(JText::sprintf('EXITO_PUBLICAR_CATEGORIA', $row[0]->nombre));				
			else
				$this->setMessage(JText::sprintf('ERROR_PUBLICAR_CATEGORIA', $row[0]->nombre));
		}
				
		// redirect
		$url = 'index.php?option='.$option.'&view=mostrarCategoria';
		$this->setRedirect($url);
		$this->redirect();			
	}
	
	public function unpublish($cachable = false){
			
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
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
		foreach ($ids as $idc){
			
			$row = $modelo->getCategoria($idc);
			$res = $modelo->setEstadoPublicacionPorCategoria($idc, 0);
			if($res == 1)				
				$this->setMessage(JText::sprintf('EXITO_DESPUBLICAR_CATEGORIA', $row[0]->nombre));				
			else
				$this->setMessage(JText::sprintf('ERROR_DESPUBLICAR_CATEGORIA', $row[0]->nombre));
		}
				
		// redirect
		$url = 'index.php?option='.$option.'&view=mostrarCategoria';
		$this->setRedirect($url);
		$this->redirect();			
	}
	
	public function estadisticas($cachable = false){
			
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// Inicializo variables		
		$ids	= JRequest::getVar('cid', array(), '', 'array');		
		$option = JRequest::getCmd('option');
	
		// Compruebo accesos
		foreach ($ids as $i){
			$url = 'index.php?option='.$option.'&view=mostrarEstadisticasCategoria&idc='.$i;
		}
		
		// redirect		
		$this->setRedirect($url);
		$this->redirect();			
	}
}
?>
