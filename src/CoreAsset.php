<?php

namespace marcinmisiak\yii2fullcalendar6;

use yii\web\AssetBundle;

class CoreAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/../assets';
    public $js = [
        'fullcalendar.global.min.js',
        'locales/pl.global.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
