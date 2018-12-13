<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchStaffMember */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-member-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'department_id') ?>

    <?= $form->field($model, 'member_name') ?>

    <?= $form->field($model, 'date_hire') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
