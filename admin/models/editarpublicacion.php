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

class StorepapersModelEditarPublicacion extends StorepapersModelStorepapers{

    protected $datos 		= null;
	
	public function reset(){
		
		$this->datos 		= null;
	}	
	/*
	Función que guarda la publicación en la base de datos.
	*/
	public function guardarEditarPublicacion($post){
		
		$row =& JTable::getInstance('Publicacion', 'Table');		
			
		if (!$row->bind($post)) 
			return JError::raiseWarning(500, $row->getError());
		if (!$row->store()) 
			return JError::raiseWarning(500, $row->getError());		
		return 1;		
	}
	/*
	Función que actuliza los valores entre los autores y las publicaciones.
	*/
	public function actualizarEnlacesEntreAutorPublicacion($listaAutores, $listaPrioridad, $id){
			
		if (!empty( $this->datos ))
			$this->datos = null;
		//Borro todos los enlaces referentes al idp	
		$query = "DELETE FROM #__storepapers_autorpubli WHERE idp = $id";
		$this->datos = $this->_getList( $query );
		
		//Ahora creo todos los enlaces entre autores y publicaciones
		$n = count($listaAutores);
		for($i = 0;$i < $n;$i ++){
			$query = 'INSERT INTO #__storepapers_autorpubli (ida,idp,prioridad)
			VALUES ('.$listaAutores[$i].','.$id.','.$listaPrioridad[$i].')';
			$this->datos = $this->_getList( $query );
		}		
	}
}
?>
