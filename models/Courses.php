<?php

namespace app\models;

use yii\db\ActiveRecord;
class Courses extends ActiveRecord
{
    public $courses = [];

    public static function tableName()
    {
        return 'courses';
    }

    public static function getCourseById($id)
    {
        $res = static::findOne(['id' => $id]);
        return $res;
    }

    public function getAllCourses()
    {
        return static::findBySql('select * from courses')->asArray()->all();
    }
}