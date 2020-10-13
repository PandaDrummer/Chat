<?php

namespace app\controllers;

use app\models\Chat;
use app\models\ChatForm;
use app\models\ChatWorker;
use app\models\RegistrationForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    const SHOW_MESSAGE = 1;
    const HIDE_MESSAGE = 0;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' =>['index'],
                'rules' => [

                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['write']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['registration'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['test'],
                        'roles' => ['write']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['hide-message'],
                        'roles' => ['admin']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['show-message'],
                        'roles' => ['admin']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex()
    {
        $chat = Chat::find()->all();
        $message = new ChatForm();
        if($message->load(Yii::$app->request->post())){
            $identity = Yii::$app->user->identity ;
            Yii::$app->queue->push(new ChatWorker([
                'identity' => $identity->getId(),
                'message' => $message->message,
            ]));

            /*
            $addToChat = new Chat();
            $addToChat->message = $message->message;
            $addToChat->user_id = $identity->getId();
            $addToChat->save();
            */
        } else
        return $this->render('index',[
            'chat'=>$chat,
            'message' => $message
        ]);
    }
    public function actionTest($id){
        $chat = Chat::findOne($id);
        $this->vardumper($chat->user()->one()->username);
    }
    
    public function actionHideMessage($id){
        $chat = Chat::findOne($id);
        $chat->status = self::HIDE_MESSAGE ;
        $chat->save(false);
    }
    
    public function actionShowMessage($id){
        $chat = Chat::findOne($id);
        $chat->status = self::SHOW_MESSAGE ;
        $chat->save(false);
    }
    
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) &&$model->login()) {
            $model->login();
            return $this->goBack();
        } else
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionRegistration(){
        $form = new RegistrationForm();
        if($form->load(Yii::$app->request->post()) && $form->signup() ){
            $form->login();
            return $this->redirect('/');

        } else return $this->render('registrationForm',[
            'model'=>$form
        ]);
    }
    public function actionAddRole(){
        /*
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('admin');
        $admin->description = 'Админ ' ;
        $auth->add($admin);

        $auth = Yii::$app->authManager;
        $user = $auth->createRole('user');
        $user->description = 'Пользователь' ;
        $auth->add($user);

        $write = $auth->createPermission('write');
        $write->description = 'Create a post';
        $auth->add($write);

        $auth->addChild($admin,$write);
        $auth->addChild($user,$write);
        //return '<p>ok</p>' ;
		
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('admin');
        $auth->assign($authorRole, 1);
        */
    }
    public function vardumper($file){
        echo '<pre>';
        var_dump($file);
        echo '<pre>';
    }
}
