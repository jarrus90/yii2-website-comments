<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$formItem = ActiveForm::begin([
            'layout' => 'horizontal',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-9',
                ],
            ],
        ]);
echo $formItem->field($form, 'content');
echo Html::submitButton(Yii::t('website-comments', 'Save'), ['class' => 'btn btn-success btn-block']);
ActiveForm::end();

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'website-comments-site-replies',
    'itemOptions' => [
        'tag' => false
    ],
    'itemView' => '_reply'
]);
?>