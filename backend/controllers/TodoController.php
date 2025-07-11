<?php

namespace app\controllers;

use yii\filters\Cors;
use yii\filters\auth\HttpBearerAuth;
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
    /**
     * @return <missing>|null*/
    public function actionComplete(int $id)
    {
        $model = $this->modelClass::findOne($id);
        $model->is_complete = 1;
        if ($model->save()) {
            return $model;
        }
        return null;
    }
    /**
     * @return <missing>|null*/
    public function actionUnComplete(int $id)
    {
        $model = $this->modelClass::findOne($id);
        $model->is_complete = 0;
        if ($model->save()) {
            return $model;
        }
        return null;
    }

    public function beforeAction($action)
    {
        \Yii::info("Handling: " . \Yii::$app->request->method, 'cors-debug');
        return parent::beforeAction($action);
    }

    public function actions()
    {
        $actions = parent::actions();

        // Optional: register the built-in OPTIONS handler
        $actions['options'] = [
            'class' => 'yii\rest\OptionsAction',
        ];

        return $actions;
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                // adjust to your frontend origin
                'Origin' => ['http://localhost:5173'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Allow-Headers' => ['*'], // ✅ allow all headers
                'Access-Control-Max-Age' => 86400,
            ],
        ];
        if (isset($behaviors['authenticator'])) {
            $behaviors['authenticator']['except'] = ['options'];
        }
        return $behaviors;
    }
}
