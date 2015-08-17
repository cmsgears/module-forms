<?php
namespace cmsgears\forms\admin;

// Yii Imports
use \Yii;

class Module extends \cmsgears\core\common\base\Module {

    public $controllerNamespace = 'cmsgears\forms\admin\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-forms/admin/views' );
    }
}