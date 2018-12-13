<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

use app\assets\AppAsset;
use dlds\metronic\Metronic;
use dlds\metronic\helpers\Layout;

use dlds\metronic\widgets\NavBar;
use dlds\metronic\widgets\Menu;
use dlds\metronic\widgets\HorizontalMenu;
use dlds\metronic\widgets\Badge;
use dlds\metronic\widgets\Breadcrumbs;
use dlds\metronic\widgets\Button;
use dlds\metronic\widgets\Nav;


//$asset = Metronic::registerThemeAsset($this);
//$directoryAsset = Yii::$app->assetManager->getPublishedUrl($asset->sourcePath);

AppAsset::register($this);
$asset = Metronic::registerThemeAsset($this);

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
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body <?= Layout::getHtmlOptions('body',['class'=>'page-container-bg-solid'],true) ?> >
    <?php $this->beginBody() ?>
    
    
    <div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="login.php" method="post">
		<h3 class="form-title">Member Login</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter username and password. </span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" id="username" autocomplete="off" placeholder="Username" name="username">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" id="password" autocomplete="off" placeholder="Password" name="password">
			</div>
		</div>
		<div class="form-actions">
			<label class="checkbox">
			<div class="checker"><span><input type="checkbox" name="remember" value="1"></span></div> Remember me </label>
		    <button type="submit" class="btn green-haze pull-right" name="login_submit">
			Login <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		
	</form>
	<!-- END LOGIN FORM -->
</div>
    
        
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            
            
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                            <h3 class="page-title">
                                <?= Html::encode($this->title) ?>
                                <small><?= Html::encode($this->title) ?></small>
                            </h3>
                        </div>
                    </div>
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                        <div class="col-md-12">
                            <?= $content ?>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT-->
                </div>
            </div>
            <!-- END CONTENT -->
    
        </div>
        <!-- END CONTAINER -->

    <!-- BEGIN FOOTER -->
        <div class="footer">
            <div class="footer-inner">
                <?= date('Y') ?> &copy; YiiMetronic.
            </div>
            <div class="footer-tools">
                <span class="go-top">
                    <i class="fa fa-angle-up"></i>
                </span>
            </div>
        </div>
        <?= (Metronic::getComponent() && Metronic::getComponent()->layoutOption == Metronic::LAYOUT_BOXED) ? Html::endTag('div') : ''; ?>
<?php $this->endBody() ?>
</body>
<!-- END BODY -->


</html>
<?php $this->endPage() ?>
