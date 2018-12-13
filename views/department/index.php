<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\assets\DepartmentAssets;
use app\components\NewModal\NewModal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchDepartment */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*
 * <p>
 *      <?= Html::a(Yii::t('app','Create Department'), ['create'], 
 * ['class' => 'btn btn-success', 'id' => 'createDpto']) ?>
 * 
        <?= Html::button(Yii::t('app','Create Department 2'), 
 * ['value'=> 'create', 'class' => 'btn btn-success', 'id' => 'createDptoModal']) ?>
    </p>
 */

DepartmentAssets::register($this);

$this->title = Yii::t('app','Departments');
$this->params['breadcrumbs'][] = $this->title;


?>


<div class="department-index">
    
<?php   
    NewModal::begin([
        'id' => 'modal-department',
        'title' => Yii::t('app','Create Department'),
        'closeButton' => [
          'label' => 'Close',
          'class' => 'btn btn-danger btn-sm pull-right',
        ],
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContentCreateView'></div>";
    NewModal::end();

    NewModal::begin([
        'id'=>'modalUpdate',
        'size'=>'modal-md', 
        'title' => Yii::t('app','Update Department'),
        'closeButton' => [
          'label' => 'Close',
          'class' => 'btn btn-danger btn-sm pull-right',
        ]]
        );
        echo "<div id='modalContentUpdate'></div>";
    NewModal::end();
    
    
    NewModal::begin([
        'id'=>'modalView',
        'size'=>'modal-md', 
        'title' => Yii::t('app','View Department'),
        'closeButton' => [
          'label' => 'Close',
          'class' => 'btn btn-danger btn-sm pull-right',
        ]]
        );
        echo "<div id='modalContentView'></div>";
    NewModal::end();
    
 Pjax::begin(['id'=>'departmentAjax']); ?>
    
<p>
    <?php
    //return Html::a($model->id, ['department/update'],['class'=>"update-dialog","data-form-id"=>$model->id]);  
    if(Yii::$app->user->can('department/create')){
        $t = '/department/create';   
        echo Html::button(Yii::t('app','Create Department'), 
                ['value'=>Url::to($t), 'class' => 'btn btn-success button_create']);
    }
    ?>          
</p>

<h2><?= Html::encode(Yii::t('app','List of Departments')) ?></h2>
    
    <?= GridView::widget([
        'id' => 'gridDepartment',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn',
             'visible' => Yii::$app->user->can('department/deleteall'),
            ],
            'name',
            ['class' => 'yii\grid\ActionColumn',
            'header'=> (Yii::$app->user->can('department/deleteall')) ?
                Html::button(Yii::t('app','Delete Departments'),
                    ['class' => 'btn btn-primary', 
                     'id'=> 'deleteDpto',
                     'data-confirmation' => Yii::t('app','Are you  sure you want to delete these items?'), 
                    ]) :
                '',
            'buttons'=> [
                'view'=>function ($url, $model) {
                    $t = '/department/view/'.$model->id;
                    return Yii::$app->user->can('department/view') ? 
                        Html::button ('<span class="glyphicon glyphicon-eye-open"></span>', 
                        ['value'=>Url::to($t),
                        'class' => 'btn btn-default btn-xs custom_button_view']) :
                        '';
                   },  
                'update'=>function ($url, $model) {
                    $t = '/department/update/'.$model->id;
                    return Yii::$app->user->can('department/update') ? Html::button
                            ('<span class="glyphicon glyphicon-pencil"></span>', 
                            ['value'=>Url::to($t), 
                            'class' => 'btn btn-default btn-xs custom_button'
                            ]) : '';
                },
                'delete' => function ($url, $model) {
                    $t = '/department/delete/'.$model->id;
                    return Yii::$app->user->can('department/delete') ? Html::button
                            ('<span class="glyphicon glyphicon-trash"></span>', 
                            ['value'=>Url::to($t), 
                            'class' => 'btn btn-default btn-xs delete_button',
                                'data-id'=>$model->id
                           //'data' => ['confirm' => 'Are you  sure you want to delete this item?']
                            ]) : '';
                    
//                    return (Yii::$app->user->can("department/delete")) ? Html::
//                            a('<span  class="glyphicon glyphicon-trash"></span>', $url, 
//                            ['class'=>'ajaxDelete','delete-url'=>$url, 
//                            'pjax-container'=>'departmentAjax',
//                            'title'=> Yii::t('app', 'Delete'), 
//                            'data-method' => 'post',
//                            'data' => 
//                                ['confirm' => 'Are you  sure you want to delete this item?']]) : '';
                    }
                ],
            ]
        ],
    ]); ?>
</div>

<?php Pjax::end(); ?>