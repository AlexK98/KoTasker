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

use app\core\Model;
use app\config\Message;

class AddTaskModel extends Model
{
	public $isAdded;

	// Add TASK to database. Validate input first
	public function addTask(string $name, string $email, string $description) : bool
	{
		$sql = 'INSERT INTO '.$this->base.'(username, email, description) VALUES (:un, :em, :de)';
		$params = [
			'un' => $name,
			'em' => $email,
			'de' => $description
		];

		$stmt = $this->db->queryDb($sql, $params);
		if (!$stmt) {
			Message::$msg = 'Sorry, failed to add task!';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		Message::$msg = 'Task successfully added.';
		return true;
	}

	// Validate input
	public function validateInput(string $name, string $email, string $description) : bool
	{
		$na = $this->validate->name($name);
		$em = $this->validate->email($email);
		$de = $this->validate->description($description);

		if (!$na || !$em || !$de) {
			Message::$msg .= ' Input validation failed.';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
}