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

use app\config\DBase;
use PDO;
use PDOException;

class Database
{
	private $pdo;
	private $stmt;

	public function __construct()
	{
		if (debug) { echo '<b style="color: darkgreen">'.__METHOD__.'</b><br>'; }

		// create connection
		try {
			$this->pdo = new PDO('mysql:host='.DBase::$host.';dbname='.DBase::$dbase, DBase::$user, DBase::$pass);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			// CREATION OF DATABASE AND FILLING IT WITH THINGS IS HERE SOLELY FOR DEBUG/DEV PURPOSES
			// =====================================================================================
			// if no database is present (1049) on host we create it, its table and so on
			if ($e->getCode() === 1049) {
				try {
					$this->pdo = new PDO('mysql:host='.DBase::$host, DBase::$user, DBase::$pass);
				} catch (PDOException $q) {
					DBase::$msg = 'Error: ' . $q->getMessage();
					exit(DBase::$msg);
				}

				// create database and all related stuff
				$this->createDatabase(DBase::$dbase, DBase::$charset, DBase::$collate);
				$this->useDatabase(DBase::$dbase);
				$this->createTable(DBase::$table);
				$this->propagateTable(DBase::$table);

				DBase::$msg = '<span style="color: orange">Site is running fresh</span>';
			} else {
				DBase::$msg = 'Error: <span style="color: red">'.$e->getMessage().'</span>';
			}
		}
	}
	public function __destruct()
	{
		if (debug) { echo '<span style="color: cornflowerblue">'.__METHOD__.'</span><br>'; }

		$this->stmt = null;
		$this->pdo  = null;
	}

	// Database query
	public function queryDb(string $sql, array $params = [])
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		try {
			$this->stmt = $this->pdo->prepare($sql);
		} catch (PDOException $e) {
			DBase::$msg = 'Error: ' . $e->getMessage();
			return false;
		}

		if (!empty($params)) {
			foreach ($params as $key => $value) {
				if (is_int($value)) {
					$type = PDO::PARAM_INT;
				} elseif (is_string($value)) {
					$type = PDO::PARAM_STR;
				} else {
					DBase::$msg = __METHOD__.': Wrong type of param - '.$value.' in '.$key.'<br>';
					return false;
				}

				if (!$this->stmt->bindValue(':'.$key, $value, $type)) {
					exit('could not bind ['.$value.'] to [:'.$key.']' );
				}
			}
		}

		try {
			$this->stmt->execute();
		} catch (PDOException $e) {
			DBase::$msg = 'Error: ' . $e->getMessage();
			return false;
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $this->stmt;
	}

	// Query database and return ROW(s) from it
	public function getRow(string $sql, array $params = []) : array
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		$this->stmt = $this->queryDb($sql, $params);
		if (!$this->stmt) {exit(__METHOD__.' failed');}

		$array = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $array;
	}

	// Query database and return SINGLE value
	public function getColumn(string $sql, array $params = [])
	{
		if (debug) { echo '<b>'.__METHOD__.'</b><br>'; }

		$this->stmt = $this->queryDb($sql, $params);
		if (!$this->stmt) {exit(__METHOD__.' failed');}

		$value = $this->stmt->fetchColumn();

		if (debug) { echo __METHOD__.' passed<br>'; }
		return $value;
	}

	// HELPER/DEBUG/DEVELOPMENT ONLY METHODS
	// ===============================================================
	private function createDatabase(string $dbase, string $cset, string $coll)
	{
		$sql = "CREATE DATABASE IF NOT EXISTS $dbase CHARACTER SET $cset COLLATE $coll";
		$this->stmt = $this->pdo->prepare($sql);

		$result = $this->pdo->exec($this->stmt->queryString);
		if ($result === false) {
			exit(__METHOD__.' failed');
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
	}

	private function useDatabase(string $dbase)
	{
		// createDatabase() call should precede call of this method
		$sql = "USE $dbase";
		$this->stmt = $this->pdo->prepare($sql);

		$result = $this->pdo->exec($this->stmt->queryString);
		if ($result === false) {
			exit(__METHOD__.' failed');
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
	}

	private function createTable(string $table)
	{
		// useDatabase() call should precede call of this method
		$sql = "CREATE TABLE IF NOT EXISTS $table (
  			id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  			username VARCHAR(100) NOT NULL ,
  			email VARCHAR(255) NOT NULL ,
  			description VARCHAR(512) NOT NULL ,
  			state VARCHAR(32) NOT NULL DEFAULT 'active'
		)";

		$this->stmt = $this->pdo->prepare($sql);

		$result = $this->pdo->exec($this->stmt->queryString);

		if ($result === false) {
			exit(__METHOD__.' failed<br>');
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
	}

	private function propagateTable(string $table)
	{
		$sql = "
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Gabriel James', 'Gabriel_James7570@acrit.org', 'Time Management', 'completed');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Danny Smith', 'Danny_Smith2221@yahoo.com', 'Time Management', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Juliette Walker', 'Juliette_Walker4851@twipet.com', 'Communication', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Bridget Mcnally', 'Bridget_Mcnally3876@twipet.com', 'Work Under Pressure', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Daron Dickson', 'Daron_Dickson4822@grannar.com', 'Self-motivation', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Gabriel Rogers', 'Gabriel_Rogers7512@muall.tech', 'Conflict Resolution', 'completed');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Sadie Harper', 'Sadie_Harper3427@brety.org', 'Communication', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Penelope Murray', 'Penelope_Murray4693@corti.com', 'Conflict Resolution', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Gemma Clarke', 'Gemma_Clarke6628@nickia.com', 'Communication', 'completed');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Angela Kennedy', 'Angela_Kennedy4750@gembat.biz', 'Time Management', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Kieth Upsdell', 'Kieth_Upsdell6461@bauros.biz', 'Self-motivation', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Nate Watson', 'Nate_Watson5594@irrepsy.com', 'Conflict Resolution', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Harvey Raven', 'Harvey_Raven679@hourpy.biz', 'Work Under Pressure', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Mark Kirby', 'Mark_Kirby9869@twipet.com', 'Adaptability', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Roger Ulyatt', 'Roger_Ulyatt5303@vetan.org', 'Learning', 'completed');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Benjamin Harper', 'Benjamin_Harper7436@atink.com', 'Communication', 'completed');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Mackenzie Corbett', 'Mackenzie_Corbett1972@nimogy.biz', 'Decision Making', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Mya Woodley', 'Mya_Woodley3765@infotech44.tech', 'Work Under Pressure', 'completed');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Owen Atkinson', 'Owen_Atkinson4469@cispeto.com', 'Teamwork', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Shay Rust', 'Shay_Rust8638@acrit.org', 'Conflict Resolution', 'active');
			INSERT INTO $table (`id`, `username`, `email`, `description`, `state`) VALUES (NULL, 'Celina Hamilton', 'Celina_Hamilton6744@elnee.tech', 'Decision Making', 'active');
		";

		$this->stmt = $this->pdo->prepare($sql);

		$result = $this->pdo->exec($this->stmt->queryString);

		if ($result === false) {
			exit(__METHOD__.' failed<br>');
		}

		if (debug) { echo __METHOD__.' passed<br>'; }
	}
}