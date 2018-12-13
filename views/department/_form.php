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
<div class="department-form" style="width: 50%;">

    <?php
      if($model->isNewRecord) {
    ?>
        <?php $form = ActiveForm::begin(['id' => 'form-dpto', 
                                        'action' => ['department/create'],
                                        'options' => ['method' => 'post', 'data-pjax' => true]]); ?>
    <?php } 
       else  
           { $form = ActiveForm::begin(['id' => 'form-dpto',
                                       'options' => ['data-pjax' => true]]); ?>
            
     <?php  } ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'id', ['options' => ['value'=> $model->id] ])->hiddenInput()->label(false)?>

    <div class="form-group">
        
        <?php
            if($model->isNewRecord){
                echo Html::button(Yii::t('app',Yii::t('app','Save')), ['class' => 'btn btn-success', 
                                                                       'id'=> 'buttonSave']);
            }else{
                echo Html::button(Yii::t('app',Yii::t('app','Update')), 
                        ['class' => 'btn btn-primary',
                         'name'=>'buttonUpdate', 
                         'id'=> 'buttonUpdate']);
            }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
