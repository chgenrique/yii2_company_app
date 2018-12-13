<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

use app\assets\AppAsset;
use dlds\metronic\Metronic;
use dlds\metronic\helpers\Layout;

use dlds\metronic\widgets\NavBar;
use dlds\metronic\widgets\Menu;
use dlds\metronic\widgets\Badge;
use dlds\metronic\widgets\Nav;

use app\assets\MetronicAsset;

MetronicAsset::register($this);


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

    <?php
    
    if(!Yii::$app->user->isGuest){
    ?>
    <body <?= Layout::getHtmlOptions('body',['class'=>'page-container-bg-solid metronic-body'],true) ?> >
    
    <?php
    
    $this->beginBody();

    NavBar::begin(
            [
                'brandLabel' => 'My Company',
                'brandLogoUrl' => Metronic::getAssetsUrl($this) . '/img/logo.png',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => Layout::getHtmlOptions('header', false)
            ]
    );
    $languages = Yii::$app->params['languages'];
    $langItems = [];
    
    $flagsUrl = ['en'=>'us', 'es'=>'es', 'ru'=>'ru','fr'=>'fr'];
    
    foreach($languages as $key=>$lang)
    {
        //$langItems[] = ['label' => '', Html::a(strtoupper($lang), ['lang', 'id' => $key], ['class' => 'btn btn-link'])];
       //echo Html::a(strtoupper($lang), ['lang', 'id' => $key], ['class' => 'btn btn-link']);
       //$langItems[] = ['label' => echo "<img alt="" src=". echo (Metronic::getAssetsUrl($this) . '/global/img/flags/es.png'); ">" strtoupper($lang), 'url' => '/site/lang?id='.$key];
   
        if(Yii::$app->language != $key){
            $langItems[] = ['label' => '<img src=" '. Metronic::getAssetsUrl($this) . '/global/img/flags/'.$flagsUrl[$key].'.png' .'" >&nbsp;<span>'.strtoupper($lang).'</span>','url' => '/site/lang?id='.$key];
        }
    }  

    $menuItems = [];
    
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
                    'label' => Yii::$app->user->identity->username,
                    'items' => [
                        Yii::$app->user->isGuest ? (
                        ''
                        ) : (
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                Yii::t('app','Logout'),
                                ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</li>'
                        ),
                    ]
                ];
        $menuItems[] = [
            'label' => '<img src=" '. Metronic::getAssetsUrl($this) . '/global/img/flags/'.$flagsUrl[Yii::$app->language].'.png' .'" >&nbsp;<span>'.strtoupper(Yii::$app->language).'</span>',
            'items' => $langItems,
            ];
    }
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav pull-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    
        NavBar::end();
        ?>
        <?=
        (Metronic::getComponent() && Metronic::getComponent()->layoutOption == Metronic::LAYOUT_BOXED) ?
                Html::beginTag('div', ['class' => 'container']) : '';
        ?>
        
        
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->

                            <li class="nav-item start ">
                                <a href="/department/index" class="nav-link nav-toggle">
                                    <i class="fa fa-cogs"></i>
                                    <span class="title"><?= Yii::t('app','Departments') ?> </span>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a href="/member/index" class="nav-link nav-toggle">
                                    <i class="icon-diamond"></i>
                                    <span class="title"><?= Yii::t('app','Members') ?></span>
                                </a>
                            </li>
                            
                        </ul>
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content" style="min-height: 1144px;">
                        <!-- BEGIN PAGE CONTENT-->
                        <div class="row">
                            <div class="col-md-12">
                                <?= $content ?>
                            </div>
                        </div>
                        <!-- END PAGE CONTENT-->
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                
            </div>
        
        <!-- END CONTAINER -->
        

    <!-- BEGIN FOOTER -->
        <div class="footer">
            <div class="footer-inner">
                <?= date('Y') ?> &copy; YiiMetronic.
                
            </div>
        </div>
        <?= (Metronic::getComponent() && Metronic::getComponent()->layoutOption == Metronic::LAYOUT_BOXED) ? Html::endTag('div') : ''; ?>
    
    <?php $this->endBody() ?>
    
    </body>
    <!-- END BODY -->
    
    <?php
    } else 

        {
        
        ?>

        <!-- BEGIN CONTENT -->
            <?= $content ?>
        <!-- END CONTENT -->

        <?= (Metronic::getComponent() && Metronic::getComponent()->layoutOption == Metronic::LAYOUT_BOXED) ? Html::endTag('div') : ''; ?>
    <?php } ?>


</html>
<?php $this->endPage() ?>