<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StaffMember */

//$this->title = $model->id;
$this->title = $model->member_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Staff Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-member-view">

    <p>
        
        <?= Html::hiddenInput('hidden-member-input',$model->id,['id'=>'hidden-member-id', 
            'message'=> Yii::t('app','Are you sure you want to delete this item?'),
            'button-cancel' => Yii::t('app','Cancel'),
            'button-ok' => Yii::t('app','OK'),]); ?>

    </p>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'department_id',
            [   // the owner name of the model
                'attribute' => 'department.name',
                'label' => Yii::t('app','Department'),
            ],
            [                      // the owner name of the model
                'attribute' => 'member_name',
                'label' => Yii::t('app','Member Name'),
            ],
            [
                'attribute' => 'date_hire',
                'label' => Yii::t('app','Date of Hire')
            ]
        ],
    ]) ?>

</div>
