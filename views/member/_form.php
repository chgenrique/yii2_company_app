<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StaffMember */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-member-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'departament_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'member_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_hire')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
