<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use webrise1\pdfgenerator\models\Certificate;
use yii\web\JsExpression;
use \kartik\select2\Select2;
use webrise1\pdfgenerator\models\TemplateCertificate;
/* @var $this yii\web\View */
/* @var $model app\models\Certificates */
/* @var $form yii\widgets\ActiveForm */

$action = $model->isNewRecord ? 'create' : 'update?id=' . $model->id;
?>

<div class="certificates-form">
    <div class="row">
        <div class="col-lg-9">
            <?php $form = ActiveForm::begin(['action' => ['/pdfgenerator/admin/template-certificate/' . $action]]); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php if(!$model->isNewRecord):?>
                <div class="form-group">
                    <?=$form->field($model,'status')->dropDownList(TemplateCertificate::getStatusesLabels(),['class'=>'form-control','disabled'=>($model->status==TemplateCertificate::STATUS_ARCHIVE)?'disabled':false])?>
                </div>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <label class="control-label" >width X height(в миллиметрах). Если не указывать по умолчанию - формат A4</label>

            <div class="row">
                <div class="col-lg-2">
                    <?= $form->field($model, 'width')->input('number',['maxlength' => true]) ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($model, 'height')->input('number',['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">

                </div>

            </div>
            <div class="row">
                <div class="col-lg-9">
                    <?=$this->render('_css_file_select_widget',[
                            'model'=>$model,
                            'form'=>$form,
                    ])?>

                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                         <?=Html::a('Файл менеджер',['/admin/filemanager','folder'=>'extension_pdf_generator.assets.css'],['class'=>'btn btn-success','target'=>'_blank','style'=>'margin-top: 26px;'])?>
                    </div>
                </div>
            </div>
            <?= $form->field($model, 'cssInline',
                [
                "template" => "{label}\n<br>".htmlspecialchars('<style>')."\n{input}".htmlspecialchars('</style>')."\n{hint}\n{error}"
                ]
                )->textarea(['maxlength' => true,'rows'=>5])   ?>
            <?= $form->field($model, 'content')->textarea(['maxlength' => true,'rows'=>12]) ?>
            <?php endif?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?php if(!$model->isNewRecord):?>
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(['action' => ['/pdfgenerator/admin/template-certificate/view-pdf?id='.$model->id],'options'=>['name'=>'pred_view_form','target'=>'_blank']]); ?>
            <h4>Предварительный просмотр</h4>
            <label class="control-label" for="certificate-name">ID Пользователя</label>
            <div>Сохранять перед просмотром необязательно</div>
            <div class="form-group">
                <?=Html::textInput('user_id',2,['class'=>'form-control'])?>
            </div>

            <?=Html::submitButton('Просмотр',['class'=>'btn btn-primary'])?>
            <?php ActiveForm::end(); ?>
            <?php $this->registerJs("
            $(document).ready(function(){
            $('[name=pred_view_form]').submit(function(){
                  $(this).append(\"<input name='content' type='hidden' value='\"+$('#templatecertificate-content').val()+\"'>\");
                  $(this).append(\"<input name='cssInline' type='hidden' value='\"+$('#templatecertificate-cssinline').val()+\"'>\");
                  $(this).append(\"<input name='width' type='hidden' value='\"+$('#templatecertificate-width').val()+\"'>\");
                  $(this).append(\"<input name='height' type='hidden' value='\"+$('#templatecertificate-height').val()+\"'>\");
                  let css_files_ids = new Array();
                  $(\"#templatecertificate-css_files option:selected\").each(function () { 
                        css_files_ids.push($(this).val());
                    });
                    css_files_ids=css_files_ids.join(',') 
                  $(this).append(\"<input name='cssFiles' type='hidden' value='\"+css_files_ids+\"'>\");  
                  return true;
                });
            })
            ")?>
        </div>

        <?php endif?>

    </div>
</div>
