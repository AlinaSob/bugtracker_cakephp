<?php

use App\Model\Entity\User;
use Cake\Auth\PasswordHasherFactory;
use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\ModelAwareTrait;
use Cake\ORM\TableRegistry;
use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

// Initial table creation

class InitialMigration extends AbstractMigration
{
    use InstanceConfigTrait;
    use ModelAwareTrait;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        // USERS

        $usersTableMigration = $this->table('users');
        $usersTableMigration->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ])
            ->addColumn('email', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
        ])
            ->addColumn('password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ])
            ->addColumn('created', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ])
            ->addIndex('email')
            ->save();

        $hasher = PasswordHasherFactory::build('Default');
        $users = $this->loadModel('Users');
        $user = $users->newEntity([
            'name' => 'Test User',
            'email' => 'user@test.ru',
            'password' => $hasher->hash('password')
        ]);
        $users->save($user);

        //TASKS
        $tasksTableMigration = $this->table('tasks');
        $tasksTableMigration->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ])
            ->addColumn('description', 'text', [
            'default' => null,
            'null' => false,
        ])
            ->addColumn('comment', 'text', [
            'default' => null,
            'null' => false,
        ])
            ->addColumn('task_type_id', 'integer', [
            'default' => 2,
            'limit' => MysqlAdapter::INT_TINY
        ])
            ->addColumn('author_id', 'integer', [
            'default' => null,
            'null' => false
        ])
            ->addColumn('responsible_id', 'integer', [
            'default' => null,
            'null' => true
        ])
            ->addColumn('task_status_id', 'integer', [
            'default' => 1,
            'limit' => MysqlAdapter::INT_TINY,
            'null' => false
        ])
            ->addColumn('created', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ])
            ->addColumn('modified','timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false
        ])
            ->addIndex(['created', 'task_type_id'])
            ->save();

        //TASK_TYPES
        $taskTypeTableMigration = $this->table('task_types');
        $taskTypeTableMigration->addColumn('name', 'string', [
            'default' => null,
            'null' => false
        ]);
        $taskTypeTableMigration->create();

        $taskTypeModel = $this->loadModel('TaskTypes');
        $types = ['Срочный баг', 'Несрочный баг', 'Незначительное улучшение'];
        foreach ($types as $name) {
            $taskType = $taskTypeModel->newEntity([
                'name' => $name
            ]);
            $taskTypeModel->save($taskType);
        }

        //TASK_STATUSES
        $taskStatusTableMigration = $this->table('task_statuses');
        $taskStatusTableMigration->addColumn('name', 'string', [
            'default' => null,
            'null' => false
        ]);
        $taskStatusTableMigration->create();

        $taskStatusModel = $this->loadModel('TaskStatuses');
        $statuses = ['Создана', 'В работе', 'Выполнена', 'Отменена'];
        foreach ($statuses as $id => $name) {
            $taskStatus = $taskStatusModel->newEntity([
                'name' => $name
            ]);
            $taskStatusModel->save($taskStatus);
        }
    }

    public function down()
    {
        //
    }
}
