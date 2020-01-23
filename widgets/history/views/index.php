<?php

use app\widgets\export\ExportWidget;
use kartik\export\ExportMenu;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\search\HistorySearch */
/* @var $allowExport bool */
/* @var $gridColumns array */

?>

<?php if($allowExport): ?>
    <?= $this->render('_export', [
        'dataProvider' => $dataProvider,
        'gridColumns' => $gridColumns
    ]); ?>
<?php endif; ?>

<?php Pjax::begin(['id' => 'grid-pjax', 'formSelector' => false]); ?>
<?php echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'options' => [
        'tag' => 'ul',
        'class' => 'list-group'
    ],
    'itemOptions' => [
        'tag' => 'li',
        'class' => 'list-group-item'
    ],
    'emptyTextOptions' => ['class' => 'empty p-20'],
    'layout' => '{items}{pager}',
]); ?>
<?php Pjax::end(); ?>
