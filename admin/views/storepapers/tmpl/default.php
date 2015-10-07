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

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import html
JHtml::_('behavior.framework');
jimport ('joomla.html.html.bootstrap');

jimport('joomla.html.pane');
?>

<!-- Compruebo que no hay falta de actualizaciones -->
<form name="adminForm" id="adminForm" action="index.php" method="post">
<?php 
//Esto es para redireccionar cuando ha encontrado una actualización
if($this->data['update'] == 1)
	header('Location: '.JURI::base().'index.php?option=com_storepapers&view=update');
?>
<table width="100%">		
	<tr>
		<td>
			<div class="cpanel-left">
				<?php
				//http://joomla.stackexchange.com/questions/5593/how-can-i-use-jhtml-to-create-vertical-tabs
				$options = array(
					'useCookie' => true,
					'active' => 'tabs_1'
				);

				// Start Tabs
				echo '<div class="tabbable tabs">';
				echo JHtml::_('bootstrap.startTabSet', 'tab_group_id', $options);
				
				// Tab 1
				echo JHtml::_('bootstrap.addTab', 'tab_group_id', 'tabs_1', JText::_('COM_STOREPAPERS_PANEL_CONTROL_TAB_INICIO'));
				echo '<p align="justify">'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_1_1').' <IMG SRC="'.JURI::base().'components/com_storepapers/images/instalar.png"> '.JText::_('COM_STOREPAPERS_MANUAL_LINEA_1_2').' <IMG SRC="'.JURI::base().'components/com_storepapers/images/publish_v.png"> '.JText::_('COM_STOREPAPERS_MANUAL_LINEA_1_3').'</p>';
				echo '<p align="justify">'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_11_1').' '.JText::_('COM_STOREPAPERS_MANUAL_LINEA_11_2').'</p>';
				
				echo JHtml::_('bootstrap.endTab');
				
				// Tab 2
				echo JHtml::_('bootstrap.addTab', 'tab_group_id', 'tabs_2', JText::_('COM_STOREPAPERS_PANEL_CONTROL_TAB_CONSULTAS'));
				?>
				<p align="justify"><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_2_1');?></p>
				<ul>
					<li><p><b><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_3_CODIGO_1').'</b><br>'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_3_CODIGO_2');?></p></li>
					<li><p><b><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_4_CODIGO_1').'</b><br>'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_4_CODIGO_2');?></p></li>
					<li><p><b><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_5_CODIGO_1').'</b><br>'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_5_CODIGO_2');?></p></li>
					<li><p><b><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_6_CODIGO_1').'</b><br>'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_6_CODIGO_2');?></p></li>
					<li><p><b><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_7_CODIGO_1').'</b><br>'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_7_CODIGO_2');?></p></li>
					<li><p><b><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_12_CODIGO_1').'</b><br>'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_12_CODIGO_2');?></p></li>
					<li><p><b><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_13_CODIGO_1').'</b><br>'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_13_CODIGO_2');?></p></li>
					<li><p><b><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_14_CODIGO_1').'</b><br>'.JText::_('COM_STOREPAPERS_MANUAL_LINEA_14_CODIGO_2');?></p></li>
				</ul>				
				<?php 
				echo JHtml::_('bootstrap.endTab');
				
				// Tab 3
				echo JHtml::_('bootstrap.addTab', 'tab_group_id', 'tabs_3', JText::_('COM_STOREPAPERS_PANEL_CONTROL_TAB_OPCIONES'));
				?>
				<p align="justify"><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_8')?></p>
				<p align="justify"><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_9_OPCION_1');?></p>
				<p align="justify"><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_10_OPCION_1');?></p>
				<p align="justify"><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_15_OPCION_2');?></p>
				<p align="justify"><?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_16_OPCION_2');?></p>
				<?php
				// End Tabs
				echo JHtml::_('bootstrap.endTab');
				echo JHtml::_('bootstrap.endTabSet');
				echo '</div>';
				?>
			</div>
		</td>
	</tr>
	<tr>
		<td>			
		<fieldset class="cpanel">
		<legend><?php echo JText::_('CREDITOS');?></legend>
			<table width="100%">
				<tr>
					<td align="center"><IMG SRC="<?php echo JURI::base().'components/com_storepapers/images/creditos.png';?>"></td>
					<td valign="top">
						<?php echo JText::_('CREDITOS_DESARROLLO').'<br/>'.JText::_('CORREO').': '.JText::_('CORREO_PARA');?><br/>
						<a href="http://storepapers.quepuedohacerhoy.com/" target="_blank"><IMG SRC="<?php echo JURI::base().'components/com_storepapers/images/'.JText::_('COM_STOREPAPERS_LOGO_STOREPAPERS');?>"></a>
					</td>
					<td valign="top"><?php echo JText::_('COM_STOREPAPERS_LICENCIA_GPL');?><br/><a href="http://gplv3.fsf.org/" target="_blank"><IMG SRC="<?php echo JURI::base().'components/com_storepapers/images/gplv3.png';?>" style="border: 0; vertical-align: middle;"></a></td>
				</tr>	
			</table>
		</fieldset>	
		</td>
	</tr>
</table>
<p style="text-align: center;">StorePapers <?php echo JText::_('COMPONENTE_VERSION');?></p>
<input type="hidden" name="option" 		id="option" 	value="com_storepapers" />
<input type="hidden" name="view"   		id="view"   	value="storepapers" />
<input type="hidden" name="task"   		id="task"   	value="display" />
<input type="hidden" name="update"   	id="update"   	value="<?php echo $this->data['update'];?>" />
</form>
