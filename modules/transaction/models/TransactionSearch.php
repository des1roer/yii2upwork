<?php

namespace app\modules\transaction\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\transaction\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form about `app\modules\transaction\models\Transaction`.
 */
class TransactionSearch extends Transaction {

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sender_id', 'recipient_id', 'type_id', 'status_id'], 'integer'],
            [['transaction_id', 'protect_code'], 'safe'],
            [['cost'], 'number'],
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
        $query = Transaction::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate())
        {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'or',
            ['sender_id' => Yii::$app->user->identity->id],
            ['recipient_id' => Yii::$app->user->identity->id],
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'recipient_id' => $this->recipient_id,
            'cost' => $this->cost,
            'type_id' => $this->type_id,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
                ->andFilterWhere(['like', 'protect_code', $this->protect_code]);

        return $dataProvider;
    }

}
