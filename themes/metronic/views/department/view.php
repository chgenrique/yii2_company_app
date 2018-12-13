<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Department */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-view">

    <p>
        
        <?= Html::hiddenInput('hidden-department',$model->id,['id'=>'hidden-department-id', 
            'message'=> Yii::t('app','If you delete this item must be delete the staff member associated to. Do you want to delete this item?'),
            'button-cancel' => Yii::t('app','Cancel'),
            'button-ok' => Yii::t('app','OK'),]); ?>

  <!--      
// Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-outline dark view_del',
//            'data-id' => $model->id,
//            'data-confirmation' => Yii::t('app','If you delete this item must be delete the staff member associated to. Do you want to delete this item?'),
//            'data' => [
//                'method' => 'post',
//            ],
//        ])-->
        
    </p>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
        ],
    ]) ?>

    
</div>
