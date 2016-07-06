<?php
namespace cmsgears\forms\frontend;

// Yii Imports
use \Yii;

class Module extends \cmsgears\core\common\base\Module {

    public $controllerNamespace = 'cmsgears\forms\frontend\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-forms/frontend/views' );
    }
}
