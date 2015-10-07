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

	<div class="form-inline form-inline-header">
		<div class="control-group">
			<div class="control-label">	
				<label id="jform_title-lbl" title="" for="jform_title"><?php echo JText::_('NOMBRE');?></label>
			</div>
			<div class="controls">
				<input id="jform_title" DISABLED class="input-xxlarge input-large-text required" type="text" MAXLENGTH="250" size="60" value="<?php echo $this->data['publicacion'][0]->nombre ?>" name="nombre" aria-required="true" required="required">
			</div>
		</div>
	</div>
	<div class="form-inline form-inline-header">
		<div class="control-group">
			<div class="control-label">	
				<label id="jform_title-lbl" title="" for="jform_title"><?php echo JText::_('COM_STOREPAPERS_CONFIRMAR_BORRAR_PUBLICACION');?></label>
			</div>
			<div class="controls">
				<?php echo JHtml::_('grid.id', 0, $this->data['publicacion'][0]->id)?>
			</div>
		</div>
	</div>

	<?php
	//http://joomla.stackexchange.com/questions/5593/how-can-i-use-jhtml-to-create-vertical-tabs
	$options = array(
		'useCookie' => true,
		'active' => 'tabs_1'
	);

	// Start Tabs
	echo '<div class="tabbable tabs" style="margin-top:30px;">';
	echo JHtml::_('bootstrap.startTabSet', 'tab_group_id', $options);

	// Tab 1
	echo JHtml::_('bootstrap.addTab', 'tab_group_id', 'tabs_1', JText::_('PESTANA_PUBLICACION'));
	?>
	
	<div class="row-fluid">
		<div class="span9">
			<?php echo '<TEXTAREA DISABLED NAME="texto" ROWS=10 COLS=100%>'.$this->data['publicacion'][0]->texto.'</TEXTAREA>';?>
		</div>
		<div class="span3">
			<div class="control-group">
				<div class="control-label">	
					<label id="jform_state-lbl" title="" for="jform_state"><?php echo JText::_('AÑO_PUBLICACION');?></label>
				</div>
				<div class="controls">
					<select id="jform_state" DISABLED class="inputbox" size="1" name="year">
						<?php
						echo '<OPTION VALUE="'.$this->data['publicacion'][0]->year.'" SELECTED>'.$this->data['publicacion'][0]->year.'</OPTION>';			
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">	
					<label id="jform_state-lbl" title="" for="jform_state"><?php echo JText::_('MES_PUBLICACION');?></label>
				</div>
				<div class="controls">
					<select id="jform_state" DISABLED class="inputbox" size="1" name="month">
						<?php
						echo '<OPTION VALUE="'.$this->data['publicacion'][0]->month.'" SELECTED>'.strftime("%B", mktime(0, 0, 0, $this->data['publicacion'][0]->month, 1, 2000) ).'</OPTION>';
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">	
					<label id="jform_state-lbl" title="" for="jform_state"><?php echo JText::_('CATEGORIAS');?></label>
				</div>
				<div class="controls">
					<select id="jform_state" DISABLED class="inputbox" size="1" name="idc">
						<?php
						echo '<OPTION VALUE="'.$this->data['categoria'][0]->id.'" SELECTED>'.$this->data['categoria'][0]->nombre.'</OPTION>';
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">	
					<label id="jform_state-lbl" title="" for="jform_state"><?php echo JText::_('PUBLICAR');?></label>
				</div>
				<div class="controls">
					<select id="jform_state" DISABLED class="inputbox" size="1" name="published">
						<?php
						if($this->data['publicacion'][0]->published == '1'){
							echo '<OPTION VALUE="1" SELECTED>Publicado</OPTION>';
							echo '<OPTION VALUE="0">No publicado</OPTION>';
						}
						else{
							echo '<OPTION VALUE="1">Publicado</OPTION>';
							echo '<OPTION VALUE="0" SELECTED>No publicado</OPTION>';
						}			
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">	
					<label id="jform_id-lbl" title="" for="jform_id">ID</label>
				</div>
				<div class="controls">
					<input id="jform_id" class="readonly" type="text" readonly="readonly" size="10" value="<?php echo $this->data['idp'];?>" name="idp">
				</div>
			</div>
		</div>
	</div>
	
	<?php 
	echo JHtml::_('bootstrap.endTab');

	// Tab 2
	echo JHtml::_('bootstrap.addTab', 'tab_group_id', 'tabs_2', JText::_('PESTANA_AUTORES_DIRECTORES'));
	?>	
	
	<table border="0" cellspacing="0" cellpadding="0" align ="center">
	<tbody>
	<tr>
		<td>
			<table border="0" cellspacing="4" cellpadding="4" align ="center">
			<tbody>
				<tr>				
					<td valign="top">
					<?php				
					//Autores o directores de PFC
					$n = count( $this->data['autores'] );
					$m = count( $this->data['autoresPublicacion'] );
					if($m > 0){
						echo '<h4>'.JText::_('AUTORES_DIRECTORES').'</h4>';
						echo '<p>'.JText::_('SELECCIONAR_VARIOS_AUTORES_BORRAR').'</p>';				
						//Pongo los corchetes al final de listaAutores para indicarle que se trata de un array
						echo '<SELECT DISABLED NAME="listaAutores[]" SIZE='.$m.' MULTIPLE>';
						for ($i=0; $i < $n; $i++){
							$row =& $this->data['autores'][$i];					
							$enc = 0;
							for ($j=0; $j < $m; $j++){
								$rowAP =& $this->data['autoresPublicacion'][$j];
								if($row->id == $rowAP->ida)									
									$enc = 1;						
							}
							if($enc == 1)
								echo '<OPTION VALUE="'.$row->id.'" SELECTED>'.$row->nombre.'</OPTION>';									
						}
						echo '</SELECT>';
					}		
					?>
					<td valign="top">
					<table border="0" cellspacing="0" cellpadding="0" align ="center">
						<tbody>
							<?php
							//Prioridad Autores
							$n = count( $this->data['autores'] );
							$m = count( $this->data['autoresPublicacion'] );
							if($m > 0){
								echo '<h4>'.JText::_('PRIORIDAD_PUBLICACION').'</h4>';
								echo '<p>'.JText::_('AUTORES_SELECCIONA_PRIORIDAD').'</p>';
								for ($i=0; $i < $n; $i++){
									$row =& $this->data['autores'][$i];
									$enc = 0;
									for ($j=0; $j < $m; $j++){
										$rowAP =& $this->data['autoresPublicacion'][$j];
										if($row->id == $rowAP->ida){
											$prioridad = $rowAP->prioridad;
											$enc = 1;
										}
									}					
									if($enc == 1)
										echo '<tr><td>'.$row->nombre.'</td><td><INPUT TYPE="TEXT" NAME="prioridad_id'.$row->id.'" MAXLENGTH=3 SIZE="3" VALUE="'.$prioridad.'" DISABLED>';
								}
							}						
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
	
	<?php 
	// End Tabs
	echo JHtml::_('bootstrap.endTab');
	echo JHtml::_('bootstrap.endTabSet');
	echo '</div>';
	?>
	<p style="text-align: center;">StorePapers <?php echo JText::_('COMPONENTE_VERSION');?></p>

	<input type="hidden" name="option" 		id="option" 	value="com_storepapers" />
	<input type="hidden" name="view"   		id="view"   	value="borrarPublicacion" />
	<input type="hidden" name="task"   		id="task"   	value="display" />	
	<input type="hidden" name="id"			id="id"			value="<?php echo $this->data['idp'];?>" />
	<input type="hidden" name="boxchecked" 	id="boxchecked" value="0" />

	<!-- Esto es por la paginación -->
	<input type="hidden" name="idapag"			id="idapag"		value="<?php echo $this->data['ida'];?>" />	
	<input type="hidden" name="idcpag"			id="idcpag"		value="<?php echo $this->data['idc'];?>" />	
	<input type="hidden" name="yearpag"			id="yearpag"	value="<?php echo $this->data['year'];?>" />	
</form>
