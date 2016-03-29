<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use amnah\yii2\user\models\User;
use yii\widgets\ActiveForm;

//use app\modules\transaction\models\Transaction;
/* @var $this yii\web\View */
/* @var $model app\modules\transaction\models\Transaction */

$this->title = $model->transaction_id;
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $user = \Yii::$app->user;
        $isAdmin = $user->can('admin');
        if ($isAdmin)
        {
            echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>
    <?php
    
    echo $model->PROTECT;
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-10">{input}</div><div class="col-sm-10">{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                ],
    ]);
    ?>
    <?= Html::input('text', 'username') ?>
    <?= Html::submitButton('Подтвердить', ['id' => 'submit', 'class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>


    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'transaction_id',

            ['attribute' => 'sender_id', 'value' => User::findIdentity($model->sender_id)->username],
            ['attribute' => 'recipient_id', 'value' => User::findIdentity($model->recipient_id)->username],
            'cost',
            ['attribute' => 'type_id', 'value' => $model->type->name,],
            ['attribute' => 'status_id', 'value' => $model->status->name,],
        //'protect_code',
        ],
    ])
    ?>

</div>
