<?php
namespace webrise1\pdfgenerator\controllers\api;
use webrise1\pdfgenerator\models\Certificate;
use webrise1\pdfgenerator\models\TemplateCertificate;
use webrise1\pdfgenerator\models\UserCertificate;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\db\Expression;
class ApiController extends \yii\web\Controller {



    public function actionGetCertificate($token){
        $cert=Certificate::find()
            ->where(
                ['BINARY(`token`)' =>$token]
            )->joinWith('templateCertificate as tempcert')
            ->andWhere(['tempcert.status'=>TemplateCertificate::STATUS_ACTIVE]);
        $access=(($this->module->haveAdminAccessFunction)());
        $cert=$cert->one();
        if($cert){
            if(!$access) {
                $cert->visited_at = new Expression('NOW()');
                $cert->save();
            }
            return $cert->templateCertificate->getGeneratedPdf($cert->user_id);
        }else
            return  'Файл не найден или у вас нет доступа к нему.' ;
    }

}