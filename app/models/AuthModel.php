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

namespace app\models;

use app\config\Message;
use app\core\Model;

class AuthModel extends Model
{
	const LOGIN = 'Admin';
	const PASSWORD = '123';
	public $isLogged;

	// Check if login/password are OK. Validate input first
	public function processSignin(string $login, string $password) : bool
	{
		if ($login === self::LOGIN && $password === self::PASSWORD) {
			return true;
		}

		Message::$msg = 'Sign in failed. Please enter valid data.';
		return false;
	}

	// Validate input
	public function validateInput(string $name, string $password) : bool
	{
		$na = $this->validate->login($name);
		$pa = $this->validate->password($password);

		if (!$na || !$pa) {
			Message::$msg .= ' Input validation failed.';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
}