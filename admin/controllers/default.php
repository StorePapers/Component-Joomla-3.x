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

defined('_JEXEC') or die;

//Se importa el archivo donde se encuentra la clase abstracta del componente con la funcion de joomla “jimport”.
jimport('joomla.application.component.controller');

class StorepapersControllerDefault extends JControllerLegacy{

	var $isJoomla30 = false;
		
	public function __construct($config = array()){
	
		parent::__construct($config);
		if(version_compare(JVERSION,'3.0.0','ge')) {
			$this->isJoomla30 = true;
		}
	}
	
	public function display($cachable = false, $urlparams = false){
		
		$document = JFactory::getDocument();
		$viewType	= $document->getType();
		$viewLayout	= JRequest::getCmd( 'layout', 'default' );

		$view = $this->getThisView();

		// Get/Create the model
		if ($model = $this->getThisModel()) {
			// Push the model into the view (as default)
			$view->setModel($model, true);
		}

		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		if ($cachable && $viewType != 'feed') {
			global $option;
			$cache = JFactory::getCache($option, 'view');
			$cache->get($view, 'display');
		} else {
			$view->display();
		}
		//parent::display();
	}
	
	/**
	 * Returns the default model associated with the current view
	 * @return The global instance of the model (singleton)
	 */
	public final function getThisModel()
	{
		static $prefix = null;
		static $modelName = null;

		if(empty($modelName)) {
			$prefix = $this->getName().'Model';
			$view = JRequest::getCmd('view','storepapers');
			$modelName = ucfirst($view);
		}

		return $this->getModel($modelName, $prefix);
	}

	/**
	 * Returns current view object
	 * @return JView The global instance of the view object (singleton)
	 */
	public final function getThisView()
	{
		static $prefix = null;
		static $viewName = null;
		static $viewType = null;

		if(empty($modelName)) {
			$prefix = $this->getName().'View';
			$view = JRequest::getCmd('view','storepapers');
			$viewName = ucfirst($view);
			$document = JFactory::getDocument();
			$viewType	= $document->getType();
		}

		$basePath = (!$this->isJoomla30) ? $this->_basePath : $this->basePath;
		return $this->getView($viewName, $viewType, $prefix, array( 'base_path'=>$basePath));
	}	
	/*
	Función que cambia la vista y la dirige al panel de control de storepapers.
	Es llamada desde la barra de herramientas (estadisticas).
	*/
	public function controlPanel($cachable = false){
			
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.create', 'com_storepapers')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// redirect
		$option = JRequest::getCmd('option');
		
		$url = 'index.php?option='.$option;
		
		$this->setRedirect($url);
		$this->redirect();
	}	
	/*
	Función que filtra los campos escritos por si no fueran del tipo numérico, si existe algun error se sustituye el valor por prioridad 1.
	Solo acepta valores numéricos superiores o iguales a 1 y menores de 100.
	*/
	public function filtrarPrioridad(&$listaPrioridad){
	
		$n = count( $listaPrioridad );
		for($i=0;$i < $n; $i++){
			if(is_numeric($listaPrioridad[$i])){
				//Forzando un casting, esto lo hago para cambiar de tipo string a tipo integer
				$listaPrioridad[$i] = $listaPrioridad[$i] + 0;
				if(($listaPrioridad[$i] < 1)||($listaPrioridad[$i] > 100))
					$listaPrioridad[$i] = 1;
			}
			else
				$listaPrioridad[$i] = 1;
		}		
	}
}
?>
