<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//$this->title = 'Login';
//$this->params['breadcrumbs'][] <?= Html::csrfMetaTags()
?>
<div class="logo">
    <?= Html::csrfMetaTags() ?>
        <!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
        
        
        <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'class' => 'login-form',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that
			<label class="control-label visible-ie8 visible-ie9">Username</label>-->
			<div class="input-icon">
			<i class="fa fa-user"></i>
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true,  'class'=>'form-control placeholder-no-fix', 'autocomplete'=>"off", 'placeholder'=>"Username", 'name'=>"username"]) ?>
                        </div>
        </div>

        <div class="form-group"> <!--
            <label class="control-label visible-ie8 visible-ie9">Password</label> -->
            <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control placeholder-no-fix', 'autocomplete'=>"off",'placeholder'=>"Password",'name'=>"password"]) ?>
            </div>
        </div>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login <i class="m-icon-swapright m-icon-white"></i>', ['class' => 'btn green-haze pull-right', 'name' => 'login-button']) ?> 
            </div>
        </div>

        <?php ActiveForm::end(); ?>
	<!-- END LOGIN FORM -->
</div>
        
</div>
