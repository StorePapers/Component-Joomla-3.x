<!-- 
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
-->
<?php
defined( '_JEXEC' ) or die;

// Import html
JHtml::_('behavior.framework');
jimport ('joomla.html.html.bootstrap');
?>

<form name="adminForm" id="adminForm" action="index.php" method="post">
	<table class="table table-striped">
		<tbody>
		<tr>
			<td>		
				<table class="adminlist">
				<thead>
				<tr>
					<th width="8"><h4>ID</h4></th>
					<th align="center" width="8"></th>
					<th><h4><?php echo JText::_('NOMBRE_AUTOR_A_BORRAR');?></h4></th>
				</tr>
				</thead>
					<?php echo '<tr><td align="center">'.$this->mensaje['autor'][0]->id.'</td><td>'.JHtml::_('grid.id', 0, $this->mensaje['autor'][0]->id).'</td><td align="center">'.$this->mensaje['autor'][0]->nombre.'</td></tr>';?>
				</table>
			</td>
		</tr>
		<tr>
			<td>
			<br/>
			</td>
		</tr>
		<tr>
			<td>
				<?php if(count( $this->mensaje['publicacion'] ) > 0){?>
				<table class="adminlist">
				<thead>
					<tr>
						<th width="5" align="center"><h4>#</h4></th>
						<th width="5" align="center"><h4>ID</h4></th>
						<th><h4><?php echo JText::_('NOMBRE_ENLACES_PUBLICACIONES_BORRAN');?></h4></th>
						<th><h4><?php echo JText::_('AÑO');?></h4></th>
					</tr>
				</thead>
				<?php
				$n = count( $this->mensaje['publicacion'] );
				for ($i=0; $i < $n; $i++){
					$row =& $this->mensaje['publicacion'][$i];
					if ($i % 2 == 0)
						echo '<tr class="row0">';
					else
						echo '<tr class="row1">';
					echo '<td align="center">'.($i + 1).'</td><td align="center">'.$row->id.'</td><td align="center">'.$row->nombre.'</td><td align="center">'.$row->year.'</td></tr>';
					}
				?>
				<?php } ?>
				</table>
			</td>
		</tr>
		</tbody>
	</table>

	<p style="text-align: center;">StorePapers <?php echo JText::_('COMPONENTE_VERSION');?></p>
	<input type="hidden" name="option" 		id="option" value="com_storepapers" />
	<input type="hidden" name="view"   		id="view"   value="borrarAutor" />
	<input type="hidden" name="id" 			id="id"		value="<?php echo $this->mensaje['autor'][0]->id;?>" />
	<input type="hidden" name="task"   		id="task"   value="display" />
	<input type="hidden" name="boxchecked" 	id="boxchecked" value="0" />
</form>
