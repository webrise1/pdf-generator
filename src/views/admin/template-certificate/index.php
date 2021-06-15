<?php

use app\models\Certificates;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\helpers\Html;
use \webrise1\pdfgenerator\models\Certificate;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CertificatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $sentCertificates int */


$this->title = 'Шаблоны сертификатов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-certificates-index">
    <div class="row">
        <div class="col-md-4">
            <?php
            \yii\bootstrap\Modal::begin([
                'header' => '<h2>Добавить шаблон сертификата</h2>',
                'toggleButton' => [
                    'label' => 'Добавить шаблон сертификата',
                    'tag' => 'button',
                    'class' => 'btn btn-success',
                ],
            ]);
            ?>

            <?= $this->render('_form', [
                'model' => new \webrise1\pdfgenerator\models\TemplateCertificate(),
            ]) ?>
            <?php \yii\bootstrap\Modal::end(); ?>
        </div>


    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            [
                    'format'=>'html',
                    'value'=>function($model){
                        return Html::a('Список выданных сертификатов',['/pdfgenerator/admin/certificate','template_certificate_id'=>$model->id],['class'=>'btn btn-success']);
                    }
            ],
            [
                'attribute' => 'status',
                'filter' => \webrise1\pdfgenerator\models\TemplateCertificate::getStatusesLabels(),
                'value' => function ($model) {
                    return \webrise1\pdfgenerator\models\TemplateCertificate::getStatusesLabels()[$model->status];
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} ',
            ],
        ],
    ]); ?>


</div>
