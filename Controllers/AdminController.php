<?php

namespace jarrus90\WebsiteComments\Controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\WebsiteComments\WebsiteCommentsFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;
use yii\filters\AccessControl;

class AdminController extends AdminCrudAbstract {

    protected $modelClass = 'jarrus90\WebsiteComments\Models\Comment';
    protected $formClass = 'jarrus90\WebsiteComments\Models\Comment';
    protected $searchClass = 'jarrus90\WebsiteComments\Models\Comment';

    protected function getItem($id) {
        
    }

}
