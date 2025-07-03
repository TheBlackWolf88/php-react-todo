<?php

namespace app\controllers;

use app\models\Todo;
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
}
