<?php


namespace webrise1\pdfgenerator\models\search;

use DateTime;
use webrise1\pdfgenerator\models\Certificate;
use webrise1\pdfgenerator\models\TemplateCertificate;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class CertificateSearch
 * @package app\models\search
 */
class TemplateCertificateSearch extends TemplateCertificate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','status'], 'integer'],
            [['name'], 'string'],
        ];
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

        $query = TemplateCertificate::find();
        if(!$this->status)
            $this->status=TemplateCertificate::STATUS_ACTIVE;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andFilterWhere([ 'status'=> $this->status]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        return $dataProvider;
    }
}