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

class HomeController extends Controller
{
	public function homeAction()
	{
		if (debug) { echo __METHOD__.'<br>'; }

		// check if user is logged and refresh user data

		if (isset($_POST['submit']) && $_POST['submit'] === 'Sort') {
			$sortValues = $this->getSortValues();

			$sortBy    = $this->model->validate->sanitize($_POST['sortBy']);
			$sortOrder = $this->model->validate->sanitize($_POST['sortOrder']);

			$this->setSortBy($sortBy, $sortValues);
			$this->setSortOrder($sortOrder, $sortValues);
		}

		$this->model->getTasks(
			ITEMS_PER_PAGE,
			$this->calculateOffset($this->route->parameter),
			$this->sess->getSortBy(),
			$this->sess->getSortOrder()
		);

		// render page
		$this->view->setSession($this->sess);
		$this->view->setLogged($this->sess->getLogged());
		$this->view->setNumPages($this->calculatePageCount());
		$this->view->setCurrentPage($this->route->parameter);
		$this->view->renderPage($this->model);
	}

	private function calculateOffset(int $page = 1) : int
	{
		if ($page === 0) { $page = 1; }

		return ($page - 1) * ITEMS_PER_PAGE;
	}

	private function calculatePageCount() : int
	{
		return (int)ceil($this->model->getTasksCount() / ITEMS_PER_PAGE);
	}

	private function getSortValues() : array
	{
		return array(COLUMN_ID, COLUMN_NAME, COLUMN_EMAIL, COLUMN_STATE, DIR_ASCEND, DIR_DESCEND);
	}

	private function setSortBy(string $sortBy, array $sortValues) : bool
	{
		if ($sortBy && in_array($sortBy, $sortValues, true)) {
			$this->sess->setSortBy($sortBy);
			return true;
		}
		$this->sess->setSortBy();
		return false;
	}

	private function setSortOrder(string $sortOrder, array $sortValues) : bool
	{
		if ($sortOrder && in_array($sortOrder, $sortValues, true)) {
			$this->sess->setSortOrder($sortOrder);
			return true;
		}
		$this->sess->setSortOrder();
		return false;
	}
}