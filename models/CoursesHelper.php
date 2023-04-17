<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CoursesHelper extends Model
{
    public $id;
    public $name;
    public $description;
    public $url;
    public function rules(){
        return [
            ['name', 'string'],
            [['name'], 'required', 'message' => 'Заполните поле'],
            ['id', 'integer'],
            ['description', 'string'],
            ['url', 'string']
        ];
    }

    public function getCourses()
    {
        $userId = Yii::$app->user->identity->getId();
        $courseModel = new Courses();
        $finishedCoursesMod = new FinishedCourses();
        $finished = $finishedCoursesMod->getFinishedCourses($userId);
        $allCourses = $courseModel->getAllCourses();
        return array_reduce($allCourses,function ($carry, $item) use ($finished) {
            if (in_array($item['id'], $finished)) {
                $item['finished'] = true;
            }
            $carry[] = $item;
            return $carry;
        }, []);
    }

    public function getCourseById()
    {
        $id = Yii::$app->request->get()['id'];
        $courseModel = Courses::getCourseById($id);
        if ($courseModel) return $courseModel;
        return false;
    }

    public function addCourse()
    {
        if (!$this->validate()) {
            return null;
        }

        $course = new Courses();
        $course->name = $this->name;
        $course->description = $this->description;
        $course->url = $this->url;
        if ($course->save()) {
            return true;
        }
        return null;
    }

    public function setFinishCourse()
    {
        $course = new FinishedCourses();
        $course->setCourseId($this->id);
        $course->setUserId(Yii::$app->user->identity->getId());
        if ($course->save()) {
            return true;
        }
        return false;
    }
}