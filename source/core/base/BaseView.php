<?php
namespace source\core\base;

use Yii;
use app\Models\User;
use source\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\web\View;
use source\models\Config;
use source\libs\Common;
use source\core\widgets\LoopData;
use source\libs\Resource;
use source\core\widgets\LinkPager;
use source\libs\DataSource;

class BaseView extends View
{

    public function renderFile($viewFile, $params = [], $context = null)
    {
        if ($this->theme == null)
        {
            $this->setTheme();
        }
        return parent::renderFile($viewFile, $params, $context);
    }

    public function setTheme()
    {
    }
	
	public function addBreadcrumbs($items)
	{
		foreach ($items as $item)
		{
			if(is_array($item))
			{
				if(isset($item[2]))
				{
					$this->params['breadcrumbs'][] = ['label' => $item[0], 'url' => $item[1], 'img'=>$item[2]];
				}
				else
				{
					$this->params['breadcrumbs'][] = ['label' => $item[0], 'url' => $item[1]];
				}
			}
			else
			{
				$this->params['breadcrumbs'][] = $item;
			}
		}
	}

	public function getThemeUrl($url)
	{
	    $themeUrl = Resource::getThemeUrl($url);
	    return $themeUrl;
	}
	
	public function getDataSource($where=null,$orderBy=null,$limit=10,$options=[])
	{
	    $datas = DataSource::getContents($where,$orderBy,$limit,$options);
	    return $datas;
	}
	
	public function linkPager($pager)
	{
	    echo LinkPager::widget(['pagination' => $pager,]);
	}
	
	public function loopData($dataSource,$item,$appendOptions=[])
	{
	    $options=[];
	    $options['dataSource']=$dataSource;
	    $options['item']=Resource::getThemePath($item);
	    
	    echo LoopData::widget($options);
	}
	
	public function beginLoopData($dataSource,$item,$appendOptions=[])
	{
	    $options=[];
	    $options['dataSource']=$dataSource;
	    $options['item']=Resource::getThemePath($item);
	    
	    return LoopData::begin($options);
	}
	public function endLoopData()
	{
	    LoopData::end();
	}
	
    public function getConfig($id)
    {
        return Common::getConfig($id);
    }

    public function getConfigValue($id)
    {
        return Common::getConfigValue($id);
    }
    
}
