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
		var url = 'index.php?option=com_storepapers&view=' + document.getElementById('view').value;	
		var url = url + '&ida=' + document.getElementById('ida').value + '&idc=' + document.getElementById('idc').value;			
		document.location = url;		
	}	
</script>

<form name="adminForm" id="adminForm" action="index.php" method="post">
<table border="0" cellspacing="0" cellpadding="0" align ="center">
<tbody>
<tr>
	<td align="left">
		<table border="0">
			<tbody>
			<tr align="center">
			<td><h1 align="center"><?php echo $this->data['autorFiltrado'][0]->nombre;?></h1></td>
			</tr>
			</tbody>
		</table>
	</td>
</tr>
<tr>
	<td>
		<table border="0" cellspacing="4" cellpadding="4" align ="center">
		<tbody>
			<tr>
				<td>
					<?php									
					if($this->data['idc'] == 0)
						echo '<strong>'.JText::_('SI_DESEAS_VER_TODAS_PUBLICACIONES').'</strong>';
					else
						echo '<strong>'.JText::_('SI_DESEAS_VER_PUBLICACIONES_CATEGORIA_1').' "'.$this->data['categoriaFiltrada'][0]->nombre.'" '.JText::_('SI_DESEAS_VER_PUBLICACIONES_CATEGORIA_2').'</strong>';
					echo '<strong> <a href='.JURI::base().'index.php?option=com_storepapers&view=mostrarPublicacion&ida='.$this->data['ida'].'&idc='.$this->data['idc'].'&year=all>'.JText::_('AQUI').'</a></strong>';
					?>
				</td>
			</tr>
			<tr>		
				<td>
				<table border="0" cellspacing="10" cellpadding="4" align ="right">
				<tbody>				
				<tr>					
					<td align ="center">
					<strong><?php echo JText::_('TODAS_PUBLICACIONES_ORDENADAS_AÑO');?></strong>
					<table class="table table-striped">
					<tbody>
					<thead>
					<tr>						
						<?php
						echo '<th><h4>'.JText::_('AÑO').'</h4></th>';						
						if($this->data['idc'] == 0)
							echo '<th><h4>'.JText::_('TOTAL_PUBLICACIONES').'</h4></th>';
						else
							echo '<th><h4>'.JText::_('TOTAL').' '.$this->data['categoriaFiltrada'][0]->nombre.'</h4></th>';
						?>
					</tr>
					</thead>
					<?php					
					$n = count( $this->data['numPubTotal'] );
						
					$totalP = 0;
					
					for ($i=0; $i < $n; $i++){
							
						$row =& $this->data['numPubTotal'][$i];
							
						if ($i % 2 == 0)
							echo '<tr class="row0">';
						else
							echo '<tr class="row1">';
							
						echo '<td align="center">'.$row->year.'</td><td align="center">'.$row->total.'</td></tr>';
						$totalP += $row->total;
					}
					if($this->data['idc'] == 0)
						echo '<td align="center"><h3>'.JText::_('TOTAL').'</h3></td><td align="center"><h3>'.$totalP.' '.JText::_('PUBLICACIONES').'</h3></td></tr>';
					else
						echo '<td align="center"><h3>'.JText::_('TOTAL').'</h3></td><td align="center"><h3>'.$totalP.' '.$this->data['categoriaFiltrada'][0]->nombre.'</h3></td></tr>';
					?>
					</tbody>
					</table>					
					</td>
					<td><strong><?php echo JText::_('PUBLICACIONES_AUTOR');?> </strong>
					<SELECT ID="ida" NAME="ida" SIZE="1" onchange="filtrar()">					
					<?php
						//Aqui voy mostrando los autores disponibles para realizar un filtro
						$o = count( $this->data['autores'] );
						for ($k=0; $k < $o; $k++){
							$row =& $this->data['autores'][$k];
							if($row->id == $this->data['ida'])
								echo '<OPTION VALUE="'.$row->id.'" SELECTED>'.$row->nombre.'</OPTION>';
							else
								echo '<OPTION VALUE="'.$row->id.'">'.$row->nombre.'</OPTION>';
						}
					?>
					</SELECT>
					<strong><?php echo JText::_('FILTRAR_CATEGORIA');?> </strong>
					<SELECT ID="idc" NAME="idc" SIZE="1" onchange="filtrar()">
					<OPTION VALUE="0"><?php echo JText::_('TODAS_CATEGORIAS');?></OPTION>
					<OPTION DISABLED>----------------------------------------------</OPTION>					
					<?php
						//Aqui voy mostrando las categorias disponibles para realizar un filtro
						$o = count( $this->data['categorias'] );
						for ($k=0; $k < $o; $k++){
							$row =& $this->data['categorias'][$k];
							if($row->id == $this->data['idc'])
								echo '<OPTION VALUE="'.$row->id.'" SELECTED>'.$row->nombre.'</OPTION>';
							else
								echo '<OPTION VALUE="'.$row->id.'">'.$row->nombre.'</OPTION>';
						}
					?>
					</SELECT>
					<table class="table table-striped">
					<tbody>
					<thead>
					<tr>						
						<?php
						echo '<th><h4>'.JText::_('AÑO').'</h4></th>';						
						if($this->data['idc'] == 0)
							echo '<th><h4>'.JText::_('TOTAL_PUBLICACIONES').' '.JText::_('DE').' '.$this->data['autorFiltrado'][0]->nombre.'</h4></th>';
						else
							echo '<th><h4>'.$this->data['categoriaFiltrada'][0]->nombre.' / '.JText::_('TOTAL').' '.JText::_('DE').' '.$this->data['autorFiltrado'][0]->nombre.'</h4></th>';
						?>
					</tr>
					</thead>
					<?php					
					$totalA = 0;
					$inc    = 0;
					if(count( $this->data['numPubTotalParcialAutor'] ) > 0){						
						//Caso especial						
						if($this->data['idc'] != 0){
							$enc = 0;							
							$m = count( $this->data['numPubTotalParcialAutor'] );							
							while(($inc < $m) && ($enc == 0)){
							
								if($this->data['numPubTotalParcialAutor'][$inc]['year'] == $this->data['numPubFiltroAutorCategoria'][0]['year'])
									$enc = 1;
								else
									$inc += 1;
							}
							if($enc == 0)
								$inc = 0;
							//else		//Depuración								
								 //echo 'Ha sido encontrado, el incremento es: '.$inc;
						}						
						//Fin
						$m = count( $this->data['numPubTotal'] );
						for ($mi = 0; $mi < $m; $mi += 1){
							
							if ($mi % 2 == 0)
								echo '<tr class="row0">';
							else
								echo '<tr class="row1">';	
								
							$rowPA =& $this->data['numPubTotalParcialAutor'][$mi + $inc];
							$rowTotal =& $this->data['numPubTotal'][$mi];							
							
							if($rowPA['year'] == $rowTotal->year){								
								
								if($this->data['idc'] == 0){
									$totalA += $rowPA['total'];
									echo '<td align="center">'.$rowPA['year'].'</td><td align="center">'.$rowPA['total'].'</td></tr>';
								}
								else{
									$rowPAC =& $this->data['numPubFiltroAutorCategoria'][$mi];
									
								$totalA += $rowPAC['total'];										
								if($rowPA['total'] == 0)
									$porcentaje = 0;
								else
									$porcentaje = ($rowPAC['total'] / $rowPA['total']) * 100;									
								printf( '<td align="center">%d</td><td align="center"><b>%d '.JText::_('DE').' %d,</b> %.2f%%</td></tr>', $rowPAC['year'], $rowPAC['total'], $rowPA['total'], $porcentaje);																		
								}															
							}
							else
								echo '<td align="center">'.$rowTotal->year.'</td><td align="center">'.JText::_('NINGUNA_PUBLICACION').'</td></tr>';							
						}
						$porcentaje = ($totalA / $totalP) * 100;						
						if($this->data['idc'] == 0)
							printf( '<td align="center"><h3>'.JText::_('TOTAL').'</h3></td><td align="center"><h3>'.JText::_('HA_PARTICIPADO_EN').' %d '.JText::_('PUBLICACIONES').', %.2f%%</h3></td></tr>', $totalA, $porcentaje);
						else
							printf( '<td align="center"><h3>'.JText::_('TOTAL').'</h3></td><td align="center"><h3>'.JText::_('HA_PARTICIPADO_EN').' %d '.$this->data['categoriaFiltrada'][0]->nombre.', %.2f%%</h3></td></tr>', $totalA, $porcentaje);
					}
					else
						echo '<tr><td align="center" colspan="2">'.JText::_('NO_HAY_PUBLICACIONES_EN_CATEGORIA').'</td></tr>';
					?>					
					</tbody>
					</table>					
					</td>
				</tr>
				</tbody>
				</table>
				</td>
			</tr>
		</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>
	<input type="hidden" name="option" 		id="option" value="com_storepapers" />
	<input type="hidden" name="view"   		id="view"   value="mostrarEstadisticasAutor" />	
	<input type="hidden" name="task"   		id="task"   value="display" />
</form>
