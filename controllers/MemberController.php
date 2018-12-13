<?php

namespace app\controllers;

use Yii;
use app\models\member\StaffMember;
use app\models\member\SearchStaffMember;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * StaffMemberController implements the CRUD actions for StaffMember model.
 */
class MemberController extends Controller
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
                'only' => ['login', 'logout', 'signup', 'create', 
                           'index', 'update', 'delete', 'view', 'deletemembers'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'], // guest
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout','index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'view', 'deletemembers'],
                        'roles' => ['member','admin'],
                    ],
                ],
            ]
        ];
    }
    
    /**
     * Lists all StaffMember models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchStaffMember();
        $model = new StaffMember();      
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    

    /**
     * Displays a single StaffMember model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StaffMember model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StaffMember();
        $searchModel = new SearchStaffMember();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $request = Yii::$app->request;
        
        if($request){
            
            // Submit
//            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//                    return ActiveForm::validate($model);
//                  }
//               if ($model->load(Yii::$app->request->post())) {
//                   $errors = false;
//                    $success = 2;
//                    if($model->validate() && $model->save()){
//                        return $this->redirect(['index']);
//                        $success = 1;
//                    }else {
//                        // validation failed: $errors is an array containing error messages
//                        $errors = $model->getErrors();
//                    }
//                    echo json_encode(array('success'=>$success, 'errors'=>$errors));
//                    return;
//                } else {
//                    return $this->renderAjax('create', [
//                      'model' => $model,
//                    ]);
//            }
            
            if($request->post()){
                $model->member_name = trim($request->post('memberName'));
                $model->department_id = $request->post('memberId');
                $model->date_hire = $request->post('dateHire');
                $errors = false;
                $success = self::ERROR;
                if($model->validate()){
                    $date = date_create($request->post('dateHire'));
                    if($date) $model->date_hire = date_format($date,"Y-m-d");
                    $model->save();
                    $success = self::SUCCESS_OK;
                }else {
                    // validation failed: $errors is an array containing error messages
                    $errors = $model->getErrors();
                }
                echo json_encode(array('success'=>$success, 'errors'=>$errors));
                return;
                
            } else {
                if ($request->isAjax) {
                    return $this->renderAjax('create', [
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
        
        } // End if request
    }

    /**
     * Updates an existing StaffMember model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id=null)
    {  
        if($id) {
            $model = $this->findModel($id);
        }else {
            $model = new StaffMember();
        }
            
        $searchModel = new SearchStaffMember();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $request = Yii::$app->request;
 
        if ($request->post()) {
            
            $model = $this->findModel($request->post('memberId')); 
           // $model = Student::find()->where(['id' => $id])->one();
            if($request->post('dateHire')){
                $date = date_create($request->post('dateHire'));
                $model->date_hire = date_format($date,"Y-m-d");
            }
            $model->department_id = $request->post('deptMemberId');
            $model->member_name = $request->post('memberName');
            $model->id = $request->post('memberId');
            try {
                $errors = false;
                $success = self::ERROR;
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
        } else {
            if ($request->isAjax) {
                $model->date_hire = date("m/d/Y",strtotime($model->date_hire));
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
     * Deletes an existing StaffMember model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $deleted = $this->findModel($id)->delete();
        if($deleted){
            echo json_encode(array('success'=>self::SUCCESS_OK));
        }else
        {
            echo json_encode(array('success'=>self::ERROR));
        }
    }
    
    public function actionDeletemembers()
    {
        $request = Yii::$app->request;
        
        if($request->post('keys')){
            foreach($request->post('keys') as $id){
                $this->findModel($id)->delete();
            }
            echo json_encode(array('success'=>  self::SUCCESS_OK));
        }else{
            echo json_encode(array('success'=>  self::ERROR));
        }
    }

    /**
     * Finds the StaffMember model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffMember the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaffMember::findOne($id)) !== null) {
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
