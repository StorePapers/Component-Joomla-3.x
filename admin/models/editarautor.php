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

class StorepapersModelEditarAutor extends StorepapersModelStorepapers{

	var $datos;
	
	/*
	Esta función se utiliza tanto cuando se inserta un nuevo autor y se edita.
	*/
	function guardarAutor($post){
	
		$row =& JTable::getInstance('Autor', 'Table');
		
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
