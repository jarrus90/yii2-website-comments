<?php

/**
 * @var $this  yii\web\View
 * @var $model jarrus90\User\models\Role
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->params['breadcrumbs'][] = $this->title;
$this->beginContent('@jarrus90/WebsiteComments/views/_adminLayout.php');
$form = ActiveForm::begin([
            'layout' => 'horizontal',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-9',
                ],
            ],
        ]);
echo $form->field($model, 'content');
echo Html::submitButton(Yii::t('website-comments', 'Save'), ['class' => 'btn btn-success btn-block']);
ActiveForm::end();
$this->endContent();
