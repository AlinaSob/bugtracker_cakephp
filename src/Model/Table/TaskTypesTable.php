<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class TaskTypesTable extends Table
{
    /**
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
        $this->hasMany('Task');
    }
}