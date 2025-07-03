<?php

namespace app\models;

use yii\db\ActiveRecord;


class Todo extends ActiveRecord
{

    //@inheritdoc 
    public static function tableName(): string
    {
        return 'todo';
    }

    //@inheritdoc
    public function rules(): array
    {
        return [
            [['name', 'is_complete'], 'required'],
        ];
    }
}
