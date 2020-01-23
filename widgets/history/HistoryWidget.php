<?php

namespace app\widgets\history;

use app\models\History;
use app\models\search\HistorySearch;
use app\widgets\Export\Export;
use kartik\export\ExportMenu;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;

class HistoryWidget extends Widget
{
    /**
     * @var string
     */
    public $view = 'index';

    /**
     * @var bool
     */
    public $allowExport = true;

    /**
     * @return string
     */
    public function run()
    {
        $searchModel = new HistorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render($this->view, [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            'allowExport' => $this->allowExport,
            'gridColumns' => ($this->allowExport ? $this->getGridColumns() : null),
        ]);
    }


    /**
     * @return array
     */
    protected function getGridColumns(): array
    {
        return [
            [
                'attribute' => 'ins_ts',
                'label' => Yii::t('app', 'Date'),
                'format' => 'datetime'
            ],
            [
                'label' => Yii::t('app', 'User'),
                'value' => function (History $model) {
                    return ArrayHelper::getValue($model->user, 'username', Yii::t('app', 'System'));
                }
            ],
            [
                'label' => Yii::t('app', 'Type'),
                'value' => function (History $model) {
                    return $model->object;
                }
            ],
            [
                'label' => Yii::t('app', 'Event'),
                'value' => function (History $model) {
                    return $model->eventText;
                }
            ],
            [
                'label' => Yii::t('app', 'Message'),
                'value' => function (History $model) {
                    return strip_tags($model->createEventType()->getBody());
                }
            ]
        ];
    }
}
