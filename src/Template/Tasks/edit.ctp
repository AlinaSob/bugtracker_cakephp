<?php
/**
 * @var $task
 * @var $tasktypes
 * @var $users
 * @var $taskstatuses
 */
?>

<div class="row">
    <?php
    echo $this->Form->create($task);
    echo $this->Form->controls(
        [
            'name' => ['required' => true, 'label' => 'Название'],
            'description' => ['required' => true, 'label' => 'Описание', 'type' => 'textarea'],
            'task_type_id' => ['label' => 'Тип задачи',
                'type' => 'select',
                'options' => $tasktypes,
                'empty' => 'Выберите тип задачи'
            ],
            'author_id' => ['label' => 'Автор задачи',
                'type' => 'select',
                'readonly' => 'readonly',
                'options' => $users
            ],
            'assignee_id' => ['label' => 'Ответственное лицо',
                'type' => 'select',
                'options' => $users,
                'empty' => 'Выберите ответственное лицо'
            ],
            'task_status_id' => ['label' => 'Статус задачи',
                'type' => 'select',
                'options' => $taskstatuses,
                'empty' => 'Выберите статус задачи'
            ],
        ],
        ['legend' => 'Редактировать задачу']
    );
    echo $this->Form->button('Сохранить', ['class' => 'btn btn-primary m-1']);
    echo $this->Html->link('Отменить редактирование',
        ['action' => 'index'],
        ['class' => 'btn btn-secondary m-1', 'block' => true]);
    echo $this->Form->postLink('Удалить',
        ['action' => 'delete', $task->id],
        ['confirm' => 'Вы уверены?', 'class' => 'btn btn-danger', 'block' => true]);

    echo $this->Form->end();
    ?>
</div>