<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }
    public function login(){
        $identity = User::findOne(['username' => $this->username]);
        if(isset($identity)){
        	Yii::$app->user->login($identity);
        	return true;
        }else return false;
       
    }
}
