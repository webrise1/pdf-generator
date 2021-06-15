<?php


namespace webrise1\pdfgenerator\models\search;

use DateTime;
use webrise1\pdfgenerator\models\Certificate;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class CertificateSearch
 * @package app\models\search
 */
class CertificateSearch extends Certificate
{
    public $email;
    public $uid;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['uid'], 'integer'],
            [[ 'email', 'visited_at'], 'string'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($template_certificate_id,$params)
    {


        $query = Certificate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->where(['template_certificate_id'=>$template_certificate_id]);
        $query->joinWith('user u');
        $this->load($params);

        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere([ 'u.id'=> $this->uid]);
        if ($this->visited_at) {
            $endDate = new DateTime($this->visited_at);
            $endDate = $endDate->modify('+1 day')->format('Y-m-d');

            $query->andFilterWhere([
                'between',
                'visited_at',
                $this->visited_at . ' 00:00:00',
                $endDate . ' 00:00:00'
            ]);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        return $dataProvider;
    }
}