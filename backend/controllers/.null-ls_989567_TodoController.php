<?php

namespace app\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;

class TodoController extends ActiveController
{

    public $modelClass = 'app\models\todo';

    public function actionHello(): string
    {
        return "hello";
    }

    public function actionError(): string
    {
        return "error from todo";
    }

    public function actionComplete(int $id)
    {
        $model = $this->modelClass::findOne($id);
        $model->is_complete = 1;
        if ($model->save()) {
            return $model;
        }
        return null;
    }

    public function actionUnComplete(int $id)
    {
        $model = $this->modelClass::findOne($id);
        $model->is_complete = 0;
        if ($model->save()) {
            return $model;
        }
        return null;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                // adjust to your frontend origin
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Allow-Headers' => ['Authorization', 'Content-Type', 'X-Requested-With'],
            ],
        ];
        if (isset($behaviors['authenticator'])) {
            $behaviors['authenticator']['except'] = ['options'];
        }


        return $behaviors;
    }
}
