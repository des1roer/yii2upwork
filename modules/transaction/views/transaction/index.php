<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\transaction\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
    <?= Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'transaction_id',
            [
                'attribute' => 'type_id',
                'format' => 'raw',
                'filter' => ArrayHelper::map(app\modules\transaction\models\Type::find()->all(), 'id', 'name'),
                'value' => 'type.name'
            ],
                        [
                'attribute' => 'sender_id',
                'format' => 'raw',
                'filter' => ArrayHelper::map(\amnah\yii2\user\models\User::find()->all(), 'id', 'username'),
                'value' => 'sender.username'
            ],
                         [
                'attribute' => 'recipient_id',
                'format' => 'raw',
                'filter' => ArrayHelper::map(\amnah\yii2\user\models\User::find()->all(), 'id', 'username'),
                'value' => 'recipient.username'
            ],
            'cost',            
            // 'protect_code',
               [
                'attribute' => 'status_id',
                'format' => 'raw',
                'filter' => ArrayHelper::map(app\modules\transaction\models\Status::find()->all(), 'id', 'name'),
                'value' => 'status.name'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
<?php Pjax::end(); ?></div>
