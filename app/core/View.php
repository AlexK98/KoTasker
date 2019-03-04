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

use app\lib\Route;
use app\lib\Session;

abstract class View
{
	private $vars = array(); // array gets cleaned/reset on every RENDER call
	private $logged = false;
	protected $route;
	protected $sess;

	public function __construct(Route $route)
	{
		if (debug) { echo '<b style="color: darkgreen">'.__METHOD__.'</b><br>'; }

		$this->route = $route;
	}

	// Drawing error page based on http error code
	public static function errorCode(int $code, string $msg = '')
	{
		http_response_code($code);
		$path = 'app/templates/errors/'.$code.'.tpl.php';

		if (!file_exists($path)) {
			exit(__METHOD__.' Please define corresponding page for the error code issued<br>');
		}
		include $path;
		exit($msg);
	}

	// TEMPLATE PROCESSING
	// ==================================================================================
	// Adds variable and its contents to show on the page
	// @data - should be STRING or ARRAY
	public function addVar(string $name, $data)
	{
		$this->vars[$name] = $data;
	}

	// Render chosen $template. Set to render default one with $useDefault
	public function render(string $template, bool $useDefault = false)
	{
		ob_start();
		$file = 'app/templates/'.$this->route->controller.'/'.$this->route->action.'_'.$template.'.tpl.php';

		if ($useDefault) {
			$file = 'app/templates/default/default_'.$template.'.tpl.php';
		}

		if (file_exists($file)) {
			extract($this->vars, EXTR_SKIP);
			include $file;
		}
		$result = ob_get_clean();

		// resetting output array
		reset($this->vars);

		//if (debug) { echo __METHOD__.' passed<br>'; }
		return $result;
	}

	// Render layout with $vars being Templates
	public function renderLayout(string $layout, array $vars)
	{
		if (empty(trim($layout))) {
			$layout = 'default';
		}

		ob_start();
		extract($vars, EXTR_SKIP);

		$file = 'app/templates/_layouts/'.$layout.'.php';

		if (file_exists($file)) {
			include $file;
		} else {
			self::errorCode(404);
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return ob_get_clean();
	}

	public function setLogged(bool $logged)
	{
		$this->logged = $logged;
	}
	public function getLogged() : bool
	{
		return $this->logged;
	}

	public function setSession(Session $sess)
	{
		$this->sess = $sess;
	}
}