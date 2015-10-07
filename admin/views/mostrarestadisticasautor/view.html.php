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

class StorepapersViewMostrarEstadisticasAutor extends JViewLegacy{
	
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
		$ida = $_GET['ida'];
		$idc = $_GET['idc'];		
		
		//Leo los autores y las categorias de la BD		
		$data['categorias'] = $model->getCategorias();
		$data['autores'] = $model->getAutores();
		
		$data['autorFiltrado'] = $model->getAutor($ida);		
		
		$data['ida'] = $ida;
		$data['idc'] = $idc;		
		
		if($idc > 0){
			$data['numPubTotal'] = $model->consultaNumeroPublicacionesPorAnoCategoria($idc);
			$data['categoriaFiltrada'] = $model->getCategoria($idc);			
		}
		else{			
			//Leo el número de publicaciones totales			
			$data['numPubTotal'] = $model->consultaNumeroPublicacionesPorAnoTotales();
		}
		
		//Aquí realizo las consultas por año de publicaciones, fila a fila.			
		$n = count( $data['numPubTotal'] );
		for ($i = 0; $i < $n; $i++){
			$row =& $data['numPubTotal'][$i];
			$data['numPubFiltroAutorCategoria'][$i] = $model->consultaNumeroPublicacionesPorAnoCategoriaAutor($ida, $idc, $row->year);
		}
				
		$data['numPubTotalParcialAutor'] = $model->consultaNumeroPublicacionesPorAnoTotales();
		$n = count( $data['numPubTotalParcialAutor'] );
		for ($i = 0; $i < $n; $i++){
			$row =& $data['numPubTotalParcialAutor'][$i];
			$data['numPubTotalParcialAutor'][$i] = $model->consultaNumeroPublicacionesPorAnoCategoriaAutor($ida, 0, $row->year);
		}
				
		$this->assignRef( 'data', $data );
		
		//Añado la barra de herramientas
		$this->addToolbar();
		
		parent::display($tpl);
	}
	
	protected function addToolbar() {
	
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'storepapers.php';
		
		$canDo	= StorePapersHelper::getActions();
		
		// Añade el titulo en la barra de herramientas
		JToolBarHelper::title(JText::_('COM_STOREPAPERS').': '.JText::_('ESTADISTICAS_POR_AUTOR'),'storepapers');
		JHtml::stylesheet('com_storepapers/backend.css', array(), true, false, false);
		
		// Añade submenus 
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
		if ($canDo->get('core.admin')){
			$link = JURI::base().'index.php?option='.JRequest::getCmd('option').'&view=preferencias';
			JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_PREFERENCIAS'), $link);
		}

		// Añade botones en la barra de herramientas
		JToolBarHelper::custom( 'controlPanel', 'home', null, JText::_('COM_STOREPAPERS_PANEL_DE_CONTROL'), false);
	}
}
?> 
