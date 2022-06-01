<?php
/**
 * @var $task
 */
?>
<h1>
    <?= $task->name ?>
</h1>
<p>
    Тип задачи: <?= $task->task_type->name ?><br />
    Автор: <?= $task->author->name ?> <br />
    Ответственное лицо: <?= $task->assignee->name ?><br />
    Статус: <?= $task->task_status->name ?><br />
    Создана: <?= $task->created->format(DATE_RFC850) ?><br />
    Изменена: <?= $task->modified->format(DATE_RFC850) ?><br />
</p>
<div>
    <h3>Описание</h3>
    <p>
        <?= $task->description ?>
    </p>
</div>
<div>
    <h3>Комментарий ответственного лица</h3>
    <p>
        <?= $task->comment ?>
    </p>
</div>
<div>
    <?= $this->Html->link('Редактировать', ['action' => 'edit', $task->id]) ?> |
    <?= $this->Html->link('К списку', ['action' => 'index']);  ?>
</div>