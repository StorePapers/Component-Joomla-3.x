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
jimport('joomla.application.component.model');

class StorepapersModelStorepapers extends JModelLegacy{
    
	protected $datos = null;
	
	public function reset(){
		
		$this->datos 		= null;
	}	
	/*
	Función que devuelve toda la información de un autor.
	Devuelve todos los campos.
	*/
	public function getAutor($ida){

		if (!empty( $this->datos ))
			$this->datos = null;

		$query = "SELECT * FROM #__storepapers_autores WHERE id=$ida";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que devuelve toda la información relacionada con los autores.
	Devuelve todos los campos.
	*/
	public function getAutores(){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT * FROM #__storepapers_autores ORDER BY nombre ASC";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que realiza una consulta para obtener el identificador del autor y la prioridad
	de una publicación dada su idp.
	*/
	public function getAutoresSegunPublicacion($idp){

		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = "SELECT ida, prioridad FROM #__storepapers_publicaciones,#__storepapers_autorpubli 
				WHERE #__storepapers_publicaciones.id = #__storepapers_autorpubli.idp 
				AND #__storepapers_publicaciones.id = $idp";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que devuelve toda la información relacionada con una categoria.
	Devuelve todos los campos.
	*/
	public function getCategoria($idc){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT * FROM #__storepapers_categorias WHERE id=$idc";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que devuelve toda la información relacionada con las categorias.
	Devuelve todos los campos.
	*/
	public function getCategorias(){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT * FROM #__storepapers_categorias ORDER BY nombre ASC";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que cuenta las publicaciones agrupadas por categorias.
	Devuelve nombre, id y total.
	*/
	public function getCountPublicaciones(){

		if (!empty( $this->datos ))
			$this->datos = null;		
		
		$query = "SELECT cat.nombre, cat.id, count(*) total FROM #__storepapers_publicaciones pub, #__storepapers_categorias cat WHERE cat.id=pub.idc GROUP BY pub.idc ORDER BY cat.nombre";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que cuenta las publicaciones agrupadas por categorias y el estado (publicadas o no).
	Devuelve nombre, id y total.
	*/
	public function getCountPublicacionesPublicadas($estado){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		$query = "SELECT cat.nombre, cat.id, count(*) total FROM #__storepapers_publicaciones pub, #__storepapers_categorias cat WHERE cat.id=pub.idc AND pub.published=$estado GROUP BY pub.idc ORDER BY cat.nombre";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	En esta función busco el identificador de la última publicación insertada, se usa para crear los enlaces
	a los autores.
	Devuelve id.
	*/
	public function getIDNuevaPublicacion(){
	
		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = "SELECT id FROM #__storepapers_publicaciones ORDER BY id DESC";
		$this->datos = $this->_getList( $query );
		
		return $this->datos[0]->id;
	}
	/*
	Función que devuelve todos los campos de la tabla config o preferencias.
	Devuelve todos los campos.
	*/
	public function getPreferencias(){

		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = "SELECT * FROM #__storepapers_config";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que realiza una consulta según el autor.
	Devuelve id, nombre y year.
	*/
    public function getPublicacionSegunAutor($ida){

		if (!empty( $this->datos ))
			$this->datos = null;

		$query = 	"SELECT #__storepapers_publicaciones.id, #__storepapers_publicaciones.nombre, #__storepapers_publicaciones.year
					FROM #__storepapers_autorpubli, #__storepapers_publicaciones
					WHERE #__storepapers_autorpubli.idp = #__storepapers_publicaciones.id AND #__storepapers_autorpubli.ida=$ida
					ORDER BY #__storepapers_publicaciones.year DESC, #__storepapers_publicaciones.nombre ASC";
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
			
		$query = "SELECT * FROM #__storepapers_publicaciones WHERE id = $id";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*
	Función que realiza una consulta en la tabla publicaciones según la categoria.
	Devuelve todos los campos.
	*/
	public function getPublicacionSegunCategoria($idc){

		if (!empty( $this->datos ))
			$this->datos = null;

		$query = "SELECT * FROM #__storepapers_publicaciones WHERE idc=$idc ORDER BY year DESC, nombre ASC";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}	
	/*
	Función que devuelve la versión de la base de datos de StorePapers.
	Devuelve un real, la version.
	*/
	function getVersionStorePapers(){

		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = "SELECT * FROM #__storepapers_config";
		$this->datos = $this->_getList( $query );
		
		if(count($this->datos) == 1)		
			return $this->datos[0]->version;
		else
			return -1;
	}
	/*
	Función que devuelve la versión del código de StorePapers.
	Devuelve un real, la version.
	*/
	function getVersionStorePapersCodigoPHP(){

		return 1.5;		
	}
	/*
	Función que devuelve todos los años ordenador de menor a mayor distintos de las publicaciones
	almacenadas en la base de datos.
	Devuelve el campo year.
	*/
	public function getYearDistinct(){
		
		if (!empty( $this->datos ))
			$this->datos = null;
			
		$query = "SELECT DISTINCT year FROM #__storepapers_publicaciones WHERE 1 ORDER BY year DESC";
		$this->datos = $this->_getList( $query );			
		
		return $this->datos;
	}
	
	/*
	Modifica el estado de una única publicación según el id, se le pasa el identificador de la publicación.    
	*/
	function setEstadoPublicacionPorID($idp, $estado){
	
		$post['id'] = $idp;
		$post['published'] = $estado;
		
		$row =& JTable::getInstance('Publicacion', 'Table');
		if (!$row->bind($post)) {
			return JError::raiseWarning(500, $row->getError());
		}
		if (!$row->store()) {
			return JError::raiseWarning(500, $row->getError());
		}
		return 1;
	}		
}
?>
