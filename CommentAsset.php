<?php

/**
 * Class AppAsset
 *
 * Asset for frontend
 * 
 * @package app\modules\core\Assets
 */

namespace jarrus90\WebsiteComments;

use yii\web\AssetBundle;

/**
 * AppAsset
 * 
 * Basic application asset
 */
class CommentAsset extends AssetBundle {

    /**
     * Default path
     * @var string
     */
    public $sourcePath = '@jarrus90/WebsiteComments/assets/front/';


    /**
     * List of available css files
     * @var array
     */
    public $css = [
        'comment.css',
    ];
    
    /**
     * List of available js files
     * @var array
     */
    public $js = [
        'comment.js',
    ];

    /**
     * Dependent packages
     * @var array
     */
    public $depends = [
        'yii' => 'yii\web\YiiAsset'
    ];

}
