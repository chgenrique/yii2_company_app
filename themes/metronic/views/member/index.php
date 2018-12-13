<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\assets\MetronicMemberAsset;
use app\components\NewModal\NewModal;
use yii\helpers\Url;
use Yii;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchStaffMember */
/* @var $dataProvider yii\data\ActiveDataProvider */
 //   <?= Html::a(Yii::t('app','Create Member old'), ['create'], ['class' => 'btn btn-success'])
//  ['class' => 'yii\grid\ActionColumn'],

MetronicMemberAsset::register($this);

$this->title = Yii::t('app','Staff Members');
$this->params['breadcrumbs'][] = $this->title;

?>
<?php   
    NewModal::begin([
        'id' => 'modal-member',
        'class' => 'modal form fade',
        'header' => Yii::t('app','Create Member'),
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
        'header' => Yii::t('app','Update Member'),
        ]);
        echo "<div id='modalContentUpdate'></div>";
        echo "<div class=\"modal-footer\">";
        echo "<button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-outline dark\">".Yii::t('app','Cancel')."</button>";
        echo "<button type=\"button\" id=\"buttonUpdate\" class=\"btn green\" data-dismiss=\"modal\">".Yii::t('app','Update')."</button>";
        echo "</div>";
    NewModal::end();

    NewModal::begin([
        'id'=>'modalView',
        'header' => Yii::t('app','View Member'),
        ]);
        echo "<div id='modalContentView'></div>";
        echo "<div class=\"modal-footer\">";
        echo "<button type=\"button\" data-dismiss=\"modal\" "
        . "class=\"btn btn-outline dark\">".Yii::t('app','Cancel')."</button>";
        echo "<button type=\"button\" id=\"buttonUpdateMember\" class=\"btn green view_update_button\" "
        . "data-dismiss=\"modal\">".Yii::t('app','Update')."</button>";
        echo "<button type=\"button\" id=\"buttonViewUpdate\" class=\"btn red-mint view_del_member_btn\" 'button-cancel' =".Yii::t('app','Cancel')." 'button-ok' = ".Yii::t('app','OK')." 'message' = ".Yii::t('app','If you delete this item must be delete the staff member associated to. Do you want to delete this item?')." data-dismiss=\"modal\">".Yii::t('app','Delete')."</button>";
        echo "</div>";
    NewModal::end();
 ?>


 <?php Pjax::begin(['id'=>'memberAjax']); ?>

<div class="portlet">
    <p>
        <?php
            $t = '/member/create';
            echo Html::button(Yii::t('app','Create Member'), 
                ['value'=>Url::to($t), 'class' => 'btn btn-outline green-meadow button_create']);
        ?>
    </p>
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-bell-o"></i>
            <?= Html::encode(Yii::t('app','List of Members')) ?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
            <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
            <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
            <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable">                                   
        <?= GridView::widget([
            'id' => 'gridMembers',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            //'emptyCell' => Html::button('Delete Member', ['class' => 'btn btn-primary', 'id'=> 'deleteMember']),
            'tableOptions' => ['class'=>"table table-striped table-bordered table-advance table-hover"],
            'columns' => [
            //   ['class' => 'yii\grid\SerialColumn'],
                //  id, 
                //'departament_id',
                ['class' => 'yii\grid\CheckboxColumn'],
                [
                    'attribute' => 'department_id',
                    'value' => 'department.name',
                    'label'=>'<i class=\'fa fa-home\' aria-hidden=\'true\'></i> '. Yii::t('app', 'Department'),
                    'encodeLabel' => false
                ],
                [
                    'attribute' => 'member_name',
                    'label'=>'<i class="fa fa-user" aria-hidden="true"></i> '. Yii::t('app', 'Member Name'),
                    'encodeLabel' => false
                ],
                [
                    'attribute' => 'date_hire',
                    'label'=>'<i class=\'fa fa-calendar\' aria-hidden="true"></i> '. Yii::t('app', 'Date of Hire'),
                    'encodeLabel' => false
                ],
                [ 'class' => 'yii\grid\ActionColumn',
                  'header'=> (Yii::$app->user->can('member/deletemembers')) ? 
                        Html::button(Yii::t('app','Delete Members'), 
                        ['class' => 'btn btn-outline blue-sharp', 
                        'id'=> 'deleteMember',
                        'data-confirmation' => Yii::t('app','Are you sure you want to delete these items?'),
                        'button-cancel' => Yii::t('app','Cancel'),
                        'button-ok' => Yii::t('app','OK'),
                        ]) : '',
                  'buttons'=>[
                    'view'=>function ($url, $model) {
                        $t = '/member/view/'.$model->id;
                        return Yii::$app->user->can('member/view') ? 
                                Html::button('<i class="fa fa-eye"></i>'. Yii::t('app', 'View'), 
                                ['value'=>Url::to($t), 
                                 'class' => 'btn btn-outline btn-circle btn-sm blue custom_button_view'
                                ]) : '';
                    },  
                    'update'=>function ($url, $model) {
                        $t = '/member/update/'.$model->id;
                        return Yii::$app->user->can('member/update') ?
                                Html::button('<i class="fa fa-edit"></i>'. Yii::t('app', 'Edit'), 
                                ['value'=>Url::to($t), 
                                 'class' => 'btn btn-outline btn-circle btn-sm purple custom_button'
                                ]) : '';
                    },
                    'delete' => function ($url, $model) {

                        $t = '/member/delete/'.$model->id;
                        return Yii::$app->user->can('member/delete') ? Html::button
                                ('<i class="fa fa-trash-o"></i>'. Yii::t('app', 'Delete'), 
                                ['value'=>Url::to($t), 
                                'class' => 'btn btn-outline btn-circle dark btn-sm black delete_button',
                                'button-cancel' => Yii::t('app','Cancel'),
                                'button-ok' => Yii::t('app','OK'),
                                'data-confirmation' => Yii::t('app','Are you sure you want to delete this item?'), 
                                'data-id'=>$model->id
                                ]) : '';
                            }
                    ],
                ]
            ],
        ]); ?>
        </div>
    
<?php Pjax::end();?>

</div>
</div>