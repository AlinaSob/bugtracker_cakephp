<?php

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ModelAwareTrait;

class TasksController extends AppController
{
    use ModelAwareTrait;
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadModel('TaskTypes');
        $this->loadModel('TaskStatuses');
        $this->loadModel('Users');
        $this->loadModel('Tasks');
    }

    /**
     * List of all tasks
     * @return void
     * @throws \Exception
     */
    public function index()
    {
        $this->loadComponent('Paginator');
        $tasks = $this->Paginator->paginate(
            $this->Tasks->find()
                ->contain(['Authors', 'Assignees', 'TaskTypes', 'TaskStatuses']),
            ['order' => [
                'task_type_id' => 'asc',
                'Tasks.created' => 'desc'
                ]
            ]
        );
        $this->set('tasks', $tasks);
    }

    /**
     * View a task
     * @param int $id
     * @return \Cake\Http\Response
     */
    public function view(int $id)
    {
        try {
            $task = $this->Tasks
                ->get($id,
                    ['contain' => ['Authors', 'Assignees', 'TaskTypes', 'TaskStatuses']]
                );
            $this->set('task', $task);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Задача никогда не существовала или была удалена'));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Create new task
     * @return \Cake\Http\Response
     */
    public function create()
    {
        $this->setOptionArrays();
        $newTask = $this->Tasks->newEntity();
        if ($this->request->is('post')) {
            $newTask = $this->Tasks->patchEntity($newTask, $this->getTaskDataFromRequest());
            $this->Tasks->save($newTask);
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Edit a task
     * @param int $id
     * @return \Cake\Http\Response|void|null
     */
    public function edit(int $id)
    {
        $task = $this->Tasks->findById($id)->firstOrFail();
        $currentUser = $this->Auth->user();
        if ($task['author_id'] != $currentUser['id'] &&
            $task['assignee_id'] != $currentUser['id']
        ) {
            $this->Flash->error(__('Нет прав для редактирования задачи'));
        }

        $this->set('task', $task);
        $this->setOptionArrays();
        if ($this->request->is(['post', 'put'])) {
            $this->Tasks->patchEntity($task, $this->getTaskDataFromRequest());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('Задача обновлена.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ошибка при сохранении задачи.'));
        }
    }

    /**
     * Delete a task
     * @param int $id
     * @return \Cake\Http\Response|void|null
     */
    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->findById($id)->firstOrFail();
        if ($task->getAuthorId() != $this->Auth->user()->getId()){
            $this->Flash->error(__('Вы не можете удалять данную задачу'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('Задача {0} была удалена.', $task->name));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Set options for <select> controls
     * @return void
     */
    private function setOptionArrays()
    {
        $this->set('tasktypes', $this->TaskTypes->find('list')
            ->enableHydration(false)
            ->toArray());
        $this->set('taskstatuses', $this->TaskStatuses->find('list')
            ->enableHydration(false)
            ->toArray());

        $this->set('users', $this->Users->find('list')
            ->enableHydration(false)
            ->toArray());
    }

    /**
     * Get POST data for creating/editing
     * @return array
     */
    private function getTaskDataFromRequest()
    {
        $taskData = $this->request->getData();
        if (empty($taskData)) {
            $this->Flash->error(__('Нет данных для создания задачи'));
        }
        $user = $this->Auth->user();
        return ['name' => $taskData['name'],
            'description' => $taskData['description'],
            'comment' => $taskData['comment'] ?? '',
            'task_type_id' => $taskData['task_type_id'],
            'author_id' => $taskData['author_id'] ?? $user['id'],
            'assignee_id' => $taskData['assignee_id'] ?: null,
            'task_status_id' => $taskData['task_status_id']
        ];
    }
}