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
                <th scope="col">#</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= \date('m-Y', \strtotime($item->created_on)) ?></td>
                    <td><?= $item->sum ?></td>
                    <?php if ($item->type === 'Percent'): ?>
                        <td>Прибыль</td>
                    <?php elseif ($item->type === 'Commission'): ?>
                        <td>Убыток</td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
