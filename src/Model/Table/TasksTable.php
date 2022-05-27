<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class TasksTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('tasks');
        $this->belongsTo('Authors')
            ->setForeignKey('author_id')
            ->setClassName('Users');
        $this->belongsTo('Assignees')
            ->setForeignKey('assignee_id')
            ->setClassName('Users');

        $this->belongsTo('TaskTypes');
        $this->belongsTo('TaskStatuses');

        $this->addBehavior('Timestamp');
    }

}