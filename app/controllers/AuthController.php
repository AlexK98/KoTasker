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

use app\config\Message;
use app\config\User;
use app\core\Controller;

class AuthController extends Controller
{
	public function signinAction()
	{
		if (debug) { echo __METHOD__.'<br>'; }

		if (isset($_POST['submit']) && $_POST['submit'] === 'SignIn')
		{
			if (!$this->model->validateInput($_POST['login'], $_POST['password'])) {
				$this->model->isLogged = false;
			} elseif (!$this->model->processSignin(User::$name, User::$pass)) {
				$this->model->isLogged = false;
			} else {
				$this->model->isLogged = true;
				$this->sess->setLogged(true);
				header('Location: /');
				exit();
			}
		}

		// render page
		$this->view->setLogged($this->sess->getLogged());
		$this->view->setSession($this->sess);
		$this->view->renderPage($this->model);
	}

	public function signoutAction()
	{
		$this->sess->setLogged(false);
		$this->sess->destroy();
		header('Location: /');
		exit();
	}
}