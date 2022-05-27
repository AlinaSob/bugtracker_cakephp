<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table
{
    public function initialize(array $config)
    {
        $this->hasMany('Tasks', [
            'foreignKey' => 'author_id'
        ]);
        $this->hasMany('AssignedTasks', [
            'className' => 'Tasks',
            'foreignKey' => 'assignee_id'
        ]);
    }
}