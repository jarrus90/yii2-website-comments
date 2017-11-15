<?php

namespace jarrus90\WebsiteComments;

use Yii;
use yii\base\Module as BaseModule;
use yii\helpers\ArrayHelper;

class Module extends BaseModule {

    /**
     * @var string The prefix for user module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'site/comments';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        '' => 'front/index'
    ];
    public $filesUploadUrl = '@web/uploads/website-comments';
    public $filesUploadDir = '@webroot/uploads/website-comments';
    public $redactorConfig = [];
    public $useCommonStorage = false;

    public function init() {
        parent::init();
        $this->modules = [
            'redactor' => ArrayHelper::merge([
                'class' => 'jarrus90\Redactor\Module',
                'imageUploadRoute' => '/website-comments/upload/image',
                'fileUploadRoute' => '/website-comments/upload/file',
                'imageManagerJsonRoute' => '/website-comments/upload/image-json',
                'fileManagerJsonRoute' => '/website-comments/upload/file-json',
                'uploadUrl' => '@web/uploads/website-comments'
            ], $this->redactorConfig, [
                'uploadUrl' => $this->filesUploadUrl,
                'uploadDir' => $this->filesUploadDir,
            ]),
        ];
        if (!$this->get('storage', false)) {
            if ($this->useCommonStorage && ($storage = Yii::$app->get('storage', false))) {
                $this->set('storage', $storage);
            } else {
                $this->set('storage', [
                    'class' => 'creocoder\flysystem\LocalFilesystem',
                    'path' => $this->filesUploadDir
                ]);
            }
        }
    }

    public function getAdminMenu() {
        return ['website-comments' => [
            'label' => Yii::t('website-comments', 'Website comments'),
            'url' => '/website-comments/admin/index',
            'icon' => 'fa fa-fw fa-mail-reply-all',
            'position' => 61
        ]];
    }

}
