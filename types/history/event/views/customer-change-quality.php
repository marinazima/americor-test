<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 20.01.2020
 * Time: 22:14
 */

use yii\helpers\Html;

/* @var $model \app\models\History */
/* @var $oldValue string */
/* @var $newValue string */
/* @var $content string */
?>

<div class="bg-success ">
    <?= $model->eventText ?>
    <span class='badge badge-pill badge-warning'> <?= ($oldValue ?? Html::tag('i', 'not set')) ?></span>
    &#8594;
    <span class='badge badge-pill badge-success'> <?= ($newValue ?? Html::tag('i', 'not set')) ?></span>

    <span><?= \app\widgets\DateTime\DateTime::widget(['dateTime' =>  $model->ins_ts]) ?></span>
</div>

<?php if($model->user): ?>
    <div class="bg-info"><?= $model->user->username; ?></div>
<?php endif; ?>
