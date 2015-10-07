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
defined( '_JEXEC' ) or die;

// Import html
JHtml::_('behavior.framework');
jimport ('joomla.html.html.bootstrap');

jimport('joomla.html.pane');
?>

<!-- Compruebo que no hay falta de actualizaciones -->
<form name="adminForm" id="adminForm" action="index.php" method="post">
<?php 	
$seMuestranMensajesAdvertencia = 0;
//No existe la tabla "config" o está dañada.
if($this->data['estado'] == 6){
	echo '<p> </p>';
	echo '<p> </p>';
	echo '<h1>'.JText::_('ERROR_TABLA_CONFIG_REPARACION').'</h1>';
	if(!$seMuestranMensajesAdvertencia){			
		echo '<h2>'.JText::_('SI_APARECEN_MENSAJES_ADVERTENCIA').'</h2>';
		$seMuestranMensajesAdvertencia = 1;
	}
}
if($this->data['estado'] == 8){
	echo '<p> </p>';
	echo '<p> </p>';
	echo '<h1>'.JText::_('VERSION_NO_COINCIDE').'</h1>';
	if(!$seMuestranMensajesAdvertencia){			
		echo '<h2>'.JText::_('SI_APARECEN_MENSAJES_ADVERTENCIA').'</h2>';
		$seMuestranMensajesAdvertencia = 1;
	}
}		
//Se ha llevado a cabo alguna actualización.
if(($this->data['estado'] == 1) || ($this->data['estado'] == 6) || ($this->data['estado'] == 8)){

	echo '<p> </p>';
	echo '<p> </p>';
	echo '<h1>'.JText::_('SE_HA_LLEVADO_ACTUALIZACIONES').'</h1>';
	if(!$seMuestranMensajesAdvertencia){			
		echo '<h2>'.JText::_('SI_APARECEN_MENSAJES_ADVERTENCIA').'</h2>';
		$seMuestranMensajesAdvertencia = 1;
	}
	echo '<p> </p>';
	echo '<h2>'.JText::_('LISTA_ACTUALIZACIONES_REALIZADAS').'</h2>';
	echo '<ul>';
	$n = count($this->data['actualizaciones']);
	for($numAct = 0;$numAct < $n;$numAct += 1){
		
		switch($this->data['actualizaciones'][$numAct]){
		
					//Se ha llevado a cabo la actualización Versión 1.4
					case 14 	:	echo '<li><p>'.JText::_('ACTUALIZACION_14').'</p></li>';
									break;
		
					//Se ha llevado a cabo la actualización Versión 1.3
					case 13 	:	echo '<li><p>'.JText::_('ACTUALIZACION_13').'</p></li>';
									break;
					
					//Se ha llevado a cabo la actualización Versión 1.22
					case 122	:	echo '<li><p>'.JText::_('ACTUALIZACION_122').'</p></li>';
									break;
		
					//Se ha llevado a cabo la actualización Versión 1.21
					case 121	:	echo '<li><p>'.JText::_('ACTUALIZACION_121').'</p></li>';
									break;
		
					//Se ha llevado a cabo la actualización Versión 1.2
					case 12		:	echo '<li><p>'.JText::_('ACTUALIZACION_12').'</p></li>';
									break;
		}
	}
	echo '</ul>';
}
else{
	echo '<p> </p>';
	echo '<p> </p>';
	echo '<h1>'.JText::_('NO_SE_HA_LLEVADO_ACTUALIZACIONES').'</h1>';
	echo '<h2>'.JText::_('TIENES_ULTIMA_VERSION').'</h2>';
}
echo '<p> </p>';
echo '<p> </p>';
echo '<table align="center" cellspacing="4" cellpadding="4">';
echo '<tbody>';
echo 	'<tr>';
echo 		'<td align="center">';
echo 			'<h2><a href="'.JURI::base().'index.php?option=com_storepapers">'.JText::_('PULSA_AQUI_PARA_VOLVER_PANEL_CONTROL').'</a></h2>';		
echo 		'</td>';		
echo 	'</tr>';
echo 	'<tr>';
echo 		'<td align="center">';
echo			'<div class="cpanel">';
echo			'<div class="icon">';
echo				'<a href="'.JURI::base().'index.php?option=com_storepapers">';
echo				'<img alt="" src="'.JURI::base().'components/com_storepapers/images/controlPanel-48.png">';
echo				'<span>'.JText::_('COM_STOREPAPERS_PANEL_DE_CONTROL').'</span>';
echo				'</a>';
echo			'</div>';
echo			'</div>';
echo 		'</td>';
echo 	'</tr>';	
echo '</tbody>';
echo '</table>';	
?>
<input type="hidden" name="option" 		id="option" 	value="com_storepapers" />
<input type="hidden" name="view"   		id="view"   	value="update" />
<input type="hidden" name="task"   		id="task"   	value="display" />
</form>
