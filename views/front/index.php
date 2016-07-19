<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
jarrus90\WebsiteComments\CommentAsset::register($this);
$formItem = ActiveForm::begin([
            'layout' => 'horizontal',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'id' => 'website-comment',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-9',
                ],
            ],
            'options' => [
                'class' => 'website-comment-form',
            ]
        ]);
?>
<div class="alert alert-success reply-block"> 
    <button type="button" class="close">
        <span aria-hidden="true">×</span>
    </button>
    <strong><?= Yii::t('website-comments', 'Reply to'); ?> <span class="username"></span></strong>
    <p class="message"></p>
</div>
<?php
echo Html::activeHiddenInput($form, 'parent_id');
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