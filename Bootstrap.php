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
        if ($app->hasModule('website-comments') && ($module = $app->getModule('website-comments')) instanceof Module) {
            Yii::$container->setSingleton(WebsiteCommentsFinder::className(), [
                'commentQuery' => \jarrus90\WebsiteComments\Models\Comment::find(),
            ]);

            if (!isset($app->get('i18n')->translations['website-comments*'])) {
                $app->get('i18n')->translations['website-comments*'] = [
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
                if ($module->urlPrefix != 'website-comments') {
                    $configUrlRule['routePrefix'] = 'website-comments';
                }
                $configUrlRule['class'] = 'yii\web\GroupUrlRule';
                $rule = Yii::createObject($configUrlRule);
                $app->urlManager->addRules([$rule], false);
                $app->params['admin']['menu']['website-comments'] = function() use($module) {
                    return $module->getAdminMenu();
                };
            } else {
                if(empty($app->controllerMap['migrate'])) {
                    $app->controllerMap['migrate']['class'] = 'yii\console\controllers\MigrateController';
                }
                $app->controllerMap['migrate']['migrationNamespaces'][] = 'jarrus90\WebsiteComments\migrations';
            }
        }
    }

}
