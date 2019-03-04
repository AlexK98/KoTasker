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

// ROUTE LIST

return [
	''         => 'home/home',
	'([0-9]+)' => 'home/home/$1',

	'add'             => 'addTask/add',
	'view/([0-9]+)'   => 'showTask/show/$1',
	'edit/([0-9]+)'   => 'editTask/edit/$1',
	'delete/([0-9]+)' => 'deleteTask/delete/$1',

	'signin'  => 'auth/signin',
	'signout' => 'auth/signout',
];
