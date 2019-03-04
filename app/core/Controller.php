<?php
/*
* Author: Alex Kot
* Date: 2019/03/04
* EMail: kot.oleksandr.v@gmail.com
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*/

namespace app\core;

use app\lib\Session;
use app\lib\Route;

abstract class Controller
{
	protected $route;
	protected $view;
	protected $model;
	public    $sess;

	public function __construct(Route $route)
	{
		if (debug) { echo '<b style="color: darkgreen">'.__METHOD__.'</b><br>'; }

		$this->route = $route;

		$this->sess = new Session();
		$this->sess->start();
		$this->sess->initSortOption();

		$this->model = $this->loadModel();
		$this->view  = $this->loadView();
	}

	// Dynamically load MODEL by its NAME
	protected function loadModel()
	{
		if (debug) { echo __METHOD__.'<br>'; }

		$model = 'app\\models\\'.ucfirst($this->route->controller).'Model';
		if (!class_exists($model)) {
			exit(__METHOD__.' failed. '.$model.' not found.');
		}
		return new $model($this->route);
	}

	// Dynamically load VIEW by its NAME
	protected function loadView()
	{
		if (debug) { echo __METHOD__.'<br>'; }

		$view = 'app\\views\\'.ucfirst($this->route->controller).'View';
		if (!class_exists($view)) {
			exit(__METHOD__.' failed. '.$view.' not found.');
		}
		return new $view($this->route);
	}
}