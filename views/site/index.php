<?php

use app\widgets\history\HistoryWidget;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div class="site-index">
    <?= HistoryWidget::widget() ?>
</div>
