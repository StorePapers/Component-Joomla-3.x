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
<?php 
//Esto es para redireccionar cuando ha encontrado una actualización
if($this->mensaje['update'] == 1)
	header('Location: '.JURI::base().'index.php?option=com_storepapers&view=update');
?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th align="center" width="5"><h4>#</h4></th>
				<th width="5"><h4>ID</h4></th>
				<th align="center" width="8"><input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" /></th>
				<th><h4><?php echo JText::_('NOMBRE_CATEGORIA');?></h4></th>
				<th><h4><?php echo JText::_('COM_STOREPAPERS_NOMBRE_CONSULTABLE');?></h4></th>
				<th><h4><?php echo JText::_('CANTIDAD');?></h4></th>
				<th colspan="4"><h4><?php echo JText::_('ESTADO');?></h4></th>
			</tr>
		</thead>
		<?php
		$totalPublicaciones = 0;
		$totalPublicados    = 0;
		$totalNoPublicados  = 0;

		//Inicializo los valores para que todo el vector este a 0 publicaciones
		$n = count( $this->mensaje['nombreCategoria'] );
		for ($i=0; $i < $n; $i++){
			$this->vector['publicados'][$i] = 0;
			$this->vector['nopublicados'][$i] = 0;
		}
		//Evaluo para cada posición del vector cuantas publicaciones estan publicadas ó despublicadas
		$n = count( $this->mensaje['nombreCategoria'] );
		for ($i=0; $i < $n; $i++){
			$row =& $this->mensaje['nombreCategoria'][$i];
			$m = count( $this->mensaje['publicados'] );
			for ($j=0; $j < $m; $j++){
				$rowPub =& $this->mensaje['publicados'][$j];
				if($row->id == $rowPub->id)
					$this->vector['publicados'][$i] = $rowPub->total;
			}
			$m = count( $this->mensaje['nopublicados'] );
			for ($j=0; $j < $m; $j++){
				$rowPub =& $this->mensaje['nopublicados'][$j];
				if($row->id == $rowPub->id)
					$this->vector['nopublicados'][$i] = $rowPub->total;
			}
		}
		//Aquí muestro el resultado anterior junto con otra información importante
		$n = count( $this->mensaje['nombreCategoria'] );
		for ($i=0; $i < $n; $i++){
			$row =& $this->mensaje['nombreCategoria'][$i];
			if ($i % 2 == 0)
				echo '<tr class="row0">';
			else
				echo '<tr class="row1">';
			echo '<td align="center">'.($i + 1).'</td><td align="center">'.$row->id.'</td>';
					
			//echo '<td align="center"><INPUT TYPE="RADIO" NAME="categoria" VALUE="'.$row->id.'"></td>';
			echo '<td align="center">'.JHtml::_('grid.id', $i, $row->id).'</td>';
			echo '<td align="center"><b><a href="'.JURI::base().'index.php?option=com_storepapers&view=editarCategoria&idc='.$row->id.'">'.$row->nombre.'</a></b></td>';	
			
			if($row->consultable == '1')
				echo '<td align="center">'.JText::_('COM_STOREPAPERS_SI').'</td>';			
			else
				echo '<td align="center">'.JText::_('COM_STOREPAPERS_NO').'</td>';		
			
			
			//Esto es necesario cuando se tiene una categoría y no tiene ninguna publicación asociada
			$enc = 0;
			$m = count( $this->mensaje['categoria'] );
			for ($j=0; $j < $m; $j++){
				$rowPub =& $this->mensaje['categoria'][$j];
				if($row->id == $rowPub->id){
					echo '<td align="center">'.$rowPub->total.' '.JText::_('PUBLICACIONES').'</td>';
					$totalPublicaciones +=  $rowPub->total;
					$enc = 1;
				}
			}
			if ($enc == 0)
				echo '<td align="center">0 '.JText::_('PUBLICACIONES').'</td>';
			
			//publicados
			echo '<td align="center"><IMG SRC="'.JURI::base().'components/com_storepapers/images/publish_v.png"></td>';	
			echo '<td align="center">'.$this->vector['publicados'][$i].' '.JText::_('PUBLICADAS').'</td>';
			$totalPublicados += $this->vector['publicados'][$i];
			
			//no publicados
			echo '<td align="center"><IMG SRC="'.JURI::base().'components/com_storepapers/images/publish_x.png"></td>';	
			echo '<td align="center">'.$this->vector['nopublicados'][$i].' '.JText::_('NO_PUBLICADAS').'</td>';
			$totalNoPublicados += $this->vector['nopublicados'][$i];	
			echo '</tr>';
		}
		echo '<tr>';
		echo '<td colspan="5" align="center"><H3>'.JText::_('TOTAL').'</H3></td>';
		echo '<td align="center"><H3>'.$totalPublicaciones.' '.JText::_('PUBLICACIONES').'</H3></td>';
		echo '<td align="center"><IMG SRC="'.JURI::base().'components/com_storepapers/images/publish_v.png"></td>';
		echo '<td align="center"><H3>'.$totalPublicados.' '.JText::_('PUBLICADAS').'</H3></td>';
		echo '<td align="center"><IMG SRC="'.JURI::base().'components/com_storepapers/images/publish_x.png"></td>';
		echo '<td align="center"><H3>'.$totalNoPublicados.' '.JText::_('NO_PUBLICADAS').'</H3></td>';
		echo '</tr>';
		?>
		<tfoot>
			<tr>
				<td colspan="10">
						<?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
				</td>
			</tr>
		</tfoot>
	</table>
	<p style="text-align: center;">StorePapers <?php echo JText::_('COMPONENTE_VERSION');?></p>

	<input type="hidden" name="option" 		id="option" value="com_storepapers" />
	<input type="hidden" name="view"   		id="view"   value="mostrarCategoria" />	
	<input type="hidden" name="task"   		id="task"   value="display" />
	<input type="hidden" name="boxchecked" 	id="boxchecked" value="0" />
</form>

<input id="mostrarCategoria" name="mostrarCategoria" value="<?php echo JURI::base();?>index.php?option=com_storepapers&view=mostrarCategoria" type="hidden" />
<input id="despublicar" name="despublicar" value="<?php echo JURI::base();?>index.php?option=com_storepapers&view=despublicar&idc=" type="hidden" />
<input id="publicar" name="publicar" value="<?php echo JURI::base();?>index.php?option=com_storepapers&view=publicar&idc=" type="hidden" />
<input id="seleccionaCategoria" name="seleccionaCategoria" value="<?php echo JText::_('SELECCIONA_CATEGORIA');?>" type="hidden" />
