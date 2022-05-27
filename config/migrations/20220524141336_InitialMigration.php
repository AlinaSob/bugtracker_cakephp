<?php

use App\Model\Entity\User;
use Cake\Auth\PasswordHasherFactory;
use Cake\Core\InstanceConfigTrait;
use Cake\ORM\TableRegistry;
use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

// Initial table creation

class InitialMigration extends AbstractMigration
{
    use InstanceConfigTrait;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
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

        //todo set from config
        $hasher = PasswordHasherFactory::build('Default');
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->newEntity([
            'name' => 'Test User',
            'email' => 'user@test.ru',
            'password' => $hasher->hash('password')
        ]);
        $usersTable->save($user);

        //TASKS
        $tasksTableMigration = $this->table('tasks');
        $tasksTableMigration->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $tasksTableMigration->addColumn('description', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $tasksTableMigration->addColumn('comment', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $tasksTableMigration->addColumn('task_type_id', 'integer', [
            'default' => 2,
            'limit' => MysqlAdapter::INT_TINY
        ]);
        $tasksTableMigration->addColumn('author_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $tasksTableMigration->addColumn('responsible_id', 'integer', [
            'default' => null,
            'null' => true
        ]);
        $tasksTableMigration->addColumn('task_status_id', 'integer', [
            'default' => 1,
            'limit' => MysqlAdapter::INT_TINY,
            'null' => false
        ]);
        $tasksTableMigration->addColumn('created', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);
        $tasksTableMigration->addColumn('modified','timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false
        ]);
        $tasksTableMigration->addIndex(['created', 'task_type_id']);

        $tasksTableMigration->create();

        //TASK_TYPES
        $taskTypeTableMigration = $this->table('task_types');
        $taskTypeTableMigration->addColumn('name', 'string', [
            'default' => null,
            'null' => false
        ]);
        $taskTypeTableMigration->create();

        $taskTypeTable = TableRegistry::getTableLocator()->get('TaskTypes');
        $types = ['Срочный баг', 'Несрочный баг', 'Незначительное улучшение'];
        foreach ($types as $name) {
            $taskType = $taskTypeTable->newEntity([
                'name' => $name
            ]);
            $taskTypeTable->save($taskType);
        }

        //TASK_STATUSES
        $taskStatusTableMigration = $this->table('task_statuses');
        $taskStatusTableMigration->addColumn('name', 'string', [
            'default' => null,
            'null' => false
        ]);
        $taskStatusTableMigration->create();

        $taskStatusTable = TableRegistry::getTableLocator()->get('TaskStatuses');
        $statuses = ['Создана', 'В работе', 'Выполнена', 'Отменена'];
        foreach ($statuses as $id => $name) {
            $taskStatus = $taskStatusTable->newEntity([
                'name' => $name
            ]);
            $taskStatusTable->save($taskStatus);
        }
    }
}
