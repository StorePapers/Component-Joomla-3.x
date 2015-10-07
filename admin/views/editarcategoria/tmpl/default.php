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

<form name="adminForm" id="adminForm" class="form-validate" method="post">
	<div class="control-group">
		<div class="control-label">	
			<label id="jform_title-lbl" title="" for="jform_title"><?php echo JText::_('ESCRIBIR_AQUI_NUEVA_CATEGORIA');?></label>
		</div>
		<div class="controls">
			<input id="jform_title" class="inputbox required" type="text" MAXLENGTH="250" size="60" value="<?php echo $this->data['categoria'][0]->nombre;?>" name="nombre" aria-required="true" required="required">
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">	
			<label id="jform_state-lbl" title="" for="jform_state"><?php echo JText::_('COM_STOREPAPERS_NOMBRE_CONSULTABLE');?></label>
		</div>
		<div class="controls">
			<select id="jform_state" class="inputbox" size="1" name="consultable">
			<?php
			if($this->data['categoria'][0]->consultable == '1'){
				echo '<OPTION VALUE="1" SELECTED>'.JText::_('COM_STOREPAPERS_SI').'</OPTION>';
				echo '<OPTION VALUE="0">'.JText::_('COM_STOREPAPERS_NO').'</OPTION>';
			}
			else{
				echo '<OPTION VALUE="1">'.JText::_('COM_STOREPAPERS_SI').'</OPTION>';
				echo '<OPTION VALUE="0" SELECTED>'.JText::_('COM_STOREPAPERS_NO').'</OPTION>';
			}?>
		</select>
		</div>
	</div>
	<p style="text-align: center;">StorePapers <?php echo JText::_('COMPONENTE_VERSION');?></p>

	<input type="hidden" name="option" 		id="option" value="com_storepapers" />
	<input type="hidden" name="view"   		id="view"   value="insertarNuevaCategoria" />	
	<input type="hidden" name="task"   		id="task"   value="display" />
	<input type="hidden" name="id" 			id="id"		value="<?php echo $this->data['categoria'][0]->id;?>" />
</form>
