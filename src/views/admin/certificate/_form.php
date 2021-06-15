<?php
use yii\helpers\Html;
use yii\web\JsExpression;
use \yii\widgets\ActiveForm;
?>
<?php
$url = \yii\helpers\Url::to(['user-list']);
?>
<?php $form =  ActiveForm::begin(); ?>
    <div class="form-group">
        <?= \kartik\select2\Select2::widget(  [
            'name'=>'users',
            'options' => ['multiple'=>true, 'placeholder' => 'Emails ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term,template_certificate_id:'.$template_certificate_id.'}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
            ],
        ]);
        ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>