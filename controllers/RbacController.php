<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\AuthItem;

class RbacController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find(),
        ]);
        
        return $this->render('index',[
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;
        
        // add "createMember" permission
        $createMember = $auth->createPermission('member/create');
        $createMember->description = 'Create a member';
        $auth->add($createMember);

        // add updateMember permission
        $updateMember = $auth->createPermission('member/update');
        $updateMember->description = 'Update member';
        $auth->add($updateMember);

        // add delete member selected permission
        $deteleMemberSelect = $auth->createPermission('member/deletemembers');
        $deteleMemberSelect->description = 'Delete selected members';
        $auth->add($deteleMemberSelect);

        // add delete member permission
        $deteleMember = $auth->createPermission('member/delete');
        $deteleMember->description = 'Delete member';
        $auth->add($deteleMember);
        
        // add view member permission
        $viewMember = $auth->createPermission('member/view');
        $viewMember->description = 'View member';
        $auth->add($viewMember);

        
        // add create department permission
        $createDepartment = $auth->createPermission('department/create');
        $createDepartment->description = 'Create a department';
        $auth->add($createDepartment);
        
        // add update department  permission
        $updateDepartment = $auth->createPermission('department/update');
        $updateDepartment->description = 'Update a department';
        $auth->add($updateDepartment);
        
        // add delete department permission
        $deleteDepartment = $auth->createPermission('department/delete');
        $deleteDepartment->description = 'Delete a department';
        $auth->add($deleteDepartment);
        
        // add delete selected department permission
        $deleteSelectedDepartment = $auth->createPermission('department/deleteall');
        $deleteSelectedDepartment->description = 'Delete selected departments';
        $auth->add($deleteSelectedDepartment);
        
        // add view department permission
        $viewDepartment = $auth->createPermission('department/view');
        $viewDepartment->description = 'View department';
        $auth->add($viewDepartment);
        
        
        
        // Roles

        // Add member and permissions
        $member = $auth->createRole('member');
        $auth->add($member);
        $auth->addChild($member, $createMember);
        $auth->addChild($member, $updateMember);
        $auth->addChild($member, $deteleMemberSelect);
        $auth->addChild($member, $deteleMember);
        $auth->addChild($member, $viewMember);
        
        // Add Admin and persmissions
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        
        $auth->addChild($admin, $createDepartment);
        $auth->addChild($admin, $updateDepartment);
        $auth->addChild($admin, $deleteDepartment);
        $auth->addChild($admin, $deleteSelectedDepartment);
        $auth->addChild($admin, $viewDepartment);
        $auth->addChild($admin, $member);
        

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($member, 2);
        $auth->assign($admin, 1);
    }
    
    
    public function actionTest(){
        
        $auth = \Yii::$app->authManager;
        
        // add "createMember" permission
        $createPermission = $auth->createPermission('testPermission');
        $createPermission->description = 'Test permission';
        $auth->add($createPermission);
    
        $admin = $auth->createRole('test');
        $auth->add($admin);
    }

}
