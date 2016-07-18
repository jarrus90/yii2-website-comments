<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\JsExpression;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */
?>
<?php $this->beginContent('@jarrus90/WebsiteComments/views/_adminLayout.php') ?>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
    'pjax' => true,
    'hover' => true,
    'export' => false,
    'id' => 'list-table',
    'toolbar' => [
        ['content' =>
            Html::a('<i class="glyphicon glyphicon-plus"></i>', Url::toRoute(['create']), [
                'data-pjax' => 0,
                'class' => 'btn btn-default',
                'title' => \Yii::t('website-comments', 'New comment')]
            )
            . ' ' .
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::toRoute(['index']), [
                'data-pjax' => 0,
                'class' => 'btn btn-default',
                'title' => Yii::t('website-comments', 'Reset filter')]
            )
        ],
    ],
    'panel' => [
        'type' => \kartik\grid\GridView::TYPE_DEFAULT
    ],
    'layout' => "{toolbar}{items}{pager}",
    'pager' => ['options' => ['class' => 'pagination pagination-sm no-margin']],
    'columns' => [
        [
            'attribute' => 'content',
            'width' => '60%',
            'content' => function($model) {
                $str = $model->content;
                if($model->parent) {
                    $str .= '<hr>' . Yii::t('website-comments', 'Reply to:') . '<br>' . $model->parent->content;
                }
                return $str;
            }
        ],
        [
            'attribute' => 'created_at',
            'class' => '\kartik\grid\DataColumn',
            'width' => '15%',
            'filterType' => GridView::FILTER_DATE,
            'filterWidgetOptions' => [
                'pickerButton' => false,
                'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy'
                ]
            ],
            'format' => ['date', 'php:Y-m-d H:i']
        ],
        [
            'attribute' => 'from_id',
            'width' => '15%',
            'value' => 'from.name',
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'theme' => 'default',
                'pluginOptions' => [
                    'allowClear' => true,
                    'ajax' => [
                        'url' => Url::toRoute('/user/admin/list'),
                        'dataType' => 'json',
                        'delay' => 50,
                        'data' => new JsExpression('function(params) { return {name: params.term }; }')
                    ],
                    'data' => [$filterModel->searchUserData],
                    'templateResult' => new JsExpression('function (user) { return user.name; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.name; }'),
                ],
                'options' => [
                    'placeholder' => Yii::t('website-comments', 'Select user'),
                ]
            ],
        ],
        [
            'attribute' => 'is_blocked',
            'class' => '\kartik\grid\BooleanColumn',
            'trueLabel' => Yii::t('yii', 'Yes'),
            'falseLabel' => Yii::t('yii', 'No'),
            'format' => 'html',
            'content' => function ($model) {
                if ($model->is_blocked) {
                    return Html::a("<span class='glyphicon glyphicon-ok text-danger'></span>", Url::toRoute(['unblock', 'id' => $model->id]), [
                                'title' => Yii::t('website-comments', 'Unblock'),
                                'data-confirm' => Yii::t('website-comments', 'Are you sure you want to unblock this comment?'),
                    ]);
                } else {
                    return Html::a("<span class='glyphicon glyphicon-off text-success'></span>", Url::toRoute(['block', 'id' => $model->id]), [
                                'title' => Yii::t('website-comments', 'Block'),
                                'data-confirm' => Yii::t('website-comments', 'Are you sure you want to block this comment?'),
                    ]);
                }
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
        ],
    ],
]);
?>
<?php $this->endContent() ?>
