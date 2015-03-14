<?php
namespace cmsgears\forms\admin;

// Yii Imports
use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'cmsgears\forms\admin\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-forms/admin/views' );
    }
}