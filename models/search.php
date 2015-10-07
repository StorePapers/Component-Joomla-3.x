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

// Import MODEL object class
jimport('joomla.application.component.model');

class StorepapersModelSearch extends JModelLegacy{
    
	protected $datos 		= null;
	protected $pagination 	= null;
	protected $total 		= 0;
	
	public function __construct(){
	
		parent::__construct();
	
		// Get and store the pagination request variables
		$app 		= JFactory::getApplication();
		$limit 		= $app->getUserStateFromRequest('com_storepapers.limit', 'limit', $app->getCfg('list_limit'));		
		//$limitstart = $app->getUserStateFromRequest(JRequest::getCmd('option','com_storepapers').$this->getName().'limitstart','limitstart',0);
		$limitstart = $app->getUserStateFromRequest('com_storepapers.limitstart','limitstart',0);
				
		$this->setState('limit',$limit);
		$this->setState('limitstart',$limitstart);		
	}
	
	public function reset(){
		
		$this->datos 		= null;
	}
	
	/*
	Función que devuelve toda la información relacionada con los autores.
	Devuelve todos los campos.
	*/
	public function getAutores(){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT #__storepapers_autores.id, #__storepapers_autores.nombre FROM #__storepapers_autores 
					WHERE #__storepapers_autores.consultable = 1 
					ORDER BY nombre ASC";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que devuelve toda la información relacionada con las categorias.
	Devuelve el campo id y nombre.
	*/
	public function getCategorias(){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT #__storepapers_categorias.id, #__storepapers_categorias.nombre FROM #__storepapers_categorias 
					WHERE #__storepapers_categorias.consultable = 1";
		
		$query .= " ORDER BY #__storepapers_categorias.nombre ASC";	
					
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que devuelve todos los años ordenador de menor a mayor distintos de las publicaciones
	almacenadas en la base de datos.
	Los parámetros de entrada sirven para no mostrar años segun una categoria.
	Devuelve el campo year.
	*/
	public function getYearDistinct($idc){
		
		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = "SELECT DISTINCT year FROM #__storepapers_publicaciones, #__storepapers_categorias 
					WHERE #__storepapers_publicaciones.published = 1 AND 
						  #__storepapers_categorias.consultable = 1 AND
						  #__storepapers_categorias.id = #__storepapers_publicaciones.idc";		
		if($idc > 0)
			$query .= " AND #__storepapers_publicaciones.idc = $idc ";
		
		$query .= " ORDER BY year DESC";			
					
		$this->datos = $this->_getList( $query );			
		
		return $this->datos;
	}
	/*
	Función privada que obtiene la clausula 'where' según el filtro elegido
	por el usuario.
	Devuelve una cadena.
	*/
	private function getWherePublicacionesFiltradas($idc, $ida, $year){
	
		if (!empty( $where ))
			$where = null;
	
		//$where = " ";
		//Filtro que añado, no se muestran las publicaciones no publicadas.		
		$where  = " #__storepapers_publicaciones.published = 1 AND #__storepapers_categorias.consultable = 1 AND"; 		
		$where .= " #__storepapers_categorias.id = #__storepapers_publicaciones.idc ";		
		
		$enc    = 1;		
		
		if ( ($idc == 0) && ($ida == 0) && ($year == "all")){			
			//$where = " 1 ";
			$enc = 1;
		}
		else{			 
			if($idc > 0){
				if($enc == 1){
					$where .= ' AND ';
					$enc = 0;
				}
				$where .= " #__storepapers_publicaciones.idc = $idc AND #__storepapers_categorias.id = $idc ";
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
				//Filtro que añado, no se muestran las publicaciones no publicadas.	
				$where .= " #__storepapers_autores.consultable = 1 AND";			
				
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
			
		$from = "#__storepapers_publicaciones, #__storepapers_categorias";		
		
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
				#__storepapers_publicaciones.texto, #__storepapers_publicaciones.published, #__storepapers_publicaciones.year, 
				#__storepapers_publicaciones.month, #__storepapers_categorias.nombre AS nombreCategoria
				FROM $from WHERE $where 
				ORDER BY #__storepapers_publicaciones.year DESC, #__storepapers_categorias.nombre ASC, #__storepapers_publicaciones.nombre ASC
				LIMIT $limitstart , $limit";		
		
		$this->datos = $this->_getList( $query );		
		
		return $this->datos;		
	}
	/*
	Función que devuelve toda la información de un autor.
	Devuelve todos los campos.
	*/
	public function getAutor($ida){

		if (!empty( $this->datos ))
			$this->datos = null;

		$query = "SELECT nombre FROM #__storepapers_autores 
					WHERE 	#__storepapers_autores.id = $ida 
						AND #__storepapers_autores.consultable = 1";
		$this->datos = $this->_getList( $query );
		
		if(count($this->datos) > 0)
			return $this->datos[0]->nombre;
		else
			return null;
	}
	
	/*
	Función que realiza una consulta para obtener el identificador del autor y la prioridad
	de una publicación dada su idp.
	*/
	public function getAutoresSegunPublicacion($idp){

		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = "SELECT ida, prioridad 
				  FROM 		#__storepapers_publicaciones, #__storepapers_autorpubli 
				  WHERE 	#__storepapers_publicaciones.id = #__storepapers_autorpubli.idp 
						AND #__storepapers_publicaciones.id = $idp
						AND #__storepapers_publicaciones.published = 1";
						
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que realiza una consulta en la tabla publicaciones según id.
	Devuelve todos los campos.
	*/
	public function getPublicacion($id){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT p.nombre AS nombre, p.texto AS texto, p.year AS year, p.month AS month, p.published AS published, p.id AS id, c.nombre AS nombreCategoria
					FROM #__storepapers_publicaciones AS p
					INNER JOIN #__storepapers_categorias AS c ON p.idc = c.id
					WHERE p.id = $id AND p.published = 1";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Sobrecarga del método cmp para usarlo en la función usort
	*/
	public function cmp($a, $b){
		return strcmp($a->autores.' '.$a->nombreCategoria.' '.$a->nombre, $b->autores.' '.$b->nombreCategoria.' '.$b->nombre);
	}
	/*
	Función que realiza un ordenamiento de las publicaciones en orden alfabetico de los autores.
	*/
	public function ordenarPublicationsAutor($publicationsArray, $autoresArray){
		
		if(count($publicationsArray) > 1){
			$w = count($publicationsArray);
			for ($i = 0; $i < $w; $i++){
				$row  =& $publicationsArray[$i];
				
				//Obtengo los autores
				$autores = '';
				$rowAutores  =& $autoresArray[$row->id];
				$v = count($rowAutores);
				for ($j = 0; $j < $v; $j++){
					$autores .= $rowAutores[$j].' ';
				}
				
				//Meto los autores en el publicationsArray
				$row->autores = $autores;
			}
			//Se ordenan según el autor
			usort($publicationsArray, array($this, 'cmp'));
		}		
		return $publicationsArray;
	}
	// ----------------------------
	// Funciones para la paginacion
	// ----------------------------
	public final function getPagination(){
	
		if( empty($this->pagination) ){
			// Import the pagination library
			jimport('joomla.html.pagination');	
			
			// Create the pagination object
			$this->pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
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

/*
Funciones viejas.
*/	


	
	/*
	Función que devuelve toda la información relacionada con una categoria.
	Devuelve todos los campos.
	*/
	/*public function getCategoria($idc){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT * FROM #__storepapers_categorias WHERE id=$idc";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}*/
	/*
	Función que cuenta las publicaciones agrupadas por categorias.
	Devuelve nombre, id y total.
	*/
	/*public function getCountPublicaciones(){

		if (!empty( $this->datos ))
			$this->datos = null;		
		
		$query = "SELECT cat.nombre, cat.id, count(*) total FROM #__storepapers_publicaciones pub, #__storepapers_categorias cat WHERE cat.id=pub.idc GROUP BY pub.idc ORDER BY cat.nombre";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}*/
	/*
	Función que cuenta las publicaciones agrupadas por categorias y el estado (publicadas o no).
	Devuelve nombre, id y total.
	*/
	/*public function getCountPublicacionesPublicadas($estado){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT cat.nombre, cat.id, count(*) total FROM #__storepapers_publicaciones pub, #__storepapers_categorias cat WHERE cat.id=pub.idc AND pub.published=$estado GROUP BY pub.idc ORDER BY cat.nombre";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}*/
	/*
	En esta función busco el identificador de la última publicación insertada, se usa para crear los enlaces
	a los autores.
	Devuelve id.
	*/
	/*public function getIDNuevaPublicacion(){
	
		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = "SELECT id FROM #__storepapers_publicaciones ORDER BY id DESC";
		$this->datos = $this->_getList( $query );
		
		return $this->datos[0]->id;
	}*/
	/*
	Función que devuelve todos los campos de la tabla config o preferencias.
	Devuelve todos los campos.
	*/
	/*public function getPreferencias(){

		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = "SELECT * FROM #__storepapers_config";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}*/
	/*
	Función que realiza una consulta según el autor.
	Devuelve id, nombre y year.
	*/
    /*public function getPublicacionSegunAutor($ida){

		if (!empty( $this->datos ))
			$this->datos = null;

		$query = 	"SELECT #__storepapers_publicaciones.id, #__storepapers_publicaciones.nombre, #__storepapers_publicaciones.year
					FROM #__storepapers_autorpubli, #__storepapers_publicaciones
					WHERE #__storepapers_autorpubli.idp = #__storepapers_publicaciones.id AND #__storepapers_autorpubli.ida=$ida
					ORDER BY #__storepapers_publicaciones.year DESC, #__storepapers_publicaciones.nombre ASC";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}*/
	/*
	Función que realiza una consulta en la tabla publicaciones según id.
	Devuelve todos los campos.
	*/	
}
?>
