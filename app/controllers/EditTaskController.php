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
use app\config\Task;

class EditTaskController extends Controller
{
	public $status = STATE_ACTIVE;

	public function editAction()
	{
		if (debug) { echo __METHOD__.'<br>'; }

		if ($this->sess->getLogged() === false) {
			header('location: /');
			exit();
		}

		$this->model->getTask($this->route->parameter);

		if (isset($_POST['submit']) && $_POST['submit'] === 'UpdateTask')
		{
			if (isset($_POST['state']) && $_POST['state'] === STATE_COMPLETED) {
				$this->status = STATE_COMPLETED;
			}

			$isValid = $this->model->validateInput($_POST['description']);

			if ($isValid) {
				if ($this->model->updateTask(Task::$description, $this->status)) {
					$this->model->isUpdated = true;
					$this->model->getTask($this->route->parameter);
				}
			} else {
				$this->model->isUpdated = false;
			}
		}

		// render page
		$this->view->setLogged($this->sess->getLogged());
		$this->view->setSession($this->sess);
		$this->view->renderPage($this->model);
	}
}