<?php
namespace webrise1\pdfgenerator;

use Yii;
use yii\base\BootstrapInterface;
class Bootstrap implements BootstrapInterface{
    //Метод, который вызывается автоматически при каждом запросе
    public function bootstrap($app)
    {

        //Правила маршрутизации
        $app->getUrlManager()->addRules([
           'admin/pdfgenerator/<controller>/<action>' => 'pdfgenerator/admin/<controller>/<action>',
           'admin/pdfgenerator/<controller>' => 'pdfgenerator/admin/<controller>',
           'pdf/certificate' => 'pdfgenerator/api/api/get-certificate',

        ], false);

//        if (Yii::$app->hasModule('mentor') && ($module = Yii::$app->getModule('mentor'))) {
//            $definition=$module->userModel;
//            $class = "qviox\\mentor\\models\\User";
//            Yii::$container->set($class, $definition);
//            $modelName =  $definition;
//            $this->user=$modelName;




        /*
         * Регистрация модуля в приложении
         * (вместо указания в файле frontend/config/main.php
         */
//        $app->setModule('mentor', 'webrise1\mentor\Module');
    }
}