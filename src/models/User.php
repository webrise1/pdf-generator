<?php
namespace webrise1\pdfgenerator\models;
class User extends \yii\db\ActiveRecord{
    public function rules()
    {
        return [
            ['email','safe']
        ];
    }

    public static function tableName()
    {
        return '{{%user}}';
    }
    public function getCertificate($template_certificate_id){
        return Certificate::findOne(['user_id'=>$this->id,'template_certificate_id'=>$template_certificate_id]);
    }
}