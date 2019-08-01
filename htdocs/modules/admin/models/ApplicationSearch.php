<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Application;

/**
 * ApplicationSearch represents the model behind the search form of `app\modules\admin\models\Application`.
 */
class ApplicationSearch extends Application
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
		    [['name', 'email', 'phone', 'body', 'direction', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Application::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
          	'pageSize' => 10,
      ],
	  'sort'=>[
        'defaultOrder'=>[
             'created_at'=>SORT_DESC
        ]
     ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
			->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'body', $this->body])
			->andFilterWhere(['like', 'direction', $this->direction])
			->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
