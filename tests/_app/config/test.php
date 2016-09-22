<?php

return [
    'id' => 'yii2-website-comments-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'aliases' => [
        '@jarrus90/WebsiteComments' => dirname(dirname(dirname(__DIR__))),
        '@tests' => dirname(dirname(__DIR__)),
        '@vendor' => VENDOR_DIR,
        '@bower' => VENDOR_DIR . '/bower-asset',
    ],
    'bootstrap' => [
        'jarrus90\User\Bootstrap',
        'jarrus90\WebsiteComments\Bootstrap'
    ],
    'modules' => [
        'user' => [
            'class' => 'jarrus90\User\Module'
        ],
        'website-comments' => [
            'class' => 'jarrus90\WebsiteComments\Module'
        ],
    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
    ],
    'params' => [],
];