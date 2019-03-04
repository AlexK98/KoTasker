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

namespace app\controllers;

use app\core\Controller;

class ShowTaskController extends Controller
{
	public function showAction()
	{
		if (debug) { echo __METHOD__.'<br>'; }

		$this->model->getTask($this->route->parameter);

		// render page
		$this->view->setLogged($this->sess->getLogged());
		$this->view->renderPage($this->model);
	}
}