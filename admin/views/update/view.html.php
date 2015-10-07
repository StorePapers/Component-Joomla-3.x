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

// Import VIEW object class
jimport( 'joomla.application.component.view' );

class StorepapersViewUpdate extends JViewLegacy{
	
	function display($tpl = null){
		
		$model = $this->getModel();	

		// Añade el titulo en la barra de herramientas
		JToolBarHelper::title(JText::_('COM_STOREPAPERS'),'storepapers');				
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
		$link = JURI::base().'index.php?option='.JRequest::getCmd('option').'&view=preferencias';
		JSubMenuHelper::addEntry(JText::_('COM_STOREPAPERS_PREFERENCIAS'), $link);		
		
		//Comparo la version del código con la versión de la base de datos. Si no coincide hay que actualizar.		
		$data['versionCodigo'] = 1.5;
		$data['versionSQL'] = 0;
		$data['versionSQL'] = $model->getVersionStorePapers();
		
		//Estados, en principio todo debe ir bien
		/*
		*	Código 0   = Sin problema.
		*	Código 1   = Se ha llevado a cabo alguna actualización.
		*	Código 12  = Se ha llevado a cabo la actualización Versión 1.2
		*	Código 121 = Se ha llevado a cabo la actualización Versión 1.21
		*	Código 122 = Se ha llevado a cabo la actualización Versión 1.22
		*	Código 13  = Se ha llevado a cabo la actualización Versión 1.3
		*	Código 14  = Se ha llevado a cabo la actualización Versión 1.4
		*	Código 15  = Se ha llevado a cabo la actualización Versión 1.5
		*	Código 6   = Error, no existe la tabla "config" o esta dañada
		*	Código 8   = La versión es inferior a 1.1, por prudencia se pasan todas las actualizaciones.
		*/
		$data['estado'] = 0;
		//Número de actualizaciones
		$numAct = 0;
		
		if($data['versionSQL'] != $data['versionCodigo']){
			
			while($data['versionSQL'] != $data['versionCodigo']){
			
				switch($data['versionSQL']){
				
					//Caso que la versión sea 1.4 - Se actualiza a la versión 1.5
					case	1.4:	//La actualización 1.5 no lleva cambios en la BD									
									$model->setVersionStorePapers(1, 1.5);
									$data['versionSQL'] = $model->getVersionStorePapers();
									
									if($data['estado'] == 0)
										$data['estado'] = 1;
										
									$data['actualizaciones'][$numAct] = 15;
									$numAct += 1;
									break;
				
					//Caso que la versión sea 1.3 - Se actualiza a la versión 1.4
					case	1.3:	//La actualización 1.4 si lleva cambios en la BD									
									$model->actualizarVer1_3A1_4();
									$model->setVersionStorePapers(1, 1.4);
									$data['versionSQL'] = $model->getVersionStorePapers();
									
									if($data['estado'] == 0)
										$data['estado'] = 1;
										
									$data['actualizaciones'][$numAct] = 14;
									$numAct += 1;
									break;
				
					//Caso que la versión sea 1.22 - Se actualiza a la versión 1.3
					case	1.22:	//La actualización 1.3 no lleva cambios en la BD									
									$model->setVersionStorePapers(1, 1.3);
									$data['versionSQL'] = $model->getVersionStorePapers();
									
									if($data['estado'] == 0)
										$data['estado'] = 1;
										
									$data['actualizaciones'][$numAct] = 13;
									$numAct += 1;
									break;
				
					//Caso que la versión sea 1.21 - Se actualiza a la versión 1.22
					case	1.21:	//La actualización 1.22 si lleva cambios en la BD
									$model->actualizarVer1_21A1_22();
									$model->setVersionStorePapers(1, 1.22);
									$data['versionSQL'] = $model->getVersionStorePapers();
									
									if($data['estado'] == 0)
										$data['estado'] = 1;
										
									$data['actualizaciones'][$numAct] = 122;
									$numAct += 1;
									break;
				
					//Caso que la versión sea 1.2 - Se actualiza a la versión 1.21
					case	1.2	:	//La actualización 1.21 no lleva cambios en la BD
									$model->setVersionStorePapers(1, 1.21);
									$data['versionSQL'] = $model->getVersionStorePapers();
									
									if($data['estado'] == 0)
										$data['estado'] = 1;
										
									$data['actualizaciones'][$numAct] = 121;
									$numAct += 1;
									break;
					
					//Caso que la versión sea 1.1 - Se actualiza a la versión 1.2
					case	1.1	:	$model->actualizarVer1_1A1_2();
									$model->setVersionStorePapers(1, 1.2);
									$data['versionSQL'] = $model->getVersionStorePapers();
									
									if($data['estado'] == 0)
										$data['estado'] = 1;
										
									$data['actualizaciones'][$numAct] = 12;
									$numAct += 1;
									break;
					/*
					*	-----------------------------------------------------------------------------
					*	-----------------------------------------------------------------------------
					*	-------------------------- Casos Especiales ---------------------------------
					*	-----------------------------------------------------------------------------
					*/				
					//No existe la tabla "config" o está dañada. Por prudencia se pasan todas las actualizaciones.
					case	-1	:	$model->crearTablaConfig(1.1);
									$data['versionSQL'] = $model->getVersionStorePapers();
									$data['estado'] = 6;
									break;
									
					//Caso que la versión sea diferente 1.1 (algo va mal). Por prudencia se pasan todas las actualizaciones.
					default		:	$model->setVersionStorePapers(1, 1.1);
									$data['versionSQL'] = $model->getVersionStorePapers();
									$data['estado'] = 8;
									break;
				}
			}			
		}
		
		$this->assignRef( 'data', $data );		
		parent::display($tpl);
	}
}
?>
