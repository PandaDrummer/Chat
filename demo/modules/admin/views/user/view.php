<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($isAdmin->item_name != 'admin'): ?>
        <?= Html::a('Сделать администратором ', ['change-role', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php else: ?>
            <?= Html::a('Сделать пользователем ', ['change-role', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'password',
            [
                'format'=>'html',
                'label'=>'role',
                'value'=> function($data){
                    return $data->getRole($data->getID());
                }
            ],
        ],
    ]) ?>

</div>
