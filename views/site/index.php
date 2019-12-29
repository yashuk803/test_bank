<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="body-content">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Дата</th>
                <th scope="col">Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($itemStatistic as $item): ?>
                <tr>
                    <td><?= $item['date'] ?></td>
                    <td><?= $item['sum'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Средняя сумма депозита</th>
                <th scope="col">Группа</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groupAverage as $item): ?>
                <tr>
                    <td><?= $item['average'] ?? '-'?></td>
                    <td><?= $item['group_client'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
