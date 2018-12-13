<?php

use yii\widgets\ActiveForm;
use app\models\department\Department;
use yii\helpers\ArrayHelper;

use dlds\metronic\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\StaffMember */
/* @var $form yii\widgets\ActiveForm */
// ArrayHelper::map
//     <?$form->field($model, 'departament_id')->dropDownList(ArrayHelper::map(Department::find()->all(), 'id', 'name'),
//     ['class'=>'form-control inline-block'],['prompt' => '-- Select Department --'])->label('Department')
// <?= $form->field($model,'date_hire')->input('date')->label(Yii::t('app','Date of Hire'))
?>

<div class="staff-member-form">
    
    <?php if($model->isNewRecord) 
    {  
        $form = ActiveForm::begin(['id' => 'form-member-create', 'action' => ['member/create'],
                        'options' => ['data-pjax' => true, 'method' => 'post', 'class' => 'col-md-6',]]);
    } else 
    { 
        $form = ActiveForm::begin(['id' => 'form-member-update', 'options' => ['data-pjax' => true, 'method' => 'post',]]);
    } ?>

    <?= $form->field($model, 'department_id')->dropDownList(ArrayHelper::map(Department::find()->select(
            ['name','id'])->all(), 'id', 'name'),
            ['class'=>'form-control inline-block'],
            ['prompt' => Yii::t('app','-- Select Department --')])->label(Yii::t('app','Department')) ?>
     
    <?= $form->field($model, 'id', ['options' => ['value'=> $model->id]])->hiddenInput()->label(false)?>
     
    <?= $form->field($model, 'member_name')->textInput(['maxlength' => true])->label(Yii::t('app','Member Name')) ?>
    
    <?= $form->field($model, 'date_hire')->widget(DatePicker::className(), [
            'inline' => false,
            'options' => [
                'class' => 'form-control form-control-inline date-picker',
                ///'class' => 'form-control form-control-inline input-medium date-picker',
            ],
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'mm/dd/yyyy',
                'startDate' => date('01/01/1960'),
                'endDate' => date(''),
            ],
        ])->label(Yii::t('app','Date of Hire')) ?>
    
    <?php ActiveForm::end(); ?>
   
</div>