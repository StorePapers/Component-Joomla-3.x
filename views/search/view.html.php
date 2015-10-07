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

class StorePapersViewSearch extends JViewLegacy{

	public 		$params;
	protected	$ida;
	protected	$idc;
	protected	$year;
	
	protected	$idp;
		
	function display($tpl = null){
	
		/*Esto es para el ACL*/		
		$app			= JFactory::getApplication();
		//$db			= JFactory::getDBO();
		$uri 			= JURI::getInstance();	
		//$user 		= JFactory::getUser();
		$model			= $this->getModel();
		//$editor 		= JFactory::getEditor();		
		$this->params	= $app->getParams();		

		//Esto es para incluir un css
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base() . 'components/com_storepapers/assets/css/storepapers.css');		
		
		$data = array();
		$data = $this->iniciarDesplegables($data);
		
		$data['mostrarResultados'] = false;
		
		if((JRequest::getVar('ida') != null) || (JRequest::getVar('idc') != null) || (JRequest::getVar('year') != null)){			
			$data['mostrarResultados'] = true;
			
			//Recojo la información de todos los autores y poder realizar un filtro a las publicaciones
			$data['nombreautores'] = $model->getAutores();
			//Leo todas las categorias disponibles de la BD
			$data['categorias']    = $model->getCategorias();
			//Recojo la información de todos los años y poder realizar un filtro a las publicaciones
			$data['year'] 		   = $model->getYearDistinct($this->idc);
			
			//Esto es por si se ha buscado la publicacion desde el modulo de búsqueda
			if((JRequest::getVar('idp') != null) && (JRequest::getVar('idp') > 0)){
				$publicaciones = $model->getPublicacion(JRequest::getVar('idp', 0));
			}
			else{
				$publicaciones	   = $model->getPublicacionesFiltradas(JRequest::getVar('idc', 0), JRequest::getVar('ida', 0), JRequest::getVar('year', 'all'));
			}
			$data['total']	   = $model->getTotal();
			
			// Para mostrar la paginación
			$pagination = $model->getPagination();
			$this->assignRef( 'pagination',	$pagination );
			
			//Esto es para mostrar el nombre de los autores por publicación.
			$autores = array();
			//$w = count($data['publicaciones']);
			$w = count($publicaciones);
			
			if(($data['total'] > 0) && ($w == 0))				
				$data['mostrarResultados'] = false;
			else{
				for ($i = 0; $i < $w; $i++){
					$row  =& $publicaciones[$i];
					$temp = $model->getAutoresSegunPublicacion($row->id);
					
					$temp2 = array();
					$v = count( $temp );
					for ($j = 0; $j < $v; $j++){
						$temp2[$j] = $model->getAutor($temp[$j]->ida);
						if(empty($temp2[$j]))
							unset($temp2[$j]);
					}
					//Ordenar de forma alfabética
					asort($temp2, SORT_LOCALE_STRING);
					//Re-indexar:
					$temp2 = array_values($temp2);
					
					$autores[$row->id] = $temp2;
				}
				$data['autores'] = $autores;
				//print_r($data['autores']);
				//print_r($temp);
			}
			
			/*
			Una vez hecho esto realizo una división de publicaciones por años
			Para ordenarlos por título o por autor.
				0	-->		Título
				1	-->		Autor
			*/			
			
			$yearAnterior		= null;
			$anosPublications	= array();
			$arrayPublications	= array();
			
			$w = count($publicaciones);		
			for ($i = 0; $i < $w; $i++){
				$row  =& $publicaciones[$i];
				
				//Si es nuevo año
				if(($row->year != $yearAnterior) && ($yearAnterior != null)){
					if($this->params->get('order_publication') == 1)
						$arrayPublications = $model->ordenarPublicationsAutor($arrayPublications, $data['autores']);	//Operación de ordenación
					$data['publicaciones'][$yearAnterior]	= $arrayPublications;
					$arrayPublications	= array();
				}
				
				if($row->year != $yearAnterior){
					$yearAnterior = $row->year;
					array_push($anosPublications, $row->year);
				}				
				array_push($arrayPublications, $row);				
			}
			if($this->params->get('order_publication') == 1)
				$arrayPublications = $model->ordenarPublicationsAutor($arrayPublications, $data['autores']);			//Operación de ordenación
			$data['publicaciones'][$yearAnterior]	= $arrayPublications;												//Para insertar el último año
			
			$data['anosPublications'] = $anosPublications;
			
			//print_r($data['publicaciones']);
			
			//Esto es por si se ha buscado la publicacion desde el modulo de búsqueda
			if((JRequest::getVar('idp') != null) && (JRequest::getVar('idp') > 0)){
				$data['total']	= 0;
			}
		}
		
		if($data['mostrarResultados'] == false){
			//Esto se hace para mostrar publicaciones nada mas pinchar en el menu.
			//O si ha habido algun problema con la paginación y no muestra nada.
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
			
			$uri->setVar('ida', 0);
			$uri->setVar('idc', 0);
			$uri->setVar('idp', JRequest::getVar('idp', 0));
			$uri->setVar('year', 'all');
			$uri->setVar('limitstart', 0);

			$app->redirect(JRoute::_('index.php'.$uri->toString(array('query', 'fragment')), false));
		}
		
		//print_r($this->params);		
		$data['params'] = $this->params;
		
		$this->assignRef( 'mensaje' , $data );		
			
		// Display the view
		parent::display($tpl);
	}
	
	function iniciarDesplegables($data){
	
		$this->ida = JRequest::getVar('ida');
		if($this->ida != null)			
			$data['filtroidautor'] = $this->ida;
		else
			$data['filtroidautor'] = 0;
		
		$this->idc = JRequest::getVar('idc');
		if($this->idc != null)			
			$data['filtroidcategoria'] = $this->idc;
		else
			$data['filtroidcategoria'] = 0;
		
		$this->year = JRequest::getVar('year');
		if($this->year != null)			
			$data['filtroyear'] = $this->year;
		else
			$data['filtroyear'] = 0;	
			
		return($data);
	}
}
?>