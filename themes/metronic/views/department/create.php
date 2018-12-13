<?php

/* @var $this yii\web\View */
/* @var $model app\models\Department 
<h1><?= Html::encode($this->title) ?></h1>
 *  */

$this->title = Yii::t('app','Create Department');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Create Department'), 
                                  'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
