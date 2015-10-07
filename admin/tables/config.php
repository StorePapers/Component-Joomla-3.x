<?php
/**
 *
 * This file is part of StorePapers
 *
 * Copyright (C) 2008-2012  Francisco Ruiz (storepapers@quepuedohacerhoy.com)
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

class TableConfig extends JTable{

	var $id = null;
	var $version = null;
	var $first = null;
	var $current = null;
	var $last = null;

	function __construct(&$db){
		parent::__construct( '#__storepapers_config', 'id', $db );
	}
}
?>
