<?php

namespace source\modules\dict;

use source\LuLu;

class HomeModule extends \source\core\modularity\FrontModule
{
    
    public $controllerNamespace = 'source\modules\dict\home';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    public function getMenus()
    {
        return [
            //['首页',['/dict']],
            //['设置',['/dict/setting']],
        ];
    }
}
