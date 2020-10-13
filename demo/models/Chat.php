<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property string|null $message
 * @property int|null $user_id
 * @property int|null $status
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['user_id', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }
    public function getRole($id){
        $isAdmin = AuthAssignment::findOne(['user_id'=>$id]) ;
        if($isAdmin->item_name == 'admin'){
            return 'admin';
        }else{
            return 'user';
        }
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
