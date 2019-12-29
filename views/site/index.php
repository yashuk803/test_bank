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
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item['date'] ?></td>
                    <td><?= $item['sum'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
