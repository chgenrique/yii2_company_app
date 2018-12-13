<?php

namespace app\components;

use yii\base\Behavior;


class LanguageHandler extends Behavior{
    public function events()
    {
       return [\yii\web\Application::EVENT_BEFORE_REQUEST => 'handleBeginRequest'];
    }
    
    public function handleBeginRequest($event)
    {
        if(\Yii::$app->getRequest()->getCookies()->has('_lang') && array_key_exists(\Yii::$app->getRequest()->getCookies()->getValue('_lang'), \Yii::$app->params['languages']))
        {
            \Yii::$app->language = \Yii::$app->getRequest()->getCookies()->getValue('_lang');
        }
                
    }
}
