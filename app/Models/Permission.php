<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Permission extends EntrustPermission implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
    	'build_from' => 'display_name',
    	'save_to' => 'name',
    	'separator' => '_'
    ];
}
