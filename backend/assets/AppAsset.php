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
        'css/font-awesome/css/font-awesome.min.css',
        'css/site.css',
        //'css/custom.css',
    ];
    public $js = [
      'js/user-permission.js',
      'js/custom_user.js',
      'js/modals.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
