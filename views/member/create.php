<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StaffMember */

$this->title = Yii::t('app', 'Create Staff Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Staff Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
