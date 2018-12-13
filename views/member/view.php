<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\StaffMember */

//$this->title = $model->id;
$this->title = $model->member_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Staff Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-member-view">

    <p>
        <?php
           $t = '/member/update/'.$model->id;
           echo Html::button(Yii::t('app','Update'), ['value'=>Url::to($t), 
                                                      'class' => 'btn btn-primary view_update_button']);
        ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger view_del',
            'data-confirmation' => Yii::t('app','Are you sure you want to delete this item?'),
            'data-id' => $model->id,
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
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
