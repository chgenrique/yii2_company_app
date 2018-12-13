<?php

/* @var $this yii\web\View */
/* @var $model app\models\StaffMember <h1><?= Html::encode($this->title) ?></h1>*/

$this->title = Yii::t('app','Create Staff Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Staff Members'), 
                                  'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-member-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
