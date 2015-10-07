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
<?php 
//Esto es para redireccionar cuando ha encontrado una actualización
if($this->mensaje['update'] == 1)
	header('Location: '.JURI::base().'index.php?option=com_storepapers&view=update');
?>

<form name="adminForm" id="adminForm" action="index.php" method="post">
	<table class="table table-striped">
	<thead>
	<tr>
		<th align="center" width="5"><h4>#</h4></th>
		<th width="8"><h4>ID</h4></th>
		<th align="center" width="8">
				<!-- <input TYPE="RADIO" NAME="autor" VALUE="-1" CHECKED> -->				
				<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
		</th>
		<th><h4><?php echo JText::_('NOMBRE_AUTOR');?></h4></th>
		<th><h4><?php echo JText::_('COM_STOREPAPERS_NOMBRE_CONSULTABLE');?></h4></th>
		<th><h4><?php echo JText::_('PUBLICACIONES_AUTOR_ORDENADAS_CATEGORIA');?></h4></th>
		<th colspan="4" style="text-align: center;"><h4><?php echo JText::_('ESTADO');?></h4></th>
	</tr>
	</thead>
	<?php
	$n = count( $this->mensaje['autores'] );
	for ($i=0; $i < $n; $i++){
		$rowAutores =& $this->mensaje['autores'][$i];	
		$link = 'index.php?option=com_storepapers&view=editarAutor&ida='. $rowAutores->id;
		
		if ($i % 2 == 0)
			echo '<tr class="row0">';
		else
			echo '<tr class="row1">';
		echo '<td align="center">'.($i + 1).'</td><td align="center">'.$rowAutores->id.'</td>';	
		
		//echo '<td align="center"><INPUT TYPE="RADIO" NAME="autor" VALUE="'.$rowAutores->id.'"></td>';	
		echo '<td align="center">'.JHtml::_('grid.id', $i, $rowAutores->id).'</td>';	
		echo '<td align="center"><b><a href="'.JURI::base().$link.'">'.$rowAutores->nombre.'</a></b></td>';
		
		if($rowAutores->consultable == '1')
			echo '<td align="center">'.JText::_('COM_STOREPAPERS_SI').'</td>';			
		else
			echo '<td align="center">'.JText::_('COM_STOREPAPERS_NO').'</td>';
		
		//Muestro las categorias
		echo '<td align="center">';
		$sumPub = 0;
		$m = count( $this->mensaje['categorias'] );
		for ($j=0; $j < $m; $j++){
			$rowCategorias =& $this->mensaje['categorias'][$j];
			
			if($this->mensaje['totales'][$i][$j][0]->total > 0){
				$link = 'index.php?option=com_storepapers&view=mostrarPublicacion&ida='. $rowAutores->id.'&idc='.$rowCategorias->id.'&year=all';
				echo '<b>'.$this->mensaje['totales'][$i][$j][0]->total.'</b> '.JText::_('PUBLICACIONES').' '.JText::_('EN').' <a href="'.JURI::base().$link.'">'.$rowCategorias->nombre.'</a><br>';
				$sumPub += $this->mensaje['totales'][$i][$j][0]->total;
			}
		}
		if($sumPub == 0)
			echo ''.JText::_('NINGUNA_PUBLICACION').'</td>';
		else
			echo '<br>'.JText::_('TOTAL').' '.JText::_('PUBLICACIONES').': <b>'.$sumPub.'</b></td>';
		echo '</td>';
		
		//Muestro el estado de las publicaciones publicadas
		echo '<td align="center"><IMG SRC="'.JURI::base().'components/com_storepapers/images/publish_v.png"></td><td align="center">';
		$sumPub = 0;
		$m = count( $this->mensaje['categorias'] );
		for ($j=0; $j < $m; $j++){
			$rowCategorias =& $this->mensaje['categorias'][$j];
			
			if($this->mensaje['totales'][$i][$j][0]->total > 0){
				//echo $rowCategorias->nombre.': <b>'.$this->mensaje['totales'][$i][$j]['publicados'][0]->total.'</b> '.JText::_('PUBLICADAS').'<br>';
				echo '<b>'.$this->mensaje['totales'][$i][$j]['publicados'][0]->total.'</b> '.JText::_('PUBLICADAS').' '.JText::_('EN').' <b>'.$rowCategorias->nombre.'</b><br>';
				$sumPub += $this->mensaje['totales'][$i][$j]['publicados'][0]->total;
			}
		}
		if($sumPub == 0)
			echo '<br>'.JText::_('NINGUNA_PUBLICADA').'</td>';
		else
			echo '<br>'.JText::_('TOTAL').': <b>'.$sumPub.'</b> '.JText::_('PUBLICADAS').'</td>';
		echo '</td>';
		
		//Muestro el estado de las publicaciones NO publicadas
		echo '<td align="center"><IMG SRC="'.JURI::base().'components/com_storepapers/images/publish_x.png"></td><td align="center">';
		$sumPub = 0;
		$m = count( $this->mensaje['categorias'] );
		for ($j=0; $j < $m; $j++){
			$rowCategorias =& $this->mensaje['categorias'][$j];
			
			if($this->mensaje['totales'][$i][$j][0]->total > 0){
				//echo $rowCategorias->nombre.': <b>'.$this->mensaje['totales'][$i][$j]['noPublicados'][0]->total.'</b> '.JText::_('NO_PUBLICADAS').'<br>';
				echo '<b>'.$this->mensaje['totales'][$i][$j]['noPublicados'][0]->total.'</b> '.JText::_('NO_PUBLICADAS').' '.JText::_('EN').' <b>'.$rowCategorias->nombre.'</b><br>';
				$sumPub += $this->mensaje['totales'][$i][$j]['noPublicados'][0]->total;
			}
		}
		if($sumPub == 0)
			echo '<br>'.JText::_('NINGUNA_NO_PUBLICADA').'</td>';
		else
			echo '<br>'.JText::_('TOTAL').': <b>'.$sumPub.'</b> '.JText::_('NO_PUBLICADAS').'</td>';
		echo '</td></tr>';
	}
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
	<input type="hidden" name="option" 		id="option" 	value="com_storepapers" />
	<input type="hidden" name="view"   		id="view"   	value="mostrarAutor" />
	<input type="hidden" name="task"   		id="task"   	value="display" />
	<input type="hidden" name="boxchecked" 	id="boxchecked" value="0" />	
</form>
