<?php
namespace webrise1\pdfgenerator;
use webrise1\pdfgenerator\models\Certificate;
use webrise1\pdfgenerator\models\TemplateCertificate;
use yii\base\Module as BaseModule;
class Module extends BaseModule
{
    const EXT_NAME='ext-pdf-generator';
    public $controllerNamespace = 'webrise1\pdfgenerator\controllers';

    public $userTable;
    public $includeModels;
    public $haveAdminAccessFunction;
    const  SchemaFolders=[
            'title'=>'Расширение(Генератор сертификатов PDF)',
            'folderName'=>'extension_pdf_generator',
            'childs'=>[
                [
                    'title'=>'Изображения',
                    'folderName'=>'images',
                ],
                [
                    'title'=>'ASSETS',
                    'folderName'=>'assets',
                    'childs'=>[
                        [
                            'title'=>'Css',
                            'folderName'=>'css',
                        ],
                    ]
                ],
            ]
    ];
    const modelsUsingFileSnippets=[
        [
            'class'=>TemplateCertificate::class,
            'attributes'=>['css_files','content']
        ]
    ];
    public static function getMenuItems($label){
        return [
            'label' => $label, 'icon' => 'certificate','url' => ['/'.self::EXT_NAME.'/admin/template-certificate']
        ];
    }
}