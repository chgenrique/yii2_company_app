<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

use app\assets\AppAsset;
use dlds\metronic\Metronic;
use dlds\metronic\helpers\Layout;
use app\assets\MetronicAsset;

use Yii;

AppAsset::register($this);
$asset = Metronic::registerThemeAsset($this);

MetronicAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl($asset->sourcePath);

?>
<?php $this->beginPage() ?>
<!--[if IE 8]> <html lang="<?= Yii::$app->language ?>" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="<?= Yii::$app->language ?>" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
        
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta name="MobileOptimized" content="320">
    <link rel="shortcut icon" href="../favicon.ico' ?>"/>
</head>

<?php $flagsUrl = ['en'=>'us', 'es'=>'es', 'ru'=>'ru','fr'=>'fr']; ?>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body <?= Layout::getHtmlOptions('body',['class'=>'login'],true) ?> >

    <?php $this->beginBody(); ?>
    
    <div class="logo">
        <a>
            <img src="<?php echo Metronic::getAssetsUrl($this) . '/img/logo-big.png' ?>" alt="">
        </a>
    </div>
        
    <div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="login" method="post">
            <h3 class="form-title">Login to your account</h3>
            <h3 class="form-title"><?php Yii::t('app','Login to your account'); ?></h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter any username and password.</span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9"><?php Yii::t('app','Username'); ?></label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" id="username" autocomplete="off" placeholder="Username" name="username">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9"><?php Yii::t('app','Password'); ?></label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" id="password" autocomplete="off" placeholder="Password" name="password">
			</div>
		</div>
                
                <div>
                    <ul class="nav navbar-nav pull-left">
                        <li class="dropdown dropdown-language">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                <img alt="" src="<?php echo Metronic::getAssetsUrl($this) . '/global/img/flags/'.$flagsUrl[Yii::$app->language].'.png' ?> ">
                                <span class="langname"> <?php echo strtoupper(Yii::$app->language) ?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                
                            <?php
                                $languages = Yii::$app->params['languages'];
                                foreach($languages as $key=>$lang)
                                {
                                    if(Yii::$app->language != $key){
                                        echo "<li>";
                                        echo "<a href='/site/lang?id=".$key."'>"; ?>
                                <img alt="" src="<?php echo Metronic::getAssetsUrl($this) . '/global/img/flags/'.$flagsUrl[$key].'.png' ?> "> <?php echo ucfirst($lang);?> </a>
                                        <?php echo "</li>";
                                    }
                                }  
                            ?>
                            </ul>
                        </li>
                    </ul>
                </div>

		<div class="form-actions">
		    <button type="submit" class="btn green pull-right" name="login_submit">
			Login
		    </button>
                    <div class="clearfix"></div>
		</div>
		
	</form>
	<!-- END LOGIN FORM -->
</div>

<?php $this->endBody() ?>
    
</body>
<!-- END BODY -->


</html>
<?php $this->endPage() ?>
