<?php

/* @var $this yii\web\View */
/* @var $model app\models\StaffMember */

$this->title = Yii::t('app','Update Staff Member: ') . $model->member_name;
$this->params['breadcrumbs'][] = ['label' => 'Staff Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 
                                  'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-member-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
