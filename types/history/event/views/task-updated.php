<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 19.01.2020
 * Time: 22:30
 */

use app\models\History;
use yii\web\View;

/** @var $this View */
/** @var $model History */
/** @var $body string */
/** @var $footer string */
/** @var $iconClass string */

?>

<i class="icon icon-circle icon-main white <?= $iconClass ?>"></i>

<div class="bg-success ">
    <?= $body; ?>
</div>

<?php if($model->user): ?>
    <div class="bg-info"><?= $model->user->username; ?></div>
<?php endif; ?>

<div class="bg-warning">
    <?= $footer ?>
    <span><?= \app\widgets\DateTime\DateTime::widget(['dateTime' => $model->ins_ts]) ?></span>
</div>