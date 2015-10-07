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

class StorepapersModelBorrarCategoria extends StorepapersModelStorepapers{

    protected $datos;
	
	public function reset(){
		
		$this->datos 		= null;
	}		
	/*
	Esta función se encarga de borrar todos los enlaces de la categoria a las publicaciones, las publicaciones
	contenidas en esa categoría y la categoría.
	*/
	public function borrarCategoria($idCategoria){
		
		if (!empty( $this->datos ))
			$this->datos = null;
			
		//Antes de borrar las publicaciones tengo que borrar todos los enlaces entre esas publicaciones y sus autores
		$query = "SELECT * FROM #__storepapers_publicaciones WHERE idc = $idCategoria";
		$this->datos = $this->_getList( $query );
		
		$n = count($this->datos);
		for($i = 0;$i < $n;$i ++){
			$row =& $this->datos[$i];
			$query = "DELETE FROM #__storepapers_autorpubli WHERE idp = $row->id";
			$this->datosBorrar = $this->_getList( $query );
		}
		
		//Borro todos las publicaciones con el mismo idc
		$query = "DELETE FROM #__storepapers_publicaciones WHERE idc = $idCategoria";
		$this->datosBorrar = $this->_getList( $query );
		
		//Borro la categoría
		$query = "DELETE FROM #__storepapers_categorias WHERE id = $idCategoria";
		$this->datosBorrar = $this->_getList( $query );
			
		return 1;	
	}
}
?>
