<?php

namespace whitemiku\codemirror;
use Yii;
use yii\web\AssetBundle;

class CodeMirrorAsset extends AssetBundle
{
    public $sourcePath = '@bower/codemirror';

/**
* Register required assets
*/
public function init()
{
    parent::init();
    $this->js = array_merge([
        'lib/codemirror.js',
        'mode/xml/xml.js',
        'mode/javascript/javascript.js',
        'mode/css/css.js',
        'mode/htmlmixed/htmlmixed.js',
        'mode/clike/clike.js',
        'mode/php/php.js'
    ], $this->js);
    $this->css = array_merge(['lib/codemirror.css'], $this->css);
}

}