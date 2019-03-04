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

namespace app\lib;

use app\core\View;

class Router
{
	private $routes = array();
	private $route;

	//==============================================================
	public function __construct()
	{
		if (debug) { echo '<b style="color: darkgreen">'.__METHOD__.'</b><br>'; }

		$routes = 'app/config/_routes.php';
		$this->route = new Route();

		if (file_exists($routes)) {
			$this->routes = include $routes;
		} else {
			exit('<b style="color: red">No routes defined</b><br>');
		}

		$this->process();
	}

	// Run application
	public function start()
	{
		if (debug) { echo __METHOD__.'<br>'; }

		// check if Route is defined and matches URI
		if (!$this->match()) {
			View::errorCode(404);
		}

		// check for availability of corresponding Controller
		$class = 'app\\controllers\\'.ucfirst($this->route->controller).'Controller';
		if (!class_exists($class)) {
			exit ('Class ['.$class.'] does not exist');
		}

		// check for availability of corresponding Action in Controller
		$action = $this->route->action.'Action';
		if (!method_exists($class, $action)) {
			exit ('Method ['.$action.'] does not exist');
		}

		// instantiate Controller class and call its Action method
		$controller = new $class($this->route);
		$controller->$action();
	}

	// check if uri matches one of predefined routes
	private function match() : bool
	{
		$uri = trim($_SERVER['REQUEST_URI'], '/');

		foreach ($this->routes as $uriPattern => $path) {
			if (preg_match($uriPattern, $uri)) {
				$pathSegments = explode('/', preg_replace($uriPattern, $path, $uri));

				$this->route->controller = array_shift($pathSegments);
				$this->route->action     = array_shift($pathSegments);
				if (count($pathSegments) > 0) {
					$this->route->parameter = (int)array_shift($pathSegments);
				} else {
					$this->route->parameter = 1;
				}
				return true;
			}
		}
		return false;
	}

	// prepare ROUTES array for PREG_MATCH
	private function process()
	{
		$count = count($this->routes);

		//
		foreach ($this->routes as $route => $path) {
			$rt = '#^'.$route.'$#';
			$this->routes[$rt] = $path;
		}

		// remove first COUNT of elements from ROUTES array as they are useless for PREG_MATCH
		for ($i = 1; $i <= $count; $i++) {
			array_shift($this->routes);
		}
	}
}