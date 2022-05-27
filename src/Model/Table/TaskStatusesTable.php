<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class TaskStatusesTable extends Table
{
    public function initialize(array $config)
    {
        $this->hasMany('Task');
    }

}