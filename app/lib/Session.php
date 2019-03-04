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

class Session
{
	public function __construct()
	{
		if (debug) { echo '<b style="color: darkgreen">'.__METHOD__.'</b><br>'; }

		// init session params
		$this->iniMaxLifeTime();
		$this->iniCookieLifeTime();
	}

	// start/destroy session
	public function start()
	{
		session_start();
	}
	public function destroy()
	{
		$sortBy = $this->getSortBy();
		$sortOrder = $this->getSortOrder();
		$name = $this->getName();
		$email = $this->getEmail();

		if (isset($_SESSION)) {
			session_unset();
			session_destroy();
		}

		$this->start();
		$this->initSortOption($sortBy, $sortOrder);
		$this->setName($name);
		$this->setEmail($email);
	}

	// get/set USERNAME used when ADDing TASK
	public function setName(string $name = '')
	{
		$_SESSION['name'] = $name;
	}
	public function getName() : string
	{
		if (!isset($_SESSION['name'])) {
			return '';
		}
		return $_SESSION['name'];
	}

	// get/set EMAIL used when ADDing TASK
	public function setEmail(string $email = '')
	{
		$_SESSION['email'] = $email;
	}
	public function getEmail() : string
	{
		if (!isset($_SESSION['email'])) {
			return '';
		}
		return $_SESSION['email'];
	}

	// get/set LOGIN status
	public function setLogged(bool $logged)
	{
		$_SESSION['logged'] = $logged;
	}
	public function getLogged() : bool
	{
		if (!isset($_SESSION['logged'])) {
			return false;
		}
		return (bool)$_SESSION['logged'];
	}

	// making SESSION live defined LIFETIME period
	public function iniMaxLifeTime(int $lifetime = COOKIE_LIFETIME)
	{
		if ($lifetime < 0) {
			exit (__METHOD__.' [$lifetime] should be positive number');
		}

		if (ini_get('session.gc_maxlifetime') < $lifetime) {
			ini_set('session.gc_maxlifetime', $lifetime);
		}
	}
	public function iniCookieLifeTime(int $lifetime = COOKIE_LIFETIME)
	{
		if ($lifetime < 0) {
			exit (__METHOD__.' [$lifetime] should be positive number');
		}

		if (ini_get('session.cookie_lifetime') < $lifetime) {
			ini_set('session.cookie_lifetime', $lifetime);
		}
	}

	// get/set/init SORT VALUES used with TASKS LIST
	public function setSortBy(string $sortBy = COLUMN_ID)
	{
		$_SESSION['sortBy'] = $sortBy;
	}
	public function getSortBy() : string
	{
		return $_SESSION['sortBy'];
	}
	public function setSortOrder(string $sortOrder = DIR_ASCEND)
	{
		$_SESSION['sortOrder'] = $sortOrder;
	}
	public function getSortOrder() : string
	{
		return $_SESSION['sortOrder'];
	}
	public function initSortOption(string $sortBy = COLUMN_ID, string $sortOrder = DIR_ASCEND)
	{
		if (!isset($_SESSION['sortBy'], $_SESSION['sortOrder'])) {
			$_SESSION['sortBy'] = $sortBy;
			$_SESSION['sortOrder'] = $sortOrder;
		}
	}
}