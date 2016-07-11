<?php

namespace jarrus90\WebsiteComments;

use Yii;
use yii\i18n\PhpMessageSource;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;

/**
 * Bootstrap class registers module and user application component. It also creates some url rules which will be applied
 * when UrlManager.enablePrettyUrl is enabled.
 */
class Bootstrap implements BootstrapInterface {


    /** @inheritdoc */
    public function bootstrap($app) {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('support') && ($module = $app->getModule('support')) instanceof Module) {
            Yii::$container->setSingleton(WebsiteCommentsFinder::className(), [
                'categoryQuery' => \jarrus90\WebsiteComments\Models\Category::find(),
            ]);

            if (!isset($app->get('i18n')->translations['support*'])) {
                $app->get('i18n')->translations['support*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }
            
            if (!$app instanceof ConsoleApplication) {
                $module->controllerNamespace = 'jarrus90\WebsiteComments\Controllers';
                $configUrlRule = [
                    'prefix' => $module->urlPrefix,
                    'rules' => $module->urlRules,
                ];
                if ($module->urlPrefix != 'support') {
                    $configUrlRule['routePrefix'] = 'support';
                }
                $configUrlRule['class'] = 'yii\web\GroupUrlRule';
                $rule = Yii::createObject($configUrlRule);
                $app->urlManager->addRules([$rule], false);
                
                $app->params['admin']['menu']['support'] = [
                    'label' => Yii::t('support', 'Website comments'),
                    'position' => 30,
                    'items' => [
                        [
                            'label' => Yii::t('support', 'FAQ'),
                            'url' => '/support/page/index'
                        ],
                    ]
                ];
            }

            $app->params['yii.migrations'][] = '@jarrus90/WebsiteComments/migrations/';
        }
    }

}
