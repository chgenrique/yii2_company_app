<?php

namespace app\components\NewModal;

use yii\bootstrap\Modal;
use yii\helpers\Html;

class NewModal extends Modal{
    
    public $title = null;
    
    /**
     * 
     * @return type
     */
    public function renderHeader()
    {
        $button = $this->renderCloseButton();
        if ($button !== null) {
            $this->header = $button . "\n" . $this->header;
        }
        $this->title = (is_null($this->title) ? '' : '<span class="title"><p>'.$this->title.'<p></span>');
        if ($this->header !== null) {
            Html::addCssClass($this->headerOptions, ['widget' => 'modal-header']);
            return Html::tag('div', "\n" . $this->title . $this->header . "\n", $this->headerOptions);
        } else {
            return null;
        }
    }
}
