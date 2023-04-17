<?php

namespace app\models;

use yii\db\ActiveRecord;

class FinishedCourses extends ActiveRecord
{

    public static function tableName()
    {
        return 'fin_course_user_rel';
    }

    public function getFinishedCourses($userId)
    {
        $res = static::find()->asArray()->select('id_course')->where(['id_user' => $userId])->all();
        $carry = [];
        foreach ($res as $val) {
            array_push($carry, $val['id_course']);
        }
        return $carry;
    }

    public function setUserId($id_user)
    {
        $this->id_user = $id_user;
    }

    public function setCourseId($courseId)
    {
        $this->id_course = $courseId;
    }

}