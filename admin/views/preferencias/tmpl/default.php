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
if($this->data['update'] == 1)
	header('Location: '.JURI::base().'index.php?option=com_storepapers&view=update');
?>
<table border="0" cellspacing="0" cellpadding="0" align ="center" width="100%">
<tbody>
<tr>
	<td>
		<table border="0" cellspacing="4" cellpadding="4" align ="center">
		<tbody>
			<tr>		
				<td>
				<h4><?php echo JText::_('PREFERENCIAS_AÑO_PRIMERO');?></h4><INPUT TYPE="TEXT" NAME="first" MAXLENGTH=6 SIZE="10" VALUE="<?php echo $this->data['preferencias'][0]->first;?>">		
				</td>
			</tr>
			<tr>		
				<td>
				<h4><?php echo JText::_('PREFERENCIAS_AÑO_ACTUAL');?></h4><INPUT TYPE="TEXT" NAME="current" MAXLENGTH=6 SIZE="10" VALUE="<?php echo $this->data['preferencias'][0]->current;?>">		
				</td>
			</tr>
			<tr>		
				<td>
				<h4><?php echo JText::_('PREFERENCIAS_AÑO_ULTIMO');?></h4><INPUT TYPE="TEXT" NAME="last" MAXLENGTH=6 SIZE="10" VALUE="<?php echo $this->data['preferencias'][0]->last;?>">		
				</td>
			</tr>
			<tr>		
				<td></td>
			</tr>
		</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>
	<p style="text-align: center;">StorePapers <?php echo JText::_('COMPONENTE_VERSION');?></p>
	<input type="hidden" name="option" 		id="option" 	value="com_storepapers" />
	<input type="hidden" name="view"   		id="view"   	value="preferencias" />
	<input type="hidden" name="task"   		id="task"   	value="display" />
	<input type="hidden" name="id"			id="id"			value="<?php echo $this->data['preferencias'][0]->id;?>" type="hidden" />
</form>
