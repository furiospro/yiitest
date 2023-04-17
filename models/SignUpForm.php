<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignUpForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;
    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Заполните поле'],
            ['rememberMe', 'boolean'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот логин уже занят'],
        ];
    }

    public function signUp()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save()) {
            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }
}