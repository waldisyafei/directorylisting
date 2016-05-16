<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

	public function hasPermission($name)
	{
		foreach ($this->perms as $permission) {
			if ($permission->name == $name) {
				return true;
			}
		}
	}
}
