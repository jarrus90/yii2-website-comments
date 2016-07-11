<?php

namespace jarrus90\WebsiteComments\traits;

use jarrus90\WebsiteComments\Module;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package jarrus90\WebsiteComments\traits
 */
trait ModuleTrait {

    /**
     * @return Module
     */
    public function getModule() {
        return \Yii::$app->getModule('website-comments');
    }

}
