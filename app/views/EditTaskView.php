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
use app\models\EditTaskModel;
use app\config\Message;

class EditTaskView extends View
{
	public function renderPage(EditTaskModel $model)
	{
		// HEADER
		$this->addVar('logged', $this->getLogged());
		$templates['header'] = $this->render('header', true);

		// BODY
		$this->addVar('pageName', 'Edit Task #'.$this->route->parameter);
		$this->addVar('tasks', $model->tasks);
		// BODY - LOGIN STATUS
		$this->addVar('logged', $this->getLogged());
		// BODY - MESSAGE
		if ($model->isUpdated === true) {
			$this->addVar('msg', Message::$msg);
			$this->addVar('msgStyle', Message::$msgStyle);
		}
		if ($model->isUpdated === false) {
			$this->addVar('msg', Message::$msg);
			$this->addVar('msgStyle', Message::$msgStyleErr);
		}

		$templates['main'] = $this->render('main');

		// FOOTER
//		$templates['footer'] = $this->render('footer');

		// PAGE TITLE
		$templates['title'] = 'Edit Task #'.$this->route->parameter;

		// RENDER PAGE
		echo $this->renderLayout('default', $templates);
	}
}