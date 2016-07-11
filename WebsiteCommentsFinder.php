<?php

namespace jarrus90\WebsiteComments;

use yii\base\Object;
use yii\db\ActiveQuery;

/**
 * WebsiteCommentsFinder provides some useful methods for finding active record models.
 */
class WebsiteCommentsFinder extends Object {

    /** @var ActiveQuery */
    protected $commentQuery;
    
    /**
     * @return ActiveQuery
     */
    public function getCommentQuery() {
        return $this->commentQuery;
    }

    /** @param ActiveQuery $commentQuery */
    public function setCommentQuery(ActiveQuery $commentQuery) {
        $this->commentQuery = $commentQuery;
    }

    /**
     * Finds a category by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findComment($condition) {
        return $this->commentQuery->where($condition);
    }

}
