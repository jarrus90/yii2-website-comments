<?php

namespace jarrus90\WebsiteComments\Controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\WebsiteComments\WebsiteCommentsFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;
use yii\filters\AccessControl;

class AdminController extends AdminCrudAbstract {

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['website_comments_moderator'],
                    ],
                ],
            ],
        ];
    }

    protected $modelClass = 'jarrus90\WebsiteComments\Models\Comment';
    protected $formClass = 'jarrus90\WebsiteComments\Models\Comment';
    protected $searchClass = 'jarrus90\WebsiteComments\Models\Comment';

    protected function getItem($id) {
        
    }

}
