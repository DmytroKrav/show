<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/login.css',
        'css/loading-animation.css',
        'css/flags.css',
    ];
    public $js = [
        'js/editable-table-cell.js',
        'js/change-password-modal.js',
        'js/main.js',
        'js/delete-grid-row.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
