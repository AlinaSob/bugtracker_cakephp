
<h1>Список задач</h1>
<div>
    <?= $this->Html->link('Создать задачу',
        ['action' => 'create'],
        ['class' => 'btn btn-outline-success m-1', 'block' => true]) ?>
</div>
<table class="table table-striped">
    <tr>
        <th>Название</th>
        <th><?= $this->Paginator->sort('task_type_id', 'Тип задачи') ?></th>
        <th>Статус</th>
        <th>Автор</th>
        <th>Ответственный</th>
        <th><?= $this->Paginator->sort('created', 'Создана') ?></th>
        <th>Изменена</th>
        <th>v</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($tasks as $task): ?>
        <tr>
            <td>
                <?= $this->Html->link($task->name, ['action' => 'view', $task->id]) ?>
            </td>
            <td>
                <?= $task->task_type->name ?>
            </td>
            <td>
                <?= $task->task_status->name ?>
            </td>
            <td>
                <?= $task->author->name ?>
            </td>
            <td>
                <?= $task->assignee->name ?>
            </td>
            <td>
                <?= $task->created->format('d.m.Y H:i:s') ?>
            </td>
            <td>
                <?= $task->modified->format('d.m.Y H:i:s') ?>
            </td>
            <td>
                <?= $this->Html->link('Ред.', ['action' => 'edit', $task->id]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<nav>
    <ul class="pagination">
<?php
echo $this->Paginator->prev(' << ' . 'Пред.');
echo $this->Paginator->numbers();
echo $this->Paginator->next(' >> ' . 'Cлед.');
?>
    </ul>
</nav>