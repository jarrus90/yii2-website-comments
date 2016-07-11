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
    public $urlPrefix = 'website-comments';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        '<key:[A-Za-z0-9_-]+>' => 'front/page'
    ];
    public $filesUploadUrl = '@web/uploads/website-comments';
    public $filesUploadDir = '@webroot/uploads/website-comments';
    public $redactorConfig = [];
    public $useCommonStorage = true;

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

}
