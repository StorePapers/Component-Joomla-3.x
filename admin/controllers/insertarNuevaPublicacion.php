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

class StorepapersControllerInsertarNuevaPublicacion extends StorepapersControllerDefault{	
	
	/*
	Función que se ejecuta cuando se pulsa el botón de guardar un nuevo categoria.
	Tambien funciona cuando se edita un categoria.
	*/	
	function save($cachable = false){
		
		if(version_compare(JVERSION, '3.0.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}	
		
		//Para variables que son de tipo array usar getVar
		$listaAutores = JRequest::getVar('listaAutores');
		
		//Obtengo y creo un array para la prioridad
		$n = count( $listaAutores );
		for($i=0;$i < $n; $i++)
			$listaPrioridad[$i] = JRequest::getVar('prioridad_id'.$listaAutores[$i]);
			
		$this->filtrarPrioridad($listaPrioridad);	
		//En este caso no quiero utilizar este modelo sino el de editar publicacion
		//porque utilizo la misma operación		
		$modelo =& $this->getModel('EditarPublicacion');
		
		$res = $modelo->guardarEditarPublicacion(JRequest::get('post',JREQUEST_ALLOWHTML));		
		
		$modelo->actualizarEnlacesEntreAutorPublicacion($listaAutores, $listaPrioridad, $modelo->getIDNuevaPublicacion());
		
		if($res == 1)
			$this->setMessage(JText::_('EXITO_GUARDAR_PUBLICACION'));			
        else
			$this->setMessage(JText::_('ERROR_GUARDAR_PUBLICACION'));
			
		// redirect		
		$idc    = JRequest::getCmd('idcpag','0');
		$ida    = JRequest::getCmd('idapag','0');
		$year   = JRequest::getCmd('yearpag','all');
		$option = JRequest::getCmd('option');
		
        $url = "index.php?option=$option&view=mostrarPublicacion&ida=$ida&idc=$idc&year=$year";
		
		$this->setRedirect($url);
		$this->redirect();
	}	
	
	public function cancel($cachable = false){
			
		if(version_compare(JVERSION, '3.0.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}				
		
		// redirect		
		$idc    = JRequest::getCmd('idcpag','0');
		$ida    = JRequest::getCmd('idapag','0');
		$year   = JRequest::getCmd('yearpag','all');
		$option = JRequest::getCmd('option');		
		
		$url = "index.php?option=$option&view=mostrarPublicacion&ida=$ida&idc=$idc&year=$year";				
		
		$this->setRedirect($url);
		$this->redirect();
	}	
}
?>
