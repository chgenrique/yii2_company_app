<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Department */
/* @var $form yii\widgets\ActiveForm */

/*<?= Html::a('Hide', ['/department/index'], ['class'=>'btn btn-warning grid-button']) ?>*/
// 'action' => ['department/create'],
// <?= Html::submitButton('Save', ['class' => 'btn btn-success']) 
// <h1><?= Html::encode(Yii::t('app','Update Department'))

if(!$model->isNewRecord){
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
}

?>
<div class="department-form">

    <?php
      if($model->isNewRecord) {
    ?>
        <?php $form = ActiveForm::begin(['id' => 'form-dpto-create', 
                                        'action' => ['department/create'],
                                        'options' => ['method' => 'post', 'data-pjax' => true, 'class' => 'col-md-6',]]); ?>
    <?php } 
       else  
           { $form = ActiveForm::begin(['id' => 'form-dpto-update',
                                       'options' => ['data-pjax' => true]]); ?>
            
     <?php  } ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'id', ['options' => ['value'=> $model->id] ])->hiddenInput()->label(false)?>

    <?php ActiveForm::end(); ?>

</div>
