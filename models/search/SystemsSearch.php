<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Systems;

/**
 * SystemsSearch represents the model behind the search form about `app\models\Systems`.
 */
class SystemsSearch extends Systems
{
    public $distributortitle;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sn', 'end_user_id', 'distributor_id', 'country_id', 'currency_id'], 'integer'],
            [['po', 'email', 'status', 'current_code', 'next_lock_date', 'main_unlock_code', 'created_at', 'updated_at', 'distributortitle'], 'safe'],
            [['cpup', 'epup', 'esp', 'csp', 'nop', 'cmp', 'emp', 'dmp', 'npl', 'ctpl', 'etpl', 'dtpl'], 'number'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Systems::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([
            'attributes' => [
                'sn', 'po', 'email', 'status', 'next_lock_date',
                'distributortitle' => [
                    'asc' => ['distributors.title' => SORT_ASC],
                    'desc' => ['distributors.title' => SORT_DESC],
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['distributor']);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sn' => $this->sn,
            'cpup' => $this->cpup,
            'epup' => $this->epup,
            'esp' => $this->esp,
            'csp' => $this->csp,
            'nop' => $this->nop,
            'cmp' => $this->cmp,
            'emp' => $this->emp,
            'dmp' => $this->dmp,
            'npl' => $this->npl,
            'ctpl' => $this->ctpl,
            'etpl' => $this->etpl,
            'dtpl' => $this->dtpl,
            'next_lock_date' => $this->next_lock_date,
            'end_user_id' => $this->end_user_id,
            'distributor_id' => $this->distributor_id,
            'country_id' => $this->country_id,
            'currency_id' => $this->currency_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'systems.po', $this->po])
            ->andFilterWhere(['like', 'systems.email', $this->email])
            ->andFilterWhere(['like', 'systems.status', $this->status])
            ->andFilterWhere(['like', 'systems.current_code', $this->current_code])
            ->andFilterWhere(['like', 'main_unlock_code', $this->main_unlock_code]);

        $query->joinWith(['distributor' => function ($q) {
                $q->andFilterWhere(['like', 'title', $this->distributortitle]);
            }]);

        return $dataProvider;
    }
}
