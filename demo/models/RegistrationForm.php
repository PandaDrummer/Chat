<?php
namespace app\models;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model {
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }
    public function signup(){
        $user = new User();
        $user->username = $this->username;
        $user->password = $this->password;
        $answer =$user->save(false);
		
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('user');
        $auth->assign($authorRole, $user->getId());
        
        return $answer;
    }
    public function login(){
        $identity = User::findOne(['username' => $this->username]);
        Yii::$app->user->login($identity);
    }
}
