<?php
use webrise1\filemanager\models\File;
use kartik\select2\Select2;
use yii\web\JsExpression;
$url = \yii\helpers\Url::to(['file-list']);

if($model->css_files){
    $model->css_files=explode(',',$model->css_files);
    foreach($model->css_files as $css_file_snippet){
        $file_id=File::getIdFromSnippet($css_file_snippet);
        $ids_files[]=$file_id;
    }
    $model->css_files=$ids_files;
    $str_ids_files=implode(',',$ids_files);
}

if($str_ids_files)
    $dataList = \webrise1\filemanager\models\File::find()
        ->andWhere(['id'=> $ids_files])
        ->orderBy([new \yii\db\Expression('FIELD (id, ' . $str_ids_files . ')')])
        ->all();
if($dataList)
    $data = \yii\helpers\ArrayHelper::map($dataList,  'id','name');

echo $form->field($model, 'css_files')->widget(Select2::classname(), [
    'data' => $data,
    'options' => ['multiple'=>true, 'placeholder' => 'Search for a city ...'],
    'pluginOptions' => [
        'maintainOrder'=>true,
        'allowClear' => true,
        'minimumInputLength' => 3,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
            'url' => $url,
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(city) { return city.text; }'),
        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
    ],
]); ?>