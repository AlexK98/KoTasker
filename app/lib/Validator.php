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

use app\config\Task;
use app\config\User;
use app\config\Message;

class Validator
{
	public function __construct()
	{
		if (debug) { echo '<b style="color: darkgreen">'.__METHOD__.'</b><br>'; }
	}

	public function isEmpty($data) : bool
	{
		if (!empty(trim($data))) {
			return false;
		}
		return true;
	}

	public function sanitize($data)
	{
		if (is_string($data)) {
			return filter_var(strip_tags($data), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW|FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		if (is_int($data)) {
			return (int)filter_var($data, FILTER_SANITIZE_NUMBER_INT);
		}

		if (is_float($data)) {
			return (float)filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
		}
		return false;
	}

	// TASK RELATED METHODS
	public function name(string $data) : bool
	{
		if ($this->isEmpty($data)) {
			Message::$msg = FIELD_REQUIRED;
			return false;
		}

		$sanitized = $this->sanitize($data);

		if ($data !== $sanitized) {
			Message::$msg = FIELD_REQUIRED;
			return false;
		}

		Task::$name = $sanitized;

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
	public function email(string $data) : bool
	{
		if ($this->isEmpty($data)) {
			Message::$msg = FIELD_REQUIRED;
			return false;
		}

		$data = filter_var(strtolower($data), FILTER_SANITIZE_EMAIL);
		$data = filter_var($data, FILTER_VALIDATE_EMAIL);

		if ($data === false) {
			Message::$msg = 'Please, enter valid email address.';
			return false;
		}

		Task::$email = $data;

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
	public function description(string $data) : bool
	{
		if ($this->isEmpty($data)) {
			Message::$msg = FIELD_REQUIRED;
			return false;
		}

		$sanitized = $this->sanitize($data);

		if ($data !== $sanitized) {
			Message::$msg = FIELD_REQUIRED;
			return false;
		}

		Task::$description = $sanitized;

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	// LOGIN RELATED METHODS
	public function login(string $data) : bool
	{
		if ($this->isEmpty($data)) {
			Message::$msg = FIELD_REQUIRED;
			return false;
		}

		$sanitized = $this->sanitize($data);

		if ($data !== $sanitized) {
			Message::$msg = FIELD_REQUIRED;
			return false;
		}

		User::$name = $sanitized;

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}

	public function password(string $data) : bool
	{
		if ($this->isEmpty($data)) {
			Message::$msg = FIELD_REQUIRED;
			return false;
		}

		$sanitized = $this->sanitize($data);

		if ($data !== $sanitized) {
			Message::$msg = FIELD_REQUIRED;
			return false;
		}

		User::$pass = $sanitized;

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
}