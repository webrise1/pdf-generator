<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form =  ActiveForm::begin(['action'=>['load-users-from-excel'],"options"=>['enctype'=>"multipart/form-data"]]); ?>
    <h4>Загрузите файл excel (в одной ячейке - один email пользователя)</h4>
    <div class="form-group">
     <?=Html::fileInput('excel_file',null,['accept'=>".xls,.xlsx"])?>
    </div>
<?=Html::hiddenInput('template_certificate_id',$template_certificate_id)?>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>