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

namespace app\views;

use app\core\View;
use app\models\HomeModel;

class HomeView extends View
{
	private $numPages;
	private $currentPage;
	private $maxPagesToShow = 3;

	public function renderPage(HomeModel $model)
	{
		// HEADER
		$this->addVar('logged', $this->getLogged());
		$templates['header'] = $this->render('header', true);

		// BODY
		$this->addVar('pageName', 'Task List');
		$this->addVar('tasks', $model->tasks);
		// BODY - LOGIN STATUS
		$this->addVar('logged', $this->getLogged());
		// BODY - SORTING TASKS
		$this->addVar('selected', 'selected="selected"');
		$this->addVar('sortBy', $this->sess->getSortBy());
		$this->addVar('sortOrder', $this->sess->getSortOrder());

		// BODY - PAGINATION RELATED
		$this->addVar('isPrevious', $this->isPrevious());
		$this->addVar('isNext', $this->isNext());
		$this->addVar('pageCount', $this->numPages);
		$this->addVar('currentPage', $this->currentPage);
		$this->addVar('pagination', $this->getPagination($this->calcRange()));

		$templates['main'] = $this->render('main');

		// FOOTER
//		$templates['footer'] = $this->render('footer');

		// PAGE TITLE
		$templates['title'] = 'Task List';

		// RENDER PAGE
		echo $this->renderLayout('default', $templates);
	}

	// PAGINATION RELATED METHODS
	public function setNumPages(int $pageCount = 1)
	{
		$this->numPages = $pageCount;

		if ($pageCount <= 0) {
			$this->numPages = 1;
		}
	}
	public function setCurrentPage(int $page = 1)
	{
		$this->currentPage = $page;

		if ($page <= 0) {
			$this->currentPage = 1;
		}

		if ($page > $this->numPages) {
			$this->currentPage = $this->numPages;
		}
	}

	private function getPagination(array $range) : string
	{
		$links = '';

		for ($page = $range['start']; $page <= $range['end']; $page++) {
			if ($page === $this->currentPage) {
				$links .= '<li class="page-item active"><a class="page-link" href="'.$page.'">'.$page.'</a></li>';
			} else {
				$links .= '<li class="page-item"><a class="page-link" href="'.$page.'">'.$page.'</a></li>';
			}
		}

		return $links;
	}
	private function calcRange() : array
	{
		$left = $this->currentPage - (int)($this->maxPagesToShow / 2);
		$start = $left > 0 ? $left : 1;

		if ($start + $this->maxPagesToShow <= $this->numPages) {
			$end = $start > 1 ? ($start + $this->maxPagesToShow - 1) : $this->maxPagesToShow;
		} else {
			$end = $this->numPages;
			$start = $this->numPages - $this->maxPagesToShow > 0 ? ($this->numPages - $this->maxPagesToShow + 1) : 1;
		}

		return array('start' => $start, 'end' => $end);
	}
	private function isPrevious() : bool
	{
		return ($this->currentPage > 1);
	}
	private function isNext() : bool
	{
		return !($this->currentPage >= $this->numPages);
	}
}