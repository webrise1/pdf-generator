<?php

/* @var $this yii\web\View */
/* @var $model app\models\Certificates */

$this->title = 'Шаблон сертификата: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны сертификатов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>

<div class="template-certificates-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>