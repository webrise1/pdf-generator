<?php
namespace webrise1\pdfgenerator\controllers\admin;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class BaseController extends \yii\web\Controller {
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
public function beforeAction($action)
{
    if(!(($this->module->haveAdminAccessFunction)())){
        echo "У вас нет прав для доступа к этой странице"; die();
    }
    return parent::beforeAction($action); // TODO: Change the autogenerated stub
}

}