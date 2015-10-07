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

class StorepapersModelMostrarCategoria extends StorepapersModelStorepapers{
    
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
	Funci�n que devuelve toda la informaci�n relacionada con las categorias.
	Devuelve todos los campos.
	*/
	public function getCategorias(){

		if (!empty( $this->datos ))
			$this->datos = null;
			
		$limit 			= $this->getState('limit');
		$limitstart 	= $this->getState('limitstart');
		
		//Esto es cuando se elige en el desplegable la opci�n "Mostrar - Todos"
		if($limit == 0)
			$limit = $this->getTotal();
		
		$query = "SELECT * FROM #__storepapers_categorias ORDER BY nombre LIMIT $limitstart , $limit";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Modifica el estado de las publicaciones de una categoria.
	*/
	function setEstadoPublicacionPorCategoria($idc, $estado){
		
		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT id FROM #__storepapers_publicaciones WHERE idc=$idc";
		$this->datos = $this->_getList( $query );
		
		$n = count( $this->datos );		
		for ($i=0; $i < $n; $i++){
			$row =& $this->datos[$i];
			$this->setEstadoPublicacionPorID($row->id, $estado);
		}
		return 1;
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

			// Create the pagination object
			$this->pagination = new JPagination($total, $limitstart, $limit);
		}
		return $this->pagination;
	}

	public final function getTotal(){
	
		if( empty($this->total) ){
			
			$query = "#__storepapers_categorias";
			$query = "SELECT COUNT(*) FROM ($query)";			

			$this->_db->setQuery( $query );
			$this->_db->query();
			
			$this->total = $this->_db->loadResult();
		}
		return $this->total;
	}
}
?>
