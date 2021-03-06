<?php
namespace source\modules\modularity;


use source\LuLu;
use source\core\modularity\ModuleService;
use source\core\modularity\ModuleInfo;
use source\modules\modularity\models\Modularity;

class ModularitySerivce extends ModuleService
{
    
    public $id = 'modularitySerivce';
    
    public function getActiveModules($isAdmin=false)
    {
        $ret = [];
        
        $field = $isAdmin ? 'enable_admin' : 'enable_home';
        $allModules = Modularity::find()->where([$field => 1])->indexBy('id')->all();
        
        $modules = $this->loadAllModules();
        foreach ($modules as $m)
        {
            $moduleId = $m['id'];
            
            if (array_key_exists($moduleId, $allModules))
            {
                $ret[$moduleId]['id'] = $m['id'];
                $ret[$moduleId]['dir'] = $m['dir'];
                $ret[$moduleId]['dir_class'] = $m['dir_class'];
                $ret[$moduleId]['class'] = $m['class'];
                $ret[$moduleId]['instance'] = $m['instance'];
            }
        }
        return $ret;
    }

    public function getAllModules()
    {
        $ret = [];
        
        $allModules = Modularity::find()->indexBy('id')->all();
        
        $modules = $this->loadAllModules();
        foreach ($modules as $m)
        {
            $moduleId = $m['id'];
            
            $ret[$moduleId] = $m;
            if (array_key_exists($moduleId, $allModules))
            {
                $exitModule = $allModules[$moduleId];
               
                if($ret[$moduleId]['has_admin'])
                {
                    $ret[$moduleId]['can_active_admin'] = ($exitModule['enable_admin'] === null || $exitModule['enable_admin'] === 0) ? true : false;
                }
                if($ret[$moduleId]['has_home'])
                {
                    $ret[$moduleId]['can_active_home'] = ($exitModule['enable_home'] === null || $exitModule['enable_home'] === 0) ? true : false;
                }
                
                $ret[$moduleId]['can_install'] = false;
                $ret[$moduleId]['can_uninstall'] = ( $ret[$moduleId]['has_admin'] && $exitModule['enable_admin'] ||  $ret[$moduleId]['has_home'] && $exitModule['enable_home']) ? false : true;
            }
        }
        return $ret;
    }

    private $allModules=null;
    
    private function loadAllModules()
    {
        if($this->allModules !== null)
        {
            return $this->allModules;
        }
        $this->allModules=[];
        
        $moduleRootPath = LuLu::getAlias('@source') . '/modules';
        
        if ($moduleRootDir = @ dir($moduleRootPath))
        {
            while (($moduleFolder = $moduleRootDir->read()) !== false)
            {
                $modulePath = $moduleRootPath . '/' . $moduleFolder;
                if (preg_match('|^\.+$|', $moduleFolder) || ! is_dir($modulePath))
                {
                    continue;
                }
                
                if ($moduleDir = @ dir($modulePath))
                {
                    $moduleClassName = ucwords($moduleFolder);
                    
                    $class=null;
                    $instance = null;
                    $has_admin= false;
                    $has_home=false;
                    
                    while (($item = $moduleDir->read()) !== false)
                    {
                        $itemPath = $moduleRootPath . '/' . $moduleFolder . '/' . $item;
                        if (preg_match('|^\.+$|', $item) || is_dir($itemPath))
                        {
                            continue;
                        }
                        if ($item === $moduleClassName . 'Info.php')
                        {
                            $class = 'source\modules\\' . $moduleFolder . '\\' . $moduleClassName . 'Info';
                        }
                        if ($item === 'AdminModule.php')
                        {
                            $has_admin = true;
                        }
                        if ($item === 'HomeModule.php')
                        {
                            $has_home = true;
                        }
                    }
                    if($class!==null)
                    {
                        try
                        {
                            // $moduleObj = LuLu::createObject($class);
                            $instance = new $class();
                            if (empty($instance->id))
                            {
                                $instance->id = $moduleFolder;
                            }
                            if (empty($instance->name))
                            {
                                $instance->name = $moduleFolder;
                            }
                        }
                        catch (Exception $e)
                        {
                            // $instance=$e;
                        }
                    }
                    if($instance!==null)
                    {
                        $this->allModules[$instance->id] = [
                            'id' => $instance->id,
                            'dir'=>$moduleFolder,
                            'dir_class'=>$moduleClassName,
                            'class' => $class,
                            'instance' => $instance,
                            
                            'can_install' => true,
                            'can_uninstall' => true,
                            'has_admin' => $has_admin,
                            'has_home' => $has_home,
                            'can_active_admin' => false,
                            'can_active_home' => false
                        ];
                    }
                }
            }
        }
        return $this->allModules;
    }
}
