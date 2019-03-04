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

use app\config\Task;
use app\core\Controller;

class AddTaskController extends Controller
{
	public function addAction()
	{
		if (debug) { echo __METHOD__.'<br>'; }

		if (isset($_POST['submit']) && $_POST['submit'] === 'AddTask')
		{
			$isValid = $this->model->validateInput($_POST['username'],$_POST['email'],$_POST['description']);

			if ($isValid) {
				if ($this->model->addTask(Task::$name,Task::$email,Task::$description)) {
					$this->model->isAdded = true;
					$this->sess->setName(Task::$name);
					$this->sess->setEmail(Task::$email);
				}
			} else {
				$this->model->isAdded = false;
			}
		}

		// render page
		$this->view->setLogged($this->sess->getLogged());
		$this->view->setSession($this->sess);
		$this->view->renderPage($this->model);
	}
}