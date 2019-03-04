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

use app\config\DBase;
use app\lib\Database;
use app\lib\Validator;
use app\lib\Route;

abstract class Model
{
	protected $route;
	protected $db;
	public $validate;

	protected $base;

	public $tasks;

	public function __construct(Route $route)
	{
		if (debug) { echo '<b style="color: darkgreen">'.__METHOD__.'</b><br>'; }

		$this->route    = $route;
		$this->base     = DBase::$dbase.'.'.DBase::$table;
		$this->db       = new Database();
		$this->validate = new Validator();

		if (debug && !empty(DBase::$msg)) {
			echo DBase::$msg . '<br>';
		}
	}

	public function getTasks(int $limit, int $offset, string $sort = COLUMN_ID, string $direction = DIR_ASCEND) : array
	{
		$sql = 'SELECT * FROM '.$this->base.' ORDER BY '.$sort.' '.$direction.' LIMIT :lim OFFSET :off';
		$params = [
			'lim' => $limit,
			'off' => $offset
		];

		$this->tasks = $this->db->getRow($sql, $params);

		if (debug) { echo __METHOD__.' passed<br>'; }

		return $this->tasks;
	}

	public function getTask(int $id) : array
	{
		$sql = 'SELECT * FROM '.$this->base.' WHERE id = :id';
		$params = [ 'id' => $id ];

		$this->tasks = $this->db->getRow($sql, $params);

		if (debug) { echo __METHOD__.' passed<br>'; }

		return $this->tasks;
	}

	public function getTasksCount() : int
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->base;

		return $this->db->getColumn($sql);
	}
}