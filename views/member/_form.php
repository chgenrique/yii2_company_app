<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\department\Department;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\StaffMember */
/* @var $form yii\widgets\ActiveForm */
// ArrayHelper::map
//     <?$form->field($model, 'departament_id')->dropDownList(ArrayHelper::map(Department::find()->all(), 'id', 'name'),
//     ['class'=>'form-control inline-block'],['prompt' => '-- Select Department --'])->label('Department')
    
/*
 * <?= Html::a('Cancel', ['/member/index'], ['class'=>'btn btn-warning grid-button']) ?>
 *  
 *  <?= $form->field($model, 'idmember', ['options' => ['value'=> $model->id] ])->hiddenInput()->label(false); ?>
 * 
 * <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), 
 * ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
<h1><?= Html::encode($model->isNewRecord ? Yii::t('app','Create Staff Member') : Yii::t('app','Update Staff Member')) ?></h1>
 * 
 *  $form->field($model, 'date_hire')->widget(DatePicker::className(), ['dateFormat' => 'dd-M-yyyy']) 
<?= Html::button(Yii::t('app','Cancel'), ['class'=>'btn btn-warning grid-button', 'id' => 'buttonCancel']) ?> 

<?= $form->field($model, 'date_hire')->textInput(['type' => 'date']) ?>
 * <?= $form->field($model, 'date_hire')->input('date',['enableAjaxValidation' => true])?> */
?>

<div class="staff-member-form" style="width: 50%;">
    
    <?php if($model->isNewRecord) 
    {  
        $form = ActiveForm::begin(['id' => 'form-member', 'action' => ['member/create'],
                        'options' => ['data-pjax' => true]]);
    } else 
    { 
        $form = ActiveForm::begin(['id' => 'form-member', 'options' => ['data-pjax' => true, ]]);
    } ?>

    <?= $form->field($model, 'department_id')->dropDownList(ArrayHelper::map(Department::find()->select(
            ['name','id'])->all(), 'id', 'name'),
            ['class'=>'form-control inline-block'],
            ['prompt' => Yii::t('app','-- Select Department --')])->label(Yii::t('app','Department')) ?>
     
    <?= $form->field($model, 'id', ['options' => ['value'=> $model->id]])->hiddenInput()->label(false)?>
     
    <?= $form->field($model, 'member_name')->textInput(['maxlength' => true])->label(Yii::t('app','Member Name')) ?>
    
    <?= $form->field($model,'date_hire')->input('date')->label(Yii::t('app','Date of Hire')) ?>
   
    <div class="form-group">
        
        <?php if($model->isNewRecord) {
            echo Html::button(Yii::t('app','Save'), 
            ['class' => 'btn btn-success', 'id'=> 'buttonSave']);
        }else 
        {
            echo Html::button(Yii::t('app','Update'),
            ['class' => 'btn btn-primary', 'id'=> 'buttonUpdate']);
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
