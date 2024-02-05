<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class PublicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'public/css/font-awesome.min.css',
        'public/css/linearicons.css',
        'public/css/animate.css',
        'public/css/flaticon.css',
        'public/css/slick.css',
        'public/css/slick-theme.css',
        'public/css/bootstrap.min.css',
        'public/css/bootsnav.css',
        'public/css/style.css',
        'public/css/responsive.css',
    ];
    public $js = [
        //'public/js/jquery.js',
        'public/js/bootstrap.min.js',
        'public/js/bootsnav.js',
        'public/js/feather.min.js',
        'public/js/jquery.counterup.min.js',
        'public/js/waypoints.min.js',
        'public/js/slick.min.js',
        'public/js/custom.js',
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap5\BootstrapAsset',
    ];
}
