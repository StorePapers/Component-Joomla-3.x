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

class StorepapersModelUpdate extends StorepapersModelStorepapers{

	protected $datos;
	
	public function reset(){
		
		$this->datos 		= null;
	}
	/*
	Función que cambia la versión en la tabla.
	*/
	public function setVersionStorePapers($id, $version){
		
		$post['id'] = $id;
		$post['version'] = $version;		
		
		$row = JTable::getInstance('Config', 'Table');		
			
		if (!$row->bind($post)) 
			return JError::raiseWarning(500, $row->getError());
		if (!$row->store()) 
			return JError::raiseWarning(500, $row->getError());	
			
		return (1);
	}
	/*
	Crea una tabla de configuración en un punto de las posibles actualizaciones
	concretamente cuando el estado es a -1 (no existe la tabla).
	*/
	public function crearTablaConfig($version){
		
		if (!empty( $this->datos ))
			$this->datos = null;
			
		//Se crea una nueva tabla llamada "config"
		$query = 'CREATE TABLE IF NOT EXISTS #__storepapers_config (
		`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`version` float NOT NULL,
		`first` YEAR NOT NULL DEFAULT \'1980\',
		`current` YEAR NOT NULL DEFAULT \'2010\',
		`last` YEAR NOT NULL DEFAULT \'2020\'
		) ENGINE=MyISAM AUTO_INCREMENT=1';
		$this->_getList( $query );

		//Se crea una tupla de esta tabla para guardar la configuración
		//$this->setVersionStorePapers(1, $version);
		$query = 'INSERT INTO #__storepapers_config (`id`, `version`, `first`, `current`, `last`) VALUES
		(1, '.$version.', 1980, 2013, 2020)';
		
		$this->_getList( $query );
		
		return (1);
	}
	
	//-----------------------------------------------------------
	//-----------------------------------------------------------
	//-----------Funciones de actualización de SQL---------------
	//-----------------------------------------------------------
	
	public function actualizarVer1_3A1_4(){
	
		if (!empty( $this->datos ))
			$this->datos = null;
			
		//Se modifica el campo nombre VARCHAR (50) a VARCHAR (255)
		//Tablas "#__storepapers_categorias".
		$query = 'ALTER TABLE `#__storepapers_categorias` CHANGE `nombre` `nombre` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL';				
		$this->_getList( $query );
		
		//Se añade un nuevo campo "consultable" a las siguientes tablas.
		$query = 'ALTER TABLE `#__storepapers_autores` ADD `consultable` TINYINT( 1 ) NOT NULL DEFAULT \'1\'';
		$this->_getList( $query );
		$query = 'ALTER TABLE `#__storepapers_categorias` ADD `consultable` TINYINT( 1 ) NOT NULL DEFAULT \'1\'';
		$this->_getList( $query );
		
		return (1);
	}	
	
	public function actualizarVer1_21A1_22(){	

		if (!empty( $this->datos ))
			$this->datos = null;
			
		//Se modifica los campos relacionados con el tipo YEAR a SMALLINT
		//Tablas "#__storepapers_config" y "#__storepapers_publicaciones".
		$query = 'ALTER TABLE `#__storepapers_config` CHANGE `first` `first` SMALLINT NOT NULL DEFAULT \'1980\'';
		$this->_getList( $query );
		$query = 'ALTER TABLE `#__storepapers_config` CHANGE `current` `current` SMALLINT NOT NULL DEFAULT \'2013\'';
		$this->_getList( $query );
		$query = 'ALTER TABLE `#__storepapers_config` CHANGE `last` `last` SMALLINT NOT NULL DEFAULT \'2020\'';
		$this->_getList( $query );
		$query = 'ALTER TABLE `#__storepapers_publicaciones` CHANGE `year` `year` SMALLINT NOT NULL';
		$this->_getList( $query );
		
		//Se añade un nuevo campo
		$query = 'ALTER TABLE `#__storepapers_publicaciones` ADD `month` TINYINT(2) NOT NULL DEFAULT \'1\'';
		$this->_getList( $query );
		
		return (1);
	}
	
	public function actualizarVer1_1A1_2(){

		if (!empty( $this->datos ))
			$this->datos = null;
			
		//Se añade un nuevo campo a la tabla publicaciones (published)
		$query = 'ALTER TABLE #__storepapers_publicaciones ADD published BOOL NOT NULL';
		$this->_getList( $query );
		
		//Se modifican todas las publicaciones para que esten publicadas
		$query = 'SELECT id FROM #__storepapers_publicaciones';
		$this->datos = $this->_getList( $query );

		$row = JTable::getInstance('Publicacion', 'Table');
		$post['published'] = 1;
		$n = count($this->datos);
		for($i = 0; $i < $n ; $i++){
			
			$post['id'] = $this->datos[$i]->id;						
			if (!$row->bind($post)) 
				return JError::raiseWarning(500, $row->getError());
			if (!$row->store()) 
				return JError::raiseWarning(500, $row->getError());			
		}		
		return (1);
	}
}
?>
