<?php

namespace jarrus90\WebsiteComments;

use yii\base\Object;
use yii\db\ActiveQuery;

/**
 * WebsiteCommentsFinder provides some useful methods for finding active record models.
 */
class WebsiteCommentsFinder extends Object {

    /** @var ActiveQuery */
    protected $categoryQuery;

    /** @var ActiveQuery */
    protected $pageQuery;

    /**
     * @return ActiveQuery
     */
    public function getCategoryQuery() {
        return $this->categoryQuery;
    }

    /**
     * @return ActiveQuery
     */
    public function getPageQuery() {
        return $this->pageQuery;
    }

    /** @param ActiveQuery $categoryQuery */
    public function setCategoryQuery(ActiveQuery $categoryQuery) {
        $this->categoryQuery = $categoryQuery;
    }

    /** @param ActiveQuery $pageQuery */
    public function setPageQuery(ActiveQuery $pageQuery) {
        $this->pageQuery = $pageQuery;
    }

    /**
     * Finds a category by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findCategory($condition) {
        return $this->categoryQuery->where($condition);
    }

    /**
     * Finds a page by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findPage($condition) {
        return $this->pageQuery->where($condition);
    }

}
