<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax; ?>
<div class="container-chat">
    <?php if(isset($chat)): ?>
    <?php Pjax::begin([
            'id' => 'pjaxContent'
    ]); ?>
    <div class="chat">
        <?php foreach ( $chat as $item): ?>
            <?php if($item->status == 1): ?>
            <div class="message" style="<?= ($item->user_id == Yii::$app->user->getId()) ? 'float:right;' : '' ?>" >
                <p class="username" style="<?= ($item->getRole($item->user_id) == 'admin')? 'color:red;': '' ?>"><?= $item->getUser()->one()->username?></p>
                <p><?= $item->message?> <?php echo (\Yii::$app->user->can('admin')) ? '<span class="mod_btn" onclick="hidemessage('.$item->id.')" ></span>' : ''; ?></p>
            </div>
            <br>
            <?php elseif ($item->status == 0 && \Yii::$app->user->can('admin')): ?>
                <div class="message" style="background-color:<?php echo (\Yii::$app->user->can('admin')) ? '#ff5252' : ''; ?>;position: relative;display: inline-block;border-radius: 15px;padding: 1px 22px;margin: 5px 0px;" >
                    <p style="font-size: 12px; margin: 0 ;padding: 0"><?= $item->getUser()->one()->username?></p>
                    <p><?= $item->message?>  <span class="show_btn" onclick="showmessage(<?=$item->id?>)" ></span></p>
                </div>
                <br>
            <?php endif;?>

        <?php endforeach; ?>
    </div>

    <?php if (Yii::$app->user->isGuest !=true):?>
   <?php $form = ActiveForm::begin([
       'options' => ['data' => ['pjax' => true]],
   ]); ?>
    <?= $form->field($message, 'message')->textInput(['placeholder' => 'Написать сообщение... '])->label('') ?>
    <div class="form-group">
        <div class="col-lg-11">
            <?= Html::submitButton('отравить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php endif; ?>
    <?php Pjax::end(); ?>
    <?php endif; ?>
</div>
