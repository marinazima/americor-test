<?php

namespace app\models\search;

use app\models\Customer;
use app\models\History;
use app\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * HistorySearch represents the model behind the search form about `app\models\History`.
 *
 * @property array $objects
 */
class HistorySearch extends History
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'customer_id',
                'objects',
                'user_id',
                'search',
                'department_ids',
                'date_from',
                'date_to',
                'denyObjects'
            ], 'safe'],
        ];

    }

    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'user_id' => \Yii::t('app', 'Agents'),
            'objects' => \Yii::t('app', 'Types'),
            'search' => \Yii::t('app', 'Search'),
            'department_ids' => \Yii::t('app', 'Department'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return null|ActiveDataProvider
     */
    public function search($params): ?ActiveDataProvider
    {
        $query = History::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                'ins_ts' => SORT_DESC,
                'id' => SORT_DESC
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return null;
        }
        $query->addSelect('history.*');

        $query->with([
            'customer',
            'user',
            'sms',
            'task',
            'call',
            'fax',
        ]);

        $query->andFilterWhere([
            History::tableName() . '.[[customer_id]' => $this->customer_id,
            History::tableName() . '.[[user_id]]' => $this->user_id
        ]);

        return $dataProvider;
    }
}
