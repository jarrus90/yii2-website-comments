<?php

namespace jarrus90\WebsiteComments\Controllers;

use Yii;
use jarrus90\WebsiteComments\WebsiteCommentsFinder;
use jarrus90\Core\Web\Controllers\FrontController as Controller;
use jarrus90\WebsiteComments\Models\Comment;

class FrontController extends Controller {

    use \jarrus90\Core\Traits\AjaxValidationTrait;
    public function actionIndex() {
        
        $form = Yii::createObject([
                    'class' => Comment::className(),
                    'scenario' => 'create',
                    'item' => Yii::createObject([
                        'class' => Comment::className(),
                        'from_id' => Yii::$app->user->id
                    ])
        ]);
        $this->performAjaxValidation($form);
        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            return $this->refresh();
        }
        
        $filterModel = Yii::createObject([
                    'class' => Comment::className(),
                    'scenario' => 'search'
        ]);
        $request = Yii::$app->request->get();
        $request['parent_id'] = NULL;
        $request['is_blocked'] = false;
        $dataProvider = $filterModel->search($request, true);
        Yii::$app->view->title = Yii::t('website-comments', 'Comments');
        return $this->render('index', [
                    'filterModel' => $filterModel,
                    'dataProvider' => $dataProvider,
                    'form' => $form
        ]);
    }

}
