<?php

namespace app\controllers;

use Yii;
use app\models\department\Department;
use app\models\department\SearchDepartment;
use app\models\member\StaffMember;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DepartmentController implements the CRUD actions for Department model.
 */
class DepartmentController extends Controller
{
    const SUCCESS_OK = 1;
    const ERROR = 2;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup', 'create', 'update', 
                           'index', 'delete', 'view', 'deleteall'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'], // guest
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout','index'],
                        'roles' => ['@'], // authenticated
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'view', 'deleteall'],
                        'roles' => ['admin'],
                    ],
                ],
                /*'denyCallback' => function ($rule, $action) {
                    throw new \Exception('You are not allowed to access this page');
                }*/
            ],
        ];
    }

    /**
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Department();
        $searchModel = new SearchDepartment();
        //$this->initialData();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    
//    private function initialData(){
//        $model = new Department();
//        $elements = $model->findAll();
//        if(count($elements)==0)
//        {
//            $urlInitialData = "http://localhost/php_rest_api/api.php";
//            $departmentsJson = file_get_contents($urlInitialData);
//            $departmentsArray = json_decode($departmentsJson);
//            if(count($departmentsArray)){
//            foreach($departmentsArray as $element){
//                    $this->dptoModelInstance->setId($element->id); 
//                    $this->dptoModelInstance->setName($element->name); 
//                    $this->dptoModelInstance->addDepartment();
//                }
//            }
//        }
//        
//    }

    /**
     * Displays a single Department model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Department();
        $searchModel = new SearchDepartment();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $request = Yii::$app->request;
       
        if ($request->post()) {
            if ($model->load(Yii::$app->request->post())) {
                $model->name = trim($model->name);
            }else if($request->post('dpto')){
                $model->name = trim($request->post('dpto'));
            }
            try {
                $errors = false;
                $success = self::ERROR;
                if($model->validate()){
                    $id = Department::find()->orderBy("id DESC")->one();
                    $newId = 1;
                    if($id['id']){
                        $newId = $id['id']+1;
                    }
                    $model->id = $newId;
                    if($model->save()){
                        $success = self::SUCCESS_OK;
                    }
                }else {
                    // validation failed: $errors is an array containing error messages
                    $errors = $model->getErrors();
                }
                echo json_encode(array('success'=>$success, 'errors'=>$errors));
                return;
            } catch (Exception $ex) {
                die(var_dump($ex->getMessage()));
                return $this->renderAjax('index', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'error' => $ex->getMessage()
                ]);
            }
        } else {
            if($request->isAjax) {
                return $this->renderAjax('create', [
                    'model' => $model,]);
                } else {
                    return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
                    ]);
                }
        }
    }

    /**
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id=null)
    {
        if($id){
            $model = $this->findModel($id);
        }else {
            $model = new Department();
        }
        $searchModel = new SearchDepartment();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $request = Yii::$app->request;
        if($request->post()){
            $model = $this->findModel($request->post('dptoId'));
            $model->name = $request->post('dpto');
            try {
                $errors = false;
                $success = self::ERROR; // Use contants for improve this code
                if($model->validate() && $model->save()){
                    $success = self::SUCCESS_OK;
                }else {
                    // validation failed: $errors is an array containing error messages
                    $errors = $model->getErrors();
                }
                echo json_encode(array('success'=>$success, 'errors'=>$errors));
                return;
                
            } catch (Exception $ex) {
                return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'error' => $ex->getMessage()
                ]);
            }
        }else {
            if ($request->isAjax) {
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Department model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        StaffMember::deleteAll(['department_id'=>$id]);
        
        $res = $this->findModel($id)->delete();
        if($res){
            echo json_encode(array('success'=>self::SUCCESS_OK));
            return;
        }
        echo json_encode(array('success'=>self::ERROR));
    }
    
    
    public function actionDeleteall()
    {
        $request = Yii::$app->request;
        
        if($request->post('keys')){
            StaffMember::deleteAll(['department_id'=>$request->post('keys')]);
            foreach($request->post('keys') as $id){
                $this->findModel($id)->delete();
            }
            echo json_encode(array('success'=>  self::SUCCESS_OK));
            return;
        }
        echo json_encode(array('success'=>  self::ERROR));
    }
    

    /**
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Department::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
        
       return $this->redirect(['index']);
    }
}
