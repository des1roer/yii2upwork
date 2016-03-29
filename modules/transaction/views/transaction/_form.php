<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\transaction\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-10">{input}</div><div class="col-sm-10">{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                ],
    ]);
    ?>

    <?php
    $params = [
        'prompt' => 'Select...'
    ];
    $recipient_id = \amnah\yii2\user\models\User::find()->all();
    $items = ArrayHelper::map($recipient_id, 'id', 'username');

    echo $form->field($model, 'recipient_id')->dropDownList($items, $params);
    $type_id = app\modules\transaction\models\Type::find()->all();
    $items = ArrayHelper::map($type_id, 'id', 'name');

    echo $form->field($model, 'type_id')->dropDownList($items, $params);

    /*$status_id = app\modules\transaction\models\Status::find()->all();
    $items = ArrayHelper::map($status_id, 'id', 'name');

    echo $form->field($model, 'status_id')->dropDownList($items, $params);*/
    ?>
    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

    <div class="form-group" style="padding-left: 210px">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
