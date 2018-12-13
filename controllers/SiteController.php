<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //return $this->render('index');
        return $this->redirect(['login']);
        //return $this->redirect(['department/index']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
//    public function actionLoginOriginal()
//    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        }
//        return $this->render('login', [
//            'model' => $model,
//        ]);
//    }
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['department/index']);
        }
        
        $model = new LoginForm();
        //if ($model->load(Yii::$app->request->post())) {
        if (Yii::$app->request->post()) {
            $model->username = Yii::$app->request->post('username');
            $model->password = Yii::$app->request->post('password');
            if($model->login()){
                return $this->redirect(['department/index']);;
            }
        }
        return $this->render('login', [
         'model' => $model,
        ]); 
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionCompany()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && 
                $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('company', [
            'model' => $model,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && 
                $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionLanguage()
    {
        if(Yii::$app->request->post('_lang') !== NULL && 
                array_key_exists(\Yii::$app->request->post('_lang'), \Yii::$app->params['languages']))
        {
            \Yii::$app->language = \Yii::$app->request->post('_lang');
            $cookie = new \yii\web\Cookie([
                'name'=> '_lang',
                'value'=>  \Yii::$app->request->post('_lang')
            ]);
            \Yii::$app->getResponse()->getCookies()->add($cookie);
        }
        
        \Yii::$app->end();
                
    }
    
    public function actionLang($id)
    {
        $lang = $id;
        if($lang !== NULL && array_key_exists($lang, \Yii::$app->params['languages']))
        {
            \Yii::$app->language = $lang;
            $cookie = new \yii\web\Cookie([
                'name'=> '_lang',
                'value'=>  $lang
            ]);
            \Yii::$app->getResponse()->getCookies()->add($cookie);
        }
        
       //\Yii::$app->end();

       //return $this->redirect(['index']);
       return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }
}
