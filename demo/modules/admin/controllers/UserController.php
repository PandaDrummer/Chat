<?php

namespace app\modules\admin\controllers;

use app\models\AuthAssignment;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $isAdmin = AuthAssignment::findOne(['user_id'=>$id]) ;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'isAdmin' => $isAdmin
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionChangeRole($id){
        $model = AuthAssignment::findOne(['user_id'=>$id]) ;
        if($model->item_name != 'admin') {
            $auth = Yii::$app->authManager;
            $lastRole = $auth->getRole('user');
            $authorRole = $auth->getRole('admin');
            $auth->revoke($lastRole , $id);
            $auth->assign($authorRole,$id);
        }else{
            $auth = Yii::$app->authManager;
            $lastRole = $auth->getRole('admin');
            $authorRole = $auth->getRole('user');
            $auth->revoke($lastRole , $id);
            $auth->assign($authorRole, $id);
        }
        return $this->redirect('index');
    }
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
