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
use app\models\ShowTaskModel;

class ShowTaskView extends View
{
	public function renderPage(ShowTaskModel $model)
	{
		// HEADER
		$this->addVar('logged', $this->getLogged());
		$templates['header'] = $this->render('header', true);

		// BODY
		$this->addVar('pageName', 'Task #'.$this->route->parameter.' Details');
		$this->addVar('tasks', $model->tasks);
		// BODY - LOGIN STATUS
		$this->addVar('logged', $this->getLogged());
		$templates['main'] = $this->render('main');

		// FOOTER
//		$templates['footer'] = $this->render('footer');

		// PAGE TITLE
		$templates['title'] = 'Show Task #'.$this->route->parameter;

		// RENDER PAGE
		echo $this->renderLayout('default', $templates);
	}
}