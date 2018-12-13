<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use app\assets\MemberAssets;
use app\components\NewModal\NewModal;
use yii\helpers\Url;

use Yii;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchStaffMember */
/* @var $dataProvider yii\data\ActiveDataProvider */
 //   <?= Html::a(Yii::t('app','Create Member old'), ['create'], ['class' => 'btn btn-success'])
//  ['class' => 'yii\grid\ActionColumn'],


MemberAssets::register($this);

$this->title = Yii::t('app','Staff Members');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="staff-member-index">
    
<?php   
    NewModal::begin([
        'id' => 'modal-member',
        'header' => Yii::t('app','Create Member'),
        'closeButton' => [
          'label' => 'Close',
          'class' => 'btn btn-danger btn-sm pull-right',
        ],
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContentCreateView'></div>";
    NewModal::end();

    NewModal::begin([
        'id'=>'modalView',
        'size'=>'modal-md', 
        'header' => Yii::t('app','View Member'),
        'closeButton' => [
          'label' => 'Close',
          'class' => 'btn btn-danger btn-sm pull-right',
        ]]
        );
        echo "<div id='modalContentView'></div>";
    NewModal::end();

    NewModal::begin([
        'id'=>'modalUpdate',
        'size'=>'modal-md', 
        'header' => Yii::t('app','Update Member'),
        'closeButton' => [
          'label' => 'Close',
          'class' => 'btn btn-danger btn-sm pull-right',
        ]]
        );
        echo "<div id='modalContentUpdate'></div>";
    NewModal::end();
?>
    
<?php Pjax::begin(['id'=>'memberAjax']); ?>
    
    <p>
        <?php
            $t = '/member/create';
            echo Html::button(Yii::t('app','Create Member'), 
                ['value'=>Url::to($t), 'class' => 'btn btn-success button_create']);
        ?>
    </p>
    
    <h1><?= Html::encode(Yii::t('app','List of Members')) ?></h1>
    
    <?= GridView::widget([
        'id' => 'gridMembers',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'emptyCell' => Html::button('Delete Member', ['class' => 'btn btn-primary', 'id'=> 'deleteMember']),
        'columns' => [
        //   ['class' => 'yii\grid\SerialColumn'],
            //  id, 
            //'departament_id',
            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'attribute' => 'department_id',
                'value' => 'department.name'
            ],
            'member_name',
            'date_hire',
            [ 'class' => 'yii\grid\ActionColumn',
              'header'=> (Yii::$app->user->can('member/deletemembers')) ? 
                    Html::button(Yii::t('app','Delete Members'), 
                    ['class' => 'btn btn-primary', 
                     'id'=> 'deleteMember',
                     'data-confirmation' => Yii::t('app','Are you  sure you want to delete these items?'), 
                    ]) : '',
              'buttons'=>[
                'view'=>function ($url, $model) {
                    $t = '/member/view/'.$model->id;
                    return Yii::$app->user->can('member/view') ? 
                            Html::button('<span class="glyphicon glyphicon-eye-open"></span>', 
                            ['value'=>Url::to($t), 
                             'class' => 'btn btn-default btn-xs custom_button_view'
                            ]) : '';
                },  
                'update'=>function ($url, $model) {
                    $t = '/member/update/'.$model->id;
                    return Yii::$app->user->can('member/update') ?
                            Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
                            ['value'=>Url::to($t), 
                             'class' => 'btn btn-default btn-xs custom_button'
                            ]) : '';
                },
                'delete' => function ($url, $model) {
                    
                    $t = '/member/delete/'.$model->id;
                    return Yii::$app->user->can('member/delete') ? Html::button
                            ('<span class="glyphicon glyphicon-trash"></span>', 
                            ['value'=>Url::to($t), 
                            'class' => 'btn btn-default btn-xs delete_button',
                            'data-confirmation' => Yii::t('app','Are you  sure you want to delete this item?'), 
                            'data-id'=>$model->id
                           //'data' => ['confirm' => 'Are you  sure you want to delete this item?']
                            ]) : '';
                    
//                    return (Yii::$app->user->can("member/delete")) ? Html::
//                            a('<span  class="glyphicon glyphicon-trash delete_button"></span>', ['delete', 'id' => $model->id], 
//                            [
//                             'title'=> Yii::t('app', 'Delete'), 
//                             'class' => 'delete_button',
//                             'data-confirmation' => Yii::t('app','Are you  sure you want to delete this item?'), 
//                             'data-id' => $model->id,
//                             'data' => [
//                                'method' => 'post',
//                              ],
//                            ])
//                            : '';
                        }
                ],
            ]
        ],
    ]); ?>
</div>
<?php Pjax::end();?>
