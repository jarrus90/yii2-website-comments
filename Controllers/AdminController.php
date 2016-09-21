<?php

namespace jarrus90\WebsiteComments\Controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\WebsiteComments\WebsiteCommentsFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;
use yii\filters\AccessControl;

class AdminController extends AdminCrudAbstract {

    protected $finder;
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

    /**
     * @param string  $id
     * @param BaseModule $module
     * @param SupportFinder  $finder
     * @param array   $config
     */
    public function __construct($id, $module, WebsiteCommentsFinder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action) {
        if(parent::beforeAction($action)) {
            Yii::$app->view->title = Yii::t('website-comments', 'Website comments');
            Yii::$app->view->params['breadcrumbs'][] = Yii::t('website-comments', 'Website comments');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('website-comments', 'List'), 'url' => ['index']];
            return true;
        }
        return false;
    }

    public function actionCreate() {
        Yii::$app->view->title = Yii::t('website-comments', 'Create comment');
        return parent::actionCreate();
    }

    public function actionUpdate($id) {
        Yii::$app->view->title = Yii::t('website-comments', 'Edit comment #{id}', ['id' => $id]);
        return parent::actionUpdate($id);
    }
    
    public function actionBlock($id) {
        $model = $this->getItem($id);
        $model->block(Yii::$app->user->id);
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionUnblock($id) {
        $model = $this->getItem($id);
        $model->unblock(Yii::$app->user->id);
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    protected function getItem($id) {
        $item = $this->finder->findComment(['id' => $id])->one();
        if ($item) {
            return $item;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('website-comments', 'The requested comment does not exist'));
        }
    }

}
