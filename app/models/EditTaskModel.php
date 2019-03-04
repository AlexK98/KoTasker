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

class EditTaskModel extends Model
{
	public $isUpdated;

	// Update Task. Validate input first
	public function updateTask(string $description, string $status) : bool
	{
		$sql = 'UPDATE '.$this->base.' SET description = :de, state = :st WHERE id = :id';
		$params = [
			'id' => $this->route->parameter,
			'de' => $description,
			'st' => $status
		];

		$stmt = $this->db->queryDb($sql, $params);
		if (!$stmt) {
			Message::$msg = 'Sorry, failed to update task!';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		Message::$msg = 'Task successfully updated!';
		return true;
	}

	// Check Task status is COMPLETED
	public function isComplete(int $id) : bool
	{
		$sql = 'SELECT state FROM '.$this->base.' WHERE id = :id';
		$params = [ 'id' => $id ];
		$status = false;

		if ($this->db->getColumn($sql, $params) === 'completed') {
			$status = true;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }

		return $status;
	}

	// Validate input
	public function validateInput(string $description) : bool
	{
		$de = $this->validate->description($description);

		if (!$de) {
			Message::$msg .= ' Input validation failed.';
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return true;
	}
}