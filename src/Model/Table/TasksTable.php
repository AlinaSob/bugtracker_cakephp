<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TasksTable extends Table
{
    /**
     * @param array $config
     * @return void
     */
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

    /**
     * @param Validator $validator
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator ->requirePresence('name')
            ->notEmptyString('name')
            ->requirePresence('description')
            ->notEmptyString('description');
        return $validator;
    }
}