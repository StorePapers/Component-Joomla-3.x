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
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import VIEW object class
jimport( 'joomla.application.component.view' );

class StorepapersViewEditarPublicacion extends JViewLegacy{	
	
	function display($tpl = null){		
	
		/*Esto es para el ACL*/		
		//$mainframe	= JFactory::getApplication();
		//$db			= JFactory::getDBO();
		//$uri 		= JFactory::getURI();
		//$user 		= JFactory::getUser();
		$model		= $this->getModel();
		//$editor 	= JFactory::getEditor();
		$paramsC 	= JComponentHelper::getParams('com_storepapers');
	
		//Extraigo los parametros
		if(empty($_GET)){
			//Si se usa la paginaci�n no se encuentran par�metros en la URL
			$idc  = JRequest::getCmd('idc','0');
			$ida  = JRequest::getCmd('ida','0');
			$year = JRequest::getCmd('year','all');			
		}
		else{
			$idp  = $_GET['idp'];
			$idc  = $_GET['idc'];
			$ida  = $_GET['ida'];
			$year = $_GET['year'];
		}
		
		// A�ade el titulo en la barra de herramientas
		JToolBarHelper::title(JText::_('COM_STOREPAPERS'),'storepapers');
		JHtml::stylesheet('com_storepapers/backend.css', array(), true, false, false);
	
		$data['idp'] = $idp;		
		$data['ida'] = $ida;
		$data['idc'] = $idc;
		$data['year'] = $year;
		
		//Leo la publicacion en concreto a modificar
		$data['publicacion'] = $model->getPublicacion($idp);		
		$data['autoresPublicacion'] = $model->getAutoresSegunPublicacion($idp);
		
		//Leo todos las categorias y los autores de la BD
		$data['categorias'] = $model->getCategorias();
		$data['autores'] = $model->getAutores();
		
		//Leo la configuraci�n de la BD
		$data['config'] = $model->getPreferencias();
		
		$this->assignRef( 'data', $data );
		
		//A�ado la barra de herramientas
		$this->addToolbar();
		
		parent::display($tpl);		
	}
	
	protected function addToolbar() {
	
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'storepapers.php';
		
		$canDo	= StorePapersHelper::getActions();
		
		// A�ade el titulo en la barra de herramientas
		JToolBarHelper::title(JText::_('COM_STOREPAPERS').': '.JText::_('EDITAR_PUBLICACION'),'storepapers');
		JHtml::stylesheet('com_storepapers/backend.css', array(), true, false, false);		
		
		// A�ade submenus 
		// -- mostrar autor
		$link = JURI::base().'index.php?option='.JRequest::getCmd('option').'&view=mostrarAutor';
		JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_GESTOR_AUTORES'), $link);
		// -- mostrar categorias
		$link = JURI::base().'index.php?option='.JRequest::getCmd('option').'&view=mostrarCategoria';
		JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_GESTOR_CATEGORIAS'), $link);
		// -- mostrar publicaciones
		$link = JURI::base().'index.php?option='.JRequest::getCmd('option').'&view=mostrarPublicacion&ida=0&idc=0&year=all';
		JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_GESTOR_PUBLICACIONES'), $link);
		// -- preferencias
		$link = JURI::base().'index.php?option='.JRequest::getCmd('option').'&view=preferencias';
		JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_PREFERENCIAS'), $link);

		// A�ade botones en la barra de herramientas			
		if ($canDo->get('core.edit'))
			JToolBarHelper::save();

		JToolBarHelper::cancel();
	}
}
?>
