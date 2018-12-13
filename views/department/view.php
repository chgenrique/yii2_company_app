<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Department 
<h1><?= Html::encode($this->title) ?></h1> 
 <?= Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to($t), 'class' => 'btn btn-default btn-xs custom_button']); ?>
 *  */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-view">

    <p>
        <?php
            $t = '/department/update/'.$model->id;
            echo Html::button(Yii::t('app','Update'), 
                    ['value'=>Url::to($t), 
                     'class' => 'btn btn-primary view_update_button'
                    ]);
        ?>
        
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger view_del',
            'data-id' => $model->id,
            'data-confirmation' => Yii::t('app','If you delete this item must be delete the staff member associated to. Do you want to delete this item?'),
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
        ],
    ]) ?>
</div>
