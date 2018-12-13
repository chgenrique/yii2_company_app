<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\assets\MetronicDepartmentAsset;
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

MetronicDepartmentAsset::register($this);

$this->title = Yii::t('app','Departments');
$this->params['breadcrumbs'][] = $this->title;

?>
    
<?php   
    NewModal::begin([
        'id' => 'modal-department',
        'class' => 'modal form fade',
        'header' => Yii::t('app','Create Department'),
    ]);
    echo "<div class='row' id='modalContentCreateView'></div>";
    echo "<div class=\"modal-footer\">";
    echo "<button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-outline dark\">".Yii::t('app','Cancel')."</button>";
    echo "<button type=\"button\" id=\"buttonSave\" class=\"btn green\" data-dismiss=\"modal\">".Yii::t('app','Save')."</button>";
    echo "</div>";
            
    NewModal::end();

    NewModal::begin([
        'id'=>'modalUpdate',
        'class' => 'modal form fade',
        'header' => Yii::t('app','Update Department'),
        ]
        );
        echo "<div id='modalContentUpdate'></div>";
        echo "<div class=\"modal-footer\">";
        echo "<button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-outline dark\">".Yii::t('app','Cancel')."</button>";
        echo "<button type=\"button\" id=\"buttonUpdate\" class=\"btn green\" data-dismiss=\"modal\">".Yii::t('app','Update')."</button>";
        echo "</div>";
    NewModal::end();
    
    
    NewModal::begin([
        'id'=>'modalView',
        'class' => 'modal form fade',
        'header' => Yii::t('app','View Department'),
        ]);
        echo "<div id='modalContentView'></div>";
        echo "<div class=\"modal-footer\">";
        echo "<button type=\"button\" data-dismiss=\"modal\" "
        . "class=\"btn btn-outline dark\">".Yii::t('app','Cancel')."</button>";
        echo "<button type=\"button\" id=\"buttonUpdate\" class=\"btn green view_update_button\" "
        . "data-dismiss=\"modal\">".Yii::t('app','Update')."</button>";
        echo "<button type=\"button\" id=\"buttonDel\" "
                . "class=\"btn red-mint view_del_btn\" "
                . "'button-cancel' =".Yii::t('app','Cancel')." "
                . "'button-ok' = ".Yii::t('app','OK')." 'data-confirmation' = "
                . "". Yii::t('app','If you delete this item must be delete the staff member associated to. Do you want to delete this item?').
                " data-dismiss=\"modal\">".Yii::t('app','Delete')."</button>";
        
//        echo Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-outline red-mint view_del',
//            'data-id' => $model->id,
//            'data-toggle'=> "modal",
//            'data-confirmation' => Yii::t('app','If you delete this item must be delete the staff member associated to. Do you want to delete this item?'),
//            'data' => [
//                'method' => 'post',
//            ],
//        ]);
        echo "</div>";
    NewModal::end();
    
 Pjax::begin(['id'=>'departmentAjax']); ?>
    
<p>
    <?php
    //return Html::a($model->id, ['department/update'],['class'=>"update-dialog","data-form-id"=>$model->id]);  
    if(Yii::$app->user->can('department/create')){
        $t = '/department/create';   
        echo Html::button(Yii::t('app','Create Department'), 
                ['value'=>Url::to($t),
                    'class' => 'btn btn-outline green-meadow button_create']);
    }
    ?> 
</p>

<div class="portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-bell-o"></i>
            <?= Html::encode(Yii::t('app','List of Departments')) ?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
            <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
            <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
            <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
        </div>
    </div>
    <div class="portlet-body" style="display: block;">
        <div class="table-scrollable">
        <?= GridView::widget([
            'id' => 'gridDepartment',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class'=>"table table-striped table-bordered table-advance table-hover"],
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'visible' => Yii::$app->user->can('department/deleteall'),
                ],
                [
                    'attribute' => 'name',
                    'label'=>'<i class=\'fa fa-home\'></i> '. Yii::t('app', 'Name'),
                    'encodeLabel' => false,
                ],
                ['class' => 'yii\grid\ActionColumn',
                'header'=> (Yii::$app->user->can('department/deleteall')) ?
                    Html::button(Yii::t('app','Delete Departments'),
                        ['class' => 'btn btn-outline blue-sharp',
                            'id'=> 'deleteDpto',
                            'data-confirmation' => Yii::t('app','Are you sure you want to delete these items?'),
                            'button-cancel' => Yii::t('app','Cancel'),
                            'button-ok' => Yii::t('app','OK'),]):
                        '',
                'buttons'=> [
                    'view'=>function ($url, $model) {
                        $t = '/department/view/'.$model->id;
                        return Yii::$app->user->can('department/view') ? 
                            Html::button ('<i class="fa fa-eye"></i>'.  Yii::t('app','View'), 
                            ['value'=>Url::to($t),
                                'class' => 'btn btn-outline btn-circle btn-sm blue custom_button_view']) :
                            '';
                       },  
                    'update'=>function ($url, $model) {
                        $t = '/department/update/'.$model->id;
                        return Yii::$app->user->can('department/update') ? Html::button
                                ('<i class="fa fa-edit"></i>'.Yii::t('app','Edit'), 
                                ['value'=>Url::to($t), 
                                'class' => 'btn btn-outline btn-circle btn-sm purple custom_button']) : 
                            '';
                    },
                    'delete' => function ($url, $model) {
                        $t = '/department/delete/'.$model->id;
                        return Yii::$app->user->can('department/delete') ? Html::button
                                ('<i class="fa fa-trash-o"></i>'.Yii::t('app','Delete'), 
                                ['value'=>Url::to($t), 
                                'class' => 'btn btn-outline btn-circle dark btn-sm black delete_button',
                                    'data-id'=>$model->id,
                                    'message' => Yii::t('app','Are you sure you want to delete this item?'),
                                    'button-cancel' => Yii::t('app','Cancel'),
                                    'button-ok' => Yii::t('app','OK'),]) : 
                            '';
                        }
                    ],
                ]
            ],
        ]); ?>
        </div>
    </div> <!-- END PORTLET BODY -->
</div> <!-- END PORTLET -->
<?php Pjax::end(); ?>
</div>
</div>
