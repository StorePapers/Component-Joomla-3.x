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
		var url = url + '&idc=' + document.getElementById('idc').value;			
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
			<td><h1 align="center"><?php echo $this->data['categoriaFiltrada'][0]->nombre;?></h1></td>
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
				<table border="0" cellspacing="10" cellpadding="4" align ="right">
				<tbody>
				<tr>	
					<td align ="center">
					<strong><?php echo JText::_('TODAS_PUBLICACIONES_ORDENADAS_AÑO');?></strong>
					<table class="table table-striped">
						<tbody>
							<thead>
								<tr>						
									<th><h4><?php echo JText::_('AÑO');?></h4></th>
									<th><h4><?php echo JText::_('TOTAL_PUBLICACIONES');?></h4></th>
								</tr>
							</thead>
							<?php
							$totalP = 0;
							$n = count( $this->data['numPubTotal'] );
							for ($i=0; $i < $n; $i++){
								$row =& $this->data['numPubTotal'][$i];
								if ($i % 2 == 0)
									echo '<tr class="row0">';
								else
									echo '<tr class="row1">';
								echo '<td align="center">'.$row->year.'</td><td align="center">'.$row->total.'</td></tr>';
								$totalP += $row->total;
							}
							echo '<td align="center"><h3>'.JText::_('TOTAL').'</h3></td><td align="center"><h3>'.$totalP.' '.JText::_('PUBLICACIONES').'</h3></td></tr>';
							?>
						</tbody>
					</table>					
					</td>
					<td><strong><?php echo JText::_('PUBLICACIONES_CATEGORIA');?> </strong>
					<SELECT ID="idc" NAME="idc" SIZE="1" onchange="filtrar()">					
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
									<th><h4><?php echo JText::_('AÑO');?></h4></th>
									<th><h4><?php echo JText::_('TOTAL_PUBLICACIONES').' '.JText::_('EN').' '.$this->data['categoriaFiltrada'][0]->nombre;?></h4></th>
								</tr>
							</thead>
							<?php
							$m = count( $this->data['numPubTotal'] );
							$n = count( $this->data['numPubFiltro'] );
							$totalA = 0;
							$j=0;					
							if($n > 0){
								$row =& $this->data['numPubFiltro'][$j];
								for ($i=0; $i < $m; $i +=1){
									$rowTotal =& $this->data['numPubTotal'][$i];
									if ($i % 2 == 0)
										echo '<tr class="row0">';
									else
										echo '<tr class="row1">';
									if($row->year == $rowTotal->year){
										echo '<td align="center">'.$row->year.'</td><td align="center">'.$row->total.'</td></tr>';
										$j +=1;
										$totalA += $row->total;
										if($j < $n)
											$row =& $this->data['numPubFiltro'][$j];
									}
									else
										echo '<td align="center">'.$rowTotal->year.'</td><td align="center">'.JText::_('NINGUNA_PUBLICACION').'</td></tr>';							
								}
								$porcentaje = ($totalA / $totalP) * 100;
								printf( '<td align="center"><h3>'.JText::_('TOTAL').'</h3></td><td align="center"><h3>'.JText::_('LACATEGORIA').' '.$this->data['categoriaFiltrada'][0]->nombre.' '.JText::_('CONTIENE').' '.$totalA.' '.JText::_('PUBLICACIONES').', %.2f%%</h3></td></tr>', $porcentaje);
							}
							else
								echo '<tr><td align="center" colspan="4">'.JText::_('NO_HAY_PUBLICACIONES_EN_CATEGORIA').'</td></tr>';
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
	<input type="hidden" name="view"   		id="view"   value="mostrarEstadisticasCategoria" />	
	<input type="hidden" name="task"   		id="task"   value="display" />
</form>
