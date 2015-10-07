<?php
/**
 *
 * This file is part of StorePapers
 *
 * Copyright (C) 2008-2013  Francisco Ruiz (storepapers@quepuedohacerhoy.com)
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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.filesystem.folder' );

function com_install() {
	
	$document	= JFactory::getDocument();
	$document->addStyleSheet(JURI::base(true).'/components/com_storepapers/assets/css/storepapers.css');
	$lang 		= JFactory::getLanguage();
	$lang->load('com_storepapers.sys');
	$lang->load('com_storepapers');	
	
	$styleInstall = 
	'background: 		url(\''.JURI::base(true).'/components/com_storepapers/images/btn.png\') repeat-x, url(\''.JURI::base(true).'/components/com_storepapers/images/storepapers_logo_48.png\') 10px center no-repeat;
	display: 			inline-block; 
	padding:			15px 30px 15px 70px;
	font-size: 			23px;   
	text-decoration: 	none;
	box-shadow: 		0 1px 2px rgba(0,0,0,0.6);
	-moz-box-shadow: 	0 1px 2px rgba(0,0,0,0.6);
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.6);
	border-radius: 			5px;
	-moz-border-radius: 	5px; 
	-webkit-border-radius: 	5px;
	border-bottom: 		1px solid rgba(0,0,0,0.25);
	position: 			relative;
	cursor: 			pointer;
	text-shadow: 		0 -1px 1px rgba(0,0,0,0.25);
	font-weight: 		bold;
	color: 				#fff;
	background-color: 	#6699cc;';

	$styleInstallPayPal = 
	'background: 		url(\''.JURI::base(true).'/components/com_storepapers/images/btn.png\') repeat-x, url(\''.JURI::base(true).'/components/com_storepapers/images/paypal_logo_48.png\') 10px center no-repeat;
	display: 			inline-block; 
	padding:			15px 30px 15px 70px;
	font-size: 			23px;   
	text-decoration: 	none;
	box-shadow: 		0 1px 2px rgba(0,0,0,0.6);
	-moz-box-shadow: 	0 1px 2px rgba(0,0,0,0.6);
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.6);
	border-radius: 			5px;
	-moz-border-radius: 	5px; 
	-webkit-border-radius: 	5px;
	border-bottom: 		1px solid rgba(0,0,0,0.25);
	position: 			relative;
	cursor: 			pointer;
	text-shadow: 		0 -1px 1px rgba(0,0,0,0.25);
	font-weight: 		bold;
	color: 				#fff;
	background-color: 	#6699cc;';
	
	$message .= '<p>&nbsp;</p><p>'.JText::_('COM_STOREPAPERS_POST_INSTALL_1').'</p><p>'.JText::_('COM_STOREPAPERS_POST_INSTALL_2').'</p>';	
	?>
	
	<div style="padding:15px;background:#fff;color: #777;font-size:105%;">	
		
		<IMG SRC="<?php echo JURI::base().'components/com_storepapers/images/'.JText::_('COM_STOREPAPERS_LOGO_STOREPAPERS');?>">		
		
		<p>&nbsp;</p>
		<?php echo $message; ?>
		<div style="clear:both">&nbsp;</div>
		<div style="text-align:center"><center><table border="0" cellpadding="20" cellspacing="20">
			<tr>				
				<td align="center" valign="middle">					
					<div id="sp-install"><a style="<?php echo $styleInstall; ?>" href="index.php?option=com_storepapers"><?php echo JText::_('COM_STOREPAPERS'); ?></a></div>
				</td>
				<td align="center" valign="middle">					
					<div id="sp-install"><a style="<?php echo $styleInstallPayPal; ?>" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=5J6H4XYPSYLL6&lc=ES&item_name=Joomla%21%20Component%20StorePapers&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted" target="_blank"><?php echo JText::_('COM_STOREPAPERS_DONAR'); ?></a></div>
				</td>
			</tr>
		</table></center></div>
		
		<p>&nbsp;</p><p>&nbsp;</p>
		<p>
		<a href="http://storepapers.quepuedohacerhoy.com/" target="_blank"><?php echo JText::_('COM_STOREPAPERS_POST_INSTALL_3'); ?></a><br />
		<?php echo JText::_('COM_STOREPAPERS_POST_INSTALL_4'); ?> <?php echo JText::_('COM_STOREPAPERS_MANUAL_LINEA_11_2'); ?></a><br />
		</p>		
		
	</div>		
<?php	
}
?>