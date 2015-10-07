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

require_once JPATH_COMPONENT_ADMINISTRATOR.'/models/storepapers.php';

class StorepapersModelMostrarPublicacion extends StorepapersModelStorepapers{

    protected $pagination 	= null;
	protected $total 		= 0;
	
	public function __construct($config = array()){
	
		parent::__construct($config);
	
		// Get and store the pagination request variables
		$app = JFactory::getApplication();
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		$limitstart = $app->getUserStateFromRequest(JRequest::getCmd('option','com_storepapers').$this->getName().'limitstart','limitstart',0);
		
		$this->setState('limit',$limit);
		$this->setState('limitstart',$limitstart);	
	}
	
	public function reset(){
		
		$this->datos 		= null;
		$this->pagination 	= null;
		$this->total 		= 0;
	}
	/*
	Función privada que obtiene la clausula 'where' según el filtro elegido
	por el usuario.
	Devulve una cadena.
	*/
	private function getWherePublicacionesFiltradas($idc, $ida, $year){
	
		if (!empty( $where ))
			$where = null;
	
		$where = " ";
		$enc = 0;
		
		if ( ($idc == 0) && ($ida == 0) && ($year == "all"))
			$where = " 1 ";
		else{
			if($idc > 0){
				$where .= " #__storepapers_publicaciones.idc = $idc ";
				$enc = 1;
			}
			//Aqui pueden venir más filtros			
			if($year != "all"){
				if($enc == 1){
					$where .= ' AND ';
					$enc = 0;
				}
				$where .= " #__storepapers_publicaciones.year = $year ";
				$enc = 1;
			}
			//Aqui pueden venir más filtros
			if($ida > 0){				
				if($enc == 1){
					$where .= " AND ";
					$enc = 0;
				}
				$where .= " #__storepapers_publicaciones.id = #__storepapers_autorpubli.idp 
						   AND #__storepapers_autores.id = $ida 
						   AND #__storepapers_autorpubli.ida = $ida ";
				$enc = 1;
			}
		}
		return $where;
	}
	/*
	Función privada que obtiene la clausula 'from' según el filtro elegido
	por el usuario.
	Devulve una cadena.
	*/
	private function getFromPublicacionesFiltradas($idc, $ida, $year){
	
		if (!empty( $from ))
			$from = null;
			
		$from = "#__storepapers_publicaciones";
		$enc = 0;
					
		//Aqui pueden venir más filtros
		if($ida > 0)
			$from .= " , #__storepapers_autores, #__storepapers_autorpubli ";
				
		return $from;
	}
	/*
	Función que filtra las publicaciones mostradas al usuario según la categoria,
	autor y año. 
	Devuelve los campos publicaciones id, idc, nombre, published, year.	
	*/
	public function getPublicacionesFiltradas($idc, $ida, $year){

		if (!empty( $this->datos ))
			$this->datos = null;
			
		$limit 			= $this->getState('limit');
		$limitstart 	= $this->getState('limitstart');
		
		//Esto es cuando se elige en el desplegable la opción "Mostrar - Todos"
		if($limit == 0)
			$limit = $this->getTotal();
		
		$from  = $this->getFromPublicacionesFiltradas($idc, $ida, $year);
		$where = $this->getWherePublicacionesFiltradas($idc, $ida, $year);
		
		$query = "SELECT #__storepapers_publicaciones.id, #__storepapers_publicaciones.idc, #__storepapers_publicaciones.nombre, 
				#__storepapers_publicaciones.published, #__storepapers_publicaciones.year, #__storepapers_publicaciones.month 
				FROM $from WHERE $where 
				ORDER BY #__storepapers_publicaciones.year DESC, #__storepapers_publicaciones.nombre ASC 
				LIMIT $limitstart , $limit";
		$this->datos = $this->_getList( $query );		
		
		return $this->datos;		
	}
	/*
	Funcion que devuelve los autores que han participado en una publicación segun el id de este.
	Devuelve nombre autor, id autor y la prioridad.
	*/
	public function getAutoresDePublicacion($id){
		
		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = 	"SELECT #__storepapers_autores.nombre, #__storepapers_autores.id, #__storepapers_autorpubli.prioridad
					FROM #__storepapers_autores, #__storepapers_autorpubli
					WHERE #__storepapers_autorpubli.ida = #__storepapers_autores.id AND #__storepapers_autorpubli.idp=$id
					ORDER BY #__storepapers_autores.nombre";
		$this->datos = $this->_getList( $query );			
		
		return $this->datos;
	}
	
	// ----------------------------
	// Funciones para la paginacion
	// ----------------------------
	public final function getPagination(){
	
		if( empty($this->pagination) ){
			// Import the pagination library
			jimport('joomla.html.pagination');		
			
			$total 			= $this->getTotal();
			$limit 			= $this->getState('limit');
			$limitstart 	= $this->getState('limitstart');

			/*if($limit == 0)
				$limit = $total;*/

			// Create the pagination object
			$this->pagination = new JPagination($total, $limitstart, $limit);
		}
		return $this->pagination;
	}

	public final function getTotal(){
	
		if( empty($this->total) ){
		
			//parámetros de filtrado
			$idc  = JRequest::getCmd('idc','0');
			$ida  = JRequest::getCmd('ida','0');
			$year = JRequest::getCmd('year','all');	
		
			//Según el filtro habrá mas publicaciones o menos totales
			$from  = $this->getFromPublicacionesFiltradas($idc, $ida, $year);
			$where = $this->getWherePublicacionesFiltradas($idc, $ida, $year);
			
			$query = "SELECT COUNT(*) FROM ($from) WHERE ($where)";			

			$this->_db->setQuery( $query );
			$this->_db->query();
			
			$this->total = $this->_db->loadResult();
		}
		return $this->total;
	}
}
?>
