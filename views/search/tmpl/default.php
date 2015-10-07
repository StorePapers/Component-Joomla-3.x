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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h1><?php echo JText::_('COM_STOREPAPERS_TITULO'); ?></h1>

<form id="storepapersForm" action="<?php echo JRoute::_('index.php?option=com_storepapers');?>" method="post">	
	<fieldset class="storepapers-search">
	<legend><?php echo JText::_('COM_STOREPAPERS_BUSCAR');?></legend>
		<div style="min-height:37px;">
			<div class="width-label fltlft">
				<label ID="year"><?php echo JText::_('COM_STOREPAPERS_FILTRAR_AÑO');?>: </label>
			</div>
			<div class="width-input fltrt">
				<SELECT ID="year" NAME="year" SIZE="1">
					<OPTION VALUE="all"><?php echo JText::_('COM_STOREPAPERS_TODOS_AÑOS');?></OPTION>
					<OPTION DISABLED>---------------------------------------------------------</OPTION>
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
				</SELECT>
			</div>
		</div>
		<div style="min-height:37px;">
			<div class="width-label fltlft">
				<label ID="ida"><?php echo JText::_('COM_STOREPAPERS_FILTRAR_AUTOR');?>: </label>
			</div>
			<div class="width-input fltrt">
				<SELECT ID="ida" NAME="ida" SIZE="1">
					<OPTION VALUE="0"><?php echo JText::_('COM_STOREPAPERS_TODOS_AUTORES');?></OPTION>
					<OPTION DISABLED>---------------------------------------------------------</OPTION>
					<?php
						//Aqui voy mostrando los autores disponibles para realizar un filtro
						print_r($this->mensaje['nombreautores']);
						$o = count( $this->mensaje['nombreautores'] );
						for ($k=0; $k < $o; $k++){
							$row =& $this->mensaje['nombreautores'][$k];
							if($row->id == $this->mensaje['filtroidautor'])
								echo '<OPTION VALUE="'.$row->id.'" SELECTED>'.$row->nombre.'</OPTION>';
							else
								echo '<OPTION VALUE="'.$row->id.'">'.$row->nombre.'</OPTION>';
						}
					?>
				</SELECT>
			</div>
		</div>
		<div style="min-height:37px;">
			<div class="width-label fltlft">
				<label ID="idc"><?php echo JText::_('COM_STOREPAPERS_FILTRAR_CATEGORIA');?>: </label>
			</div>
			<div class="width-input fltrt">
				<SELECT ID="idc" NAME="idc" SIZE="1">
					<OPTION VALUE="0"><?php echo JText::_('COM_STOREPAPERS_TODAS_CATEGORIAS');?></OPTION>
					<OPTION DISABLED>---------------------------------------------------------</OPTION>
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
				</SELECT>
			</div>
		</div>
		<div class="width-boton fltlft">
			<button class="button" onclick="this.form.submit()" name="Search"><?php echo JText::_('COM_STOREPAPERS_BOTON_BUSCAR');?></button>		
		</div>		
		<input type="hidden" name="option" 		id="option" 	value="com_storepapers" />
		<input type="hidden" name="task" 		value="search" />
	</fieldset>
	<br/>
	<?php if ($this->mensaje['total'] != null) { ?>
		<?php if ($this->mensaje['total'] > 0){ ?>
			<strong><?php echo JText::sprintf('COM_STOREPAPERS_TOTAL_PUBLICACIONES', $this->mensaje['total']); ?></strong>
		<?php }else{ ?>
			<strong><?php echo JText::_('COM_STOREPAPERS_NO_PUBLICACIONES_ENCONTRADAS'); ?></strong>
		<?php } ?>
		<br/>
		<?php if (count( $this->mensaje['publicaciones'] ) > 0) { ?>
		<div class="form-limit">
			<label for="limit">
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
			</label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
		<?php } ?>
	<?php } ?>
</form>

<?php 		
	if($this->mensaje['mostrarResultados'] == true){
		$yearAnterior		= null;
		
		$z = count( $this->mensaje['anosPublications'] );
		for ($x = 0; $x < $z; $x++){
			$yearActual = $this->mensaje['anosPublications'][$x];
			
			if(($this->mensaje['params']->get('show_year')) && ($yearActual != $yearAnterior))
				echo "<h2 class=\"sp\">".$yearActual."</h2>";
			if($yearActual != $yearAnterior)
				$yearAnterior = $yearActual;
			
			$categoriaAnterior  = null;
		
			$w = count( $this->mensaje['publicaciones'][$yearActual] );
			for ($i = 0; $i < $w; $i++){
				//print_r($this->mensaje['publicaciones'][$yearActual]);
				$row  =& $this->mensaje['publicaciones'][$yearActual][$i];
				
				$categoriaActual = $row->nombreCategoria;
				
				if(($row->nombreCategoria != $categoriaAnterior) && ($this->mensaje['params']->get('show_name_categories'))){
					echo "<h2 class=\"sp\">".$row->nombreCategoria."</h2>";
					$categoriaAnterior = $row->nombreCategoria;
				}
				
				//print_r($row);
				if($row->published){
					$autores = "";
					if($this->mensaje['params']->get('show_name_authors')){
						//Escribo los autores, si hay
						$autores = "<b>";
						$rowAutores  =& $this->mensaje['autores'][$row->id];
						//print_r($rowAutores);
						$v = count( $rowAutores );
						for ($j = 0; $j < $v; $j++){
							$autores .= $rowAutores[$j];
							if($j == ($v - 2))
								$autores .= JText::_('COM_STOREPAPERS_Y');
							else{
								if($j != ($v - 1))
									$autores .= ", ";
							}
						}
						$autores = $autores."</b>";
					}
				
					$temp = "";
					echo "<div class=\"sp\">";
					if(stripos($row->texto, "<p>") !== false){
						$row->texto = substr($row->texto, stripos($row->texto,"<p>") + strlen("<p>"));
						$temp  = "<p>";
					}
					
					//Opciones para mostrar campos de la publicación
					//	Autores		Publicación		Año
					if(($this->mensaje['params']->get('show_name_authors')) && ($this->mensaje['params']->get('show_name_publication')) && ($this->mensaje['params']->get('show_year_publication')))
						$temp .= $autores." <em>(".$row->year.")</em><br/><b>".$row->nombre."</b><br/>";
					
					//	Autores		!Publicación	Año
					if(($this->mensaje['params']->get('show_name_authors')) && (!$this->mensaje['params']->get('show_name_publication')) && ($this->mensaje['params']->get('show_year_publication')))
						$temp .= $autores." <em>(".$row->year.")</em><br/>";
					//	Autores		Publicación		!Año
					if(($this->mensaje['params']->get('show_name_authors')) && ($this->mensaje['params']->get('show_name_publication')) && (!$this->mensaje['params']->get('show_year_publication')))
						$temp .= $autores."<br/><b>".$row->nombre."</b><br/>";
					//	Autores		!Publicación	!Año
					if(($this->mensaje['params']->get('show_name_authors')) && (!$this->mensaje['params']->get('show_name_publication')) && (!$this->mensaje['params']->get('show_year_publication')))
						$temp .= $autores."<br/>";
					
					//	!Autores	Publicación		Año
					if((!$this->mensaje['params']->get('show_name_authors')) && ($this->mensaje['params']->get('show_name_publication')) && ($this->mensaje['params']->get('show_year_publication')))
						$temp .= "<b>".$row->nombre."</b> <em>(".$row->year.")</em><br/>";					
					//	!Autores	!Publicación	Año
					if((!$this->mensaje['params']->get('show_name_authors')) && (!$this->mensaje['params']->get('show_name_publication')) && ($this->mensaje['params']->get('show_year_publication')))
						$temp .= "<em>(".$row->year.")</em><br/>";					
					//	!Autores	Publicación		!Año
					if((!$this->mensaje['params']->get('show_name_authors')) && ($this->mensaje['params']->get('show_name_publication')) && (!$this->mensaje['params']->get('show_year_publication')))
						$temp .= "<b>".$row->nombre."</b><br/>";
						
					if($this->mensaje['params']->get('show_text_publication'))
						$temp .= $row->texto;
				
					if(strripos($temp, "</p>") !== false){
						$temp = substr_replace($temp, "", strripos($temp,"</p>"));
						
						//Esto es para incluir un br si se ha escrito el texto
						if($this->mensaje['params']->get('show_text_publication'))
							$temp .= "<br/>";
						
						if($this->mensaje['params']->get('show_name_category'))
							$temp .= "<em>------------ ".$row->nombreCategoria." ------------</em>";
						
						$temp .= "</p>";
					}
					else{
						//Esto es para incluir un br si se ha escrito el texto
						if($this->mensaje['params']->get('show_text_publication'))
							$temp .= "<br/>";
					
						if($this->mensaje['params']->get('show_name_category'))
							$temp .= "<em>------------ ".$row->nombreCategoria." ------------</em>";
					}
					
					$row->texto = $temp;
					
					//Aquí se pasan los plugins de tipo contenido.
					echo JHtml::_('content.prepare', $row->texto);
					echo "</div>";
				}
				
			}
		}
	}
?>
<?php if($this->mensaje['total'] > 0) { ?>
	<div class="pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
<?php } ?>
