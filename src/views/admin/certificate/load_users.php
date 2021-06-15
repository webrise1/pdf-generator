<?php
use yii\widgets\ActiveForm;
?>
<?php
$return_link= \yii\helpers\Html::a('Вернуться',['/pdfgenerator/admin/certificate','template_certificate_id'=>$template_certificate_id], ['class' => 'btn btn-success'])  ;

    if($data):
$count_users= count($data['users']);
$i=1;
?>
<?php $form =  ActiveForm::begin(); ?>
<?=\yii\helpers\Html::hiddenInput('template_certificate_id',$template_certificate_id)?>

<?php if(count($data['already_added_users'])):?>
    <h3>Список уже добавленных сертификатов</h3>
    <?php  foreach($data['already_added_users'] as $already_added_user):?>
<div style="color:grey"><?=$already_added_user?></div>
    <?php endforeach;?>
<?php endif;?>

<?php if(count($data['not_found_users'])):?>
    <h3>Список ненайденных пользователей</h3>
    <?php foreach($data['not_found_users'] as $not_found_user):?>
 <div style="color:red"><?=$not_found_user?></div>
    <?php endforeach;?>
<?php endif;?>
<?php if($count_users):?>
    <h3>Список пользователей</h3>
    <?php  foreach($data['users'] as $user):?>
        <div style="color:green"><?=$i.'. '?><?=$user->email?> (<?=$user->name.' '.$user->surname?>)</div>
        <?=\yii\helpers\Html::hiddenInput('users[]',$user->id)?>
        <?php $i++; endforeach;?>

    <h3>Добавить <?=$count_users?> сертификата(ов)?</h3>
    <div class="form-group">
        <?= \yii\helpers\Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>
<?php else:?>
        <h3>Не найдены пользователи для добавления сертификатов</h3>
    <?= $return_link ?>
<?php endif;?>
<?php ActiveForm::end(); ?>
<?php else:?>
    <?php Yii::$app->session->getFlash('success')?>
        <?= $return_link ?>

    <?php endif;?>
