<?php
/**
 *
 * This file is part of StorePapers
 *
 * Copyright (C) 2008-2012  Francisco Ruiz (storepapers@quepuedohacerhoy.com)
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

class StorepapersViewBorrarCategoria extends JViewLegacy{
	
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
		$idc = $_GET['idc'];
		
		//Incluyo el identificador de la publiación a modificar
		$data['idc'] = $idc;
		
		//Leo la información de la categoria a borrar
		$data['categoria'] = $model->getCategoria($idc);
		
		//Leo las publicaciones contenidas en la categoria
		$data['publicacion'] = $model->getPublicacionSegunCategoria($idc);
		
		$this->assignRef( 'mensaje', $data );
		
		//Añado la barra de herramientas
		$this->addToolbar();
		
		parent::display($tpl);
	}
	
	protected function addToolbar() {
	
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'storepapers.php';
		
		$canDo	= StorePapersHelper::getActions();
		
		// Añade el titulo en la barra de herramientas
		JToolBarHelper::title(JText::_('COM_STOREPAPERS').': '.JText::_('BORRAR_CATEGORIA'), 'storepapers');
		JHtml::stylesheet('com_storepapers/backend.css', array(), true, false, false);		

		// Añade botones en la barra de herramientas
		if ($canDo->get('core.delete'))
			JToolBarHelper::trash();
		
		JToolBarHelper::cancel();
	}
}
?> 
