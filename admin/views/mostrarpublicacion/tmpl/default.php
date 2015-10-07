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

<script>
	function filtrar(){	
		var url = 'index.php?option=' + document.getElementById('option').value + '&view=' + document.getElementById('view').value;			
		var url = url + '&ida=' + document.getElementById('ida').value + '&idc=' + document.getElementById('idc').value + '&year=' + document.getElementById('year').value;			
		document.location = url;		
	}	
</script>

<form name="adminForm" id="adminForm" action="index.php" method="post">
<?php 
//Esto es para redireccionar cuando ha encontrado una actualización
if($this->mensaje['update'] == 1)
	header('Location: '.JURI::base().'index.php?option=com_storepapers&view=update');
?>
<table border="0"  width="100%">
<tbody>	
	<tr>
		<td align="center">
			<table border="0" cellspacing="4" cellpadding="4">
				<tbody>
				<tr>	
					<td><?php echo JText::_('FILTRAR_AUTOR');?>: </td>
					<td><SELECT ID="ida" NAME="ida" SIZE="1" onchange="filtrar()">
						<OPTION VALUE="0"><?php echo JText::_('TODOS_AUTORES');?></OPTION>
						<OPTION DISABLED>---------------------------------------------------------</OPTION>
					<?php
						//Aqui voy mostrando los autores disponibles para realizar un filtro
						$o = count( $this->mensaje['nombreautores'] );
						for ($k=0; $k < $o; $k++){
							$row =& $this->mensaje['nombreautores'][$k];
							if($row->id == $this->mensaje['filtroidautor'])
								echo '<OPTION VALUE="'.$row->id.'" SELECTED>'.$row->nombre.'</OPTION>';
							else
								echo '<OPTION VALUE="'.$row->id.'">'.$row->nombre.'</OPTION>';
						}
					?>
					</SELECT></td>
					<td><?php echo JText::_('FILTRAR_CATEGORIA');?>: </td>
					<td><SELECT ID="idc" NAME="idc" SIZE="1" onchange="filtrar()">
						<OPTION VALUE="0"><?php echo JText::_('TODAS_CATEGORIAS');?></OPTION>
						<OPTION DISABLED>----------------------------------------------</OPTION>
					<?php
						//Aqui voy mostrando las categorias disponibles para realizar un filtro
						$o = count( $this->mensaje['categorias'] );
						for ($k=0; $k < $o; $k++){
							$row =& $this->mensaje['categorias'][$k];
							if($row->id == $this->mensaje['filtroidcategoria'])
								echo '<OPTION VALUE="'.$row->id.'" SELECTED>'.$row->nombre.'</OPTION>';
							else
								echo '<OPTION VALUE="'.$row->id.'">'.$row->nombre.'</OPTION>';
						}
					?>
					</SELECT></td>
					<td><?php echo JText::_('FILTRAR_AÑO');?>: </td>
					<td><SELECT ID="year" NAME="year" SIZE="1" onchange="filtrar()">
						<OPTION VALUE="all"><?php echo JText::_('TODOS_AÑOS');?></OPTION>
						<OPTION DISABLED>------------------------------</OPTION>
					<?php
						//Aqui voy mostrando los años disponibles para realizar un filtro
						$o = count( $this->mensaje['year'] );
						for ($k=0; $k < $o; $k++){
							$row =& $this->mensaje['year'][$k];
							if($row->year == $this->mensaje['filtroyear'])
								echo '<OPTION VALUE="'.$row->year.'" SELECTED>'.$row->year.'</OPTION>';
							else
								echo '<OPTION VALUE="'.$row->year.'">'.$row->year.'</OPTION>';
						}
					?>
					</SELECT></td>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>
</tbody>
</table>
<?php
//Aqui voy mostrando todas las categorias que se encuentran en BD
	
	echo '<table class="table table-striped">';
	echo '<thead>';
	echo '<tr>';
	echo '<th align="center" width="5"><h4>#</h4></th>';
	echo '<th align="center" width="5"><h4>ID</h4></th>';
	echo '<th align="center" width="8"><input type="checkbox" name="checkall-toggle" value="" title="'.JText::_('JGLOBAL_CHECK_ALL').'" onclick="Joomla.checkAll(this)" /></th>';
	echo '<th align="center"><h4>'.JText::_('NOMBRE_PUBLICACION').'</h4></th>';
	echo '<th align="center"><h4>'.JText::_('ESTADO').'</h4></th>';
	echo '<th align="center"><h4>'.JText::_('CATEGORIA').'</h4></th>';
	echo '<th align="center"><h4>'.JText::_('AUTORES').'</h4></th>';
	echo '<th align="center"><h4>'.JText::_('PRIORIDAD').'</h4></th>';
	echo '<th align="center"><h4>'.JText::_('FECHA').'</h4></th>';
	echo '</tr>';
	echo '</thead>';

	//Aqui voy mostrando todas las publicaciones que se encuentran en BD
	$n = count( $this->mensaje['publicaciones'] );
	$w = count( $this->mensaje['categorias'] );
	for ($i = 0; $i < $n; $i++){
		$row  =& $this->mensaje['publicaciones'][$i];		
		$link = 'index.php?option=com_storepapers&view=editarPublicacion&idp='.$row->id.'&ida='.$this->mensaje['filtroidautor'].'&idc='.$this->mensaje['filtroidcategoria'].'&year='.$this->mensaje['filtroyear'];
		
		if ($i % 2 == 0)
			echo '<tr class="row0">';
		else
			echo '<tr class="row1">';
			
		echo '<td align="center">'.($i + 1).'</td><td align="center">'.$row->id.'</td>';
		//echo '<td align="center"><INPUT TYPE="RADIO" NAME="publicacion" VALUE="'.$row->id.'"></td>';
		echo '<td align="center">'.JHtml::_('grid.id', $i, $row->id).'</td>';
		echo '<td align="center"><b><a href="'.JURI::base().$link.'">'.$row->nombre.'</a></b></td>';
		
		//Muestro el estado de la publicación		
		echo '<td align="center">'.JHtml::_('jgrid.published', $row->published, $i).'</td>';
		
		$seHaMostradoCategoria = 0;
		for ($p=0; $p < $w; $p++){
			if($row->idc == $this->mensaje['categorias'][$p]->id){
				echo '<td align="center">'.($this->mensaje['categorias'][$p]->nombre).'</td>';				
				$seHaMostradoCategoria = 1;
			}
		}
		//Compruebo que por cada publicación se haya escrito la categoria a la que pertenece
		if($seHaMostradoCategoria != 1){
			echo '<td align="center">Sin categoría</td>';
		}
		//echo '<td align="center">'.$row->idc.'</td>';
				
		//Aqui voy mostrando todas los autores que se encuentra en cada publicación, tambien se muestra la prioridad de la publicación
		echo '<td align="center">';
		$m = count( $this->mensaje['autores'][$i] );	
		for ($j=0; $j < $m; $j++){
			$rowAutores =& $this->mensaje['autores'][$i][$j];
			echo $rowAutores->nombre.'<br/>';
		}
		echo '</td>';
		echo '<td align="center">';
		for ($j=0; $j < $m; $j++){
			$rowAutores =& $this->mensaje['autores'][$i][$j];
			echo $rowAutores->prioridad.'<br/>';
		}
		echo '</td>';
		//Muestro la fecha de la publicación
		echo '<td align="center">'.$row->year.', ';    
		echo strftime("%B", mktime(0, 0, 0, $row->month, 1, 2000) );
		echo '</td></tr>';
	}
	//Esto lo utilizo para marcar las casillas de validación
	echo '<input id="max" name="max" value="'.($i - 1).'" type="hidden" />';
	?>
	<tfoot>		
		<tr>
			<td colspan="9">
				<?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
			</td>
		</tr>
	</tfoot>
	</table>
	
	<p style="text-align: center;">StorePapers <?php echo JText::_('COMPONENTE_VERSION');?></p>
	<input type="hidden" name="option" 		id="option" 	value="com_storepapers" />
	<input type="hidden" name="view"   		id="view"   	value="mostrarPublicacion" />
	<input type="hidden" name="task"   		id="task"   	value="display" />
	<input type="hidden" name="boxchecked" 	id="boxchecked" value="0" />
	
	<!-- Esto es por la paginación -->
	<input type="hidden" name="idc" 		id="idc" 		value="<?php echo $this->mensaje['filtroidcategoria'];?>" />
	<input type="hidden" name="ida" 		id="ida" 		value="<?php echo $this->mensaje['filtroidautor'];?>" />
	<input type="hidden" name="year" 		id="year" 		value="<?php echo $this->mensaje['filtroyear'];?>" />
</form>