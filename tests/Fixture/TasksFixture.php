<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;
use Phinx\Db\Adapter\MysqlAdapter;

class TasksFixture extends TestFixture
{
    public $import = ['table' => 'tasks'];

    public function init()
    {
        $this->records = [];
        parent::init();
    }
}