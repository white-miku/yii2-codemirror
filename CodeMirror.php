<?php

namespace whitemiku\codemirror;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class CodeMirror extends InputWidget
{
    /**
     * @var array configuration options
     * @see http://codemirror.net/doc/manual.html#config
     */
    public $pluginOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])){
            $this->options['id'] = $this->getId();
        }

        $this->pluginOptions = ArrayHelper::merge([
            'lineNumbers' => true,
            'styleActiveLine' => true,
            'matchBrackets' => true,
            'lineWrapping' => true
        ],$this->pluginOptions);

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $hiddenId = ArrayHelper::remove($this->options, 'id');

        if ($this->hasModel()) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
            echo Html::activeHiddenInput($this->model, $this->attribute, ['id' => $hiddenId]);
        } else {
            $value = $value = $this->value;
            echo Html::hiddenInput($this->name, $value, ['id' => $hiddenId]);
        }

        $id = $this->getId() . '-editor';
        $this->options['id'] = $id;
        $var = Inflector::variablize($id);
        echo Html::tag('textarea', Html::encode($value), $this->options);

        $view = $this->getView();
        CodeMirrorAsset::register($view);

        $options = Json::encode($this->pluginOptions);
        $view->registerJs("var {$var} = CodeMirror.fromTextArea(document.getElementById('$id'), $options);");
        $view->registerJs("{$var}.on('change', function(editor){jQuery('#$hiddenId').val(editor.getValue());});");
    }
}