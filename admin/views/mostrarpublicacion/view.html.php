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

class StorepapersViewMostrarPublicacion extends JViewLegacy{
	
	function display($tpl = null){
	
		/*Esto es para el ACL*/		
		//$mainframe	= JFactory::getApplication();
		//$db			= JFactory::getDBO();
		//$uri 		= JFactory::getURI();
		//$user 		= JFactory::getUser();
		$model		= $this->getModel();
		//$editor 	= JFactory::getEditor();
		$paramsC 	= JComponentHelper::getParams('com_storepapers');
				
		//Comparo la version del código con la versión de la base de datos. Si no coincide hay que actualizar.
		$data['versionCodigo'] = $model->getVersionStorePapersCodigoPHP();
		$data['versionSQL'] = 0;
		$data['versionSQL'] = $model->getVersionStorePapers();
		
		if($data['versionSQL'] != $data['versionCodigo'])
			$data['update'] = 1;
		else{
			$data['update'] = 0;
		
			//Extraigo los parametros
			if(empty($_GET)){
				//Si se usa la paginación no se encuentran parámetros en la URL
				$idc  = JRequest::getCmd('idc','0');
				$ida  = JRequest::getCmd('ida','0');
				$year = JRequest::getCmd('year','all');			
			}
			else{
				$idc  = $_GET['idc'];
				$ida  = $_GET['ida'];
				$year = $_GET['year'];
			}
			
			// Para mostrar la paginación
			$pagination = $model->getPagination();
			$this->assignRef( 'pagination',	$pagination);
			
			//Leo todas las categorias disponibles de la BD
			$data['categorias']    = $model->getCategorias();
			$data['publicaciones'] = $model->getPublicacionesFiltradas($idc, $ida, $year);
			
			//Cuento el número de categorías, si es cero no se puede agregar publicación nueva			
			if(count($data['categorias']) == '0')
				JError::raiseNotice(500, JText::_('COM_STOREPAPERS_RAISE_NOTICE_DEBE_EXISTIR_CATEGORIA'));
			
			//Recojo la información de todos los autores y poder realizar un filtro a las publicaciones
			$data['nombreautores'] = $model->getAutores();
			//Recojo la información de todos los años y poder realizar un filtro a las publicaciones
			$data['year'] = $model->getYearDistinct();
			
			$n = count( $data['publicaciones'] );		
			for ($i = 0; $i < $n; $i++){
				//Almaceno en row la fila completa para averiguar el id y pasarselo por parametro a la función "getAutoresDePublicacion"
				$row =& $data['publicaciones'][$i];
				$data['autores'][$i] = $model->getAutoresDePublicacion($row->id);		
			}		
			
			//Paso el parametro del identificador del filtro
			$data['filtroidcategoria'] = $idc;
			$data['filtroidautor']     = $ida;		
			$data['filtroyear']        = $year;
		}
		
		$this->assignRef( 'mensaje', $data );
		
		//Añado la barra de herramientas
		$this->addToolbar();
		
		parent::display($tpl);
	}
	
	protected function addToolbar() {
	
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'storepapers.php';
		
		$canDo	= StorePapersHelper::getActions();
		
		// Añade submenus 
		// -- mostrar panel de control
		$link = JURI::base().'index.php?option='.JRequest::getCmd('option');
		JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_SUBMENU_VOLVER_PANEL_CONTROL'), $link);
		// -- mostrar autores
		$link = JURI::base().'index.php?option='.JRequest::getCmd('option').'&view=mostrarAutor';
		JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_GESTOR_AUTORES'), $link);
		// -- mostrar categorias
		$link = JURI::base().'index.php?option='.JRequest::getCmd('option').'&view=mostrarCategoria';
		JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_GESTOR_CATEGORIAS'), $link);		
		// -- preferencias
		if ($canDo->get('core.admin')) {
			$link = JURI::base().'index.php?option='.JRequest::getCmd('option').'&view=preferencias';
			JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_PREFERENCIAS'), $link);
		}
		
		// Añade el titulo en la barra de herramientas
		JToolBarHelper::title(JText::_('COM_STOREPAPERS').': '.JText::_('COM_STOREPAPERS_GESTOR_PUBLICACIONES'),'storepapers');
		JHtml::stylesheet('com_storepapers/backend.css', array(), true, false, false);		

		// Añade botones en la barra de herramientas		
		if ($canDo->get('core.edit.state')) {			
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();			
		}
		
		if ($canDo->get('core.create')) {
			JToolBarHelper::divider();
			JToolBarHelper::addNew();		
		}
		if (!$canDo->get('core.create'))
			JToolBarHelper::divider();		
			
		if ($canDo->get('core.edit'))
			JToolBarHelper::editList();

		if ($canDo->get('core.delete'))
			JToolBarHelper::deleteList();
	}
}
?>
