<?php

use app\models\Certificates;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CertificatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $sentCertificates int */

$this->title = 'Список сертификатов';
$this->params['breadcrumbs'][] = [
        'url'=>['/pdfgenerator/admin/certificate'],
       'label'=> 'Шаблоны сертификатов'
];
$this->params['breadcrumbs'][] = $template_certificate->name;
?>
<div class="certificates-index">
    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>Добавить пользователей</h2>',
        'toggleButton' => [
            'label' => 'Добавить пользователей',
            'tag' => 'button',
            'class' => 'btn btn-success',
        ],
    ]);

     echo $this->render('_form',['template_certificate_id'=>$template_certificate->id]);
     \yii\bootstrap\Modal::end();
     ?>
    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>Загрузить пользователей (Excel)</h2>',
        'toggleButton' => [
            'label' => 'Загрузить пользователей (Excel)',
            'tag' => 'button',
            'class' => 'btn btn-success',
        ],
    ]);

    echo $this->render('_import_excel',['template_certificate_id'=>$template_certificate->id]);
    \yii\bootstrap\Modal::end();
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'ID пользователя',
                'attribute'=>'uid',
                'value'=>function($model){
                    return $model->user->id;
                }

            ],

            [
              'label'=>'Email',
              'attribute'=>'email',
              'value'=>function($model){
                 return $model->user->email;
              }

            ],
            [
                'attribute' => 'visited_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'visited_at',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]
                )],
            [
              'format'=>'raw',
              'value'=>function($model){
                  return \yii\helpers\Html::a('Ссылка', ['/pdfgenerator/api/api/get-certificate','token'=>$model->token],['target'=>'_blank']);
              }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '  {delete}',

            ],
        ],
    ]); ?>


</div>
