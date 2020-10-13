<?php
namespace app\models;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class ChatWorker extends BaseObject implements JobInterface{
    public $identity;
    public $message;
    public function execute($queue)
    {
        $addToChat = new \app\models\Chat();
        $addToChat->message = $this->message;
        $addToChat->user_id = $this->identity;
        $addToChat->save(false);
    }
}