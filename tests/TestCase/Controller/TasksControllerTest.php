<?php

namespace App\Test\TestCase\Controller;

use Cake\Datasource\ModelAwareTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class TasksControllerTest extends TestCase
{
    use IntegrationTestTrait;
    use ModelAwareTrait;
    public $fixtures = ['app.Tasks'];

    public function setUp()
    {
        parent::setUp();
        require_once '../../bootstrap.php';
        $this->_useHttpServer = true;
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'Test User',
                ]
            ]
        ]);
    }

    public function testIndex()
    {
        $this->get('/tasks');

        $this->assertResponseOk();
    }

    public function testCreateTask()
    {
        $data = [
            'name' => 'Название таска',
            'description' => 'Тут описание таска',
            'comment' => '',
            'task_type_id' => '1',
            'task_status_id' => '1',
            'author_id' => '1',
            'assignee_id' => '1',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/tasks/create', $data);

        $this->loadModel('Tasks');
        $task = $this->Tasks
            ->find('all', ['order' => ['id DESC']])
            ->first();
        $this->assertTextEquals($data['name'], $task->name);
        $this->assertTextEquals($data['description'], $task->description);
    }
}