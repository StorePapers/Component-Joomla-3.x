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

class StorepapersModelMostrarEstadisticasAutor extends StorepapersModelStorepapers{

    protected $datos = null;
	
	public function reset(){
		
		$this->datos 		= null;
	}
    	
	public function consultaNumeroPublicacionesPorAnoTotales(){

		if (!empty( $this->datos ))
			$this->datos = null;
				
		$query = 'SELECT distinct(year), count(*) total from #__storepapers_publicaciones GROUP BY year ORDER BY year DESC';
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	public function consultaNumeroPublicacionesPorAnoCategoria($idc){

		if (!empty( $this->datos ))
			$this->datos = null;
				
		$query = "SELECT distinct(year), count(*) total from #__storepapers_publicaciones WHERE idc=$idc GROUP BY year ORDER BY year DESC";
		$this->datos = $this->_getList( $query );
		
		return $this->datos;
	}
	/*	
	Si idc es igual a 0 me devuelve todas las publicaciones, si es distinto me hace un filtro según las categorías.	
	*/
	public function consultaNumeroPublicacionesPorAnoCategoriaAutor($ida, $idc, $year){

		if (!empty( $this->datos ))
			$this->datos = null;
		
		if($idc == 0)
			$where = "WHERE #__storepapers_autorpubli.ida = $ida 
					AND #__storepapers_publicaciones.id = #__storepapers_autorpubli.idp
					AND #__storepapers_autores.id = $ida 
					AND #__storepapers_publicaciones.year = $year";
		else
			$where = "WHERE #__storepapers_autorpubli.ida = $ida 
					AND #__storepapers_publicaciones.id = #__storepapers_autorpubli.idp
					AND #__storepapers_autores.id = $ida 
					AND #__storepapers_publicaciones.idc = $idc 
					AND #__storepapers_publicaciones.year = $year";
					
		$query = " SELECT distinct(#__storepapers_publicaciones.year), count(#__storepapers_publicaciones.nombre) total
				FROM #__storepapers_autores, #__storepapers_autorpubli, #__storepapers_publicaciones
				$where
				GROUP BY #__storepapers_publicaciones.year
				ORDER BY #__storepapers_publicaciones.year DESC";
			
		$this->datos = $this->_getList( $query );
		
		if(strcmp($year, "todas") != 0){
			//echo "devuelve nulo $year, ";
			//var_dump($this->datos);
			if($this->datos == null)
				$this->datos = array('year' => "$year", 'total' => '0');
			else{				
				$row =& $this->datos[0]->total;
				$this->datos = array('year' => "$year", 'total' => "$row");
			}			
		}		
		
		return $this->datos;
	}	
}
?>
