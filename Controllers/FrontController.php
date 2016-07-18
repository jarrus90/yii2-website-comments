<?php

namespace jarrus90\WebsiteComments\Controllers;

use Yii;
use jarrus90\WebsiteComments\WebsiteCommentsFinder;
use jarrus90\Core\Web\Controllers\FrontController as Controller;
use jarrus90\WebsiteComments\Models\Comment;

class FrontController extends Controller {

    public function actionIndex() {
        $filterModel = Yii::createObject([
                    'class' => Comment::className(),
                    'scenario' => 'search'
        ]);
        $request = Yii::$app->request->get();
        $request['parent_id'] = NULL;
        $dataProvider = $filterModel->search($request, true);
        
        return $this->render('index', [
                    'filterModel' => $filterModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSend() {
        $filterModel = Yii::createObject([
                    'class' => Comment::className(),
                    'scenario' => 'create'
        ]);
    }

}
