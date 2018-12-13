<?php

/* @var $this yii\web\View */
/* @var $model app\models\Department */

$this->title = Yii::t('app','Update Department: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Departments', 
                                  'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 
                                  'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="department-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
