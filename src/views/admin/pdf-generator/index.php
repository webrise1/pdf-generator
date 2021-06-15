<?php
use yii\helpers\Html;
echo Html::a('<i class="fa far fa-hand-point-up"></i> Privacy Statement', ['/pdfgenerator/admin/pdf-generator/view-privacy'], [
    'class'=>'btn btn-danger',
    'target'=>'_blank',
    'data-toggle'=>'tooltip',
    'title'=>'Will open the generated PDF file in a new window'
]);
?>