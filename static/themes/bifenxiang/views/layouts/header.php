<?php 

use source\libs\Resource;
use source\models\Menu;
use source\LuLu;


$themeUrl= Resource::getThemeUrl();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title><?php echo $this->title?> —— <?php echo $this->getConfigValue('sys_site_name')?></title>
    <meta name="keywords" content="<?php echo $this->getConfigValue('sys_seo_keywords')?>">
    <meta name="description" content="<?php echo $this->getConfigValue('sys_seo_description')?>">
    <link rel='stylesheet' id='style-css' href='<?php echo $themeUrl?>/css/style.css' type='text/css' media='all' />
    <script type='text/javascript' src='<?php echo $themeUrl?>/js/jquery.min.js'></script>
    <?php $this->head() ?>
</head>
<body class="home blog" style="height:100%;">
<?php $this->beginBody() ?>
    <header id="header" class="header">
        <div class="container-inner" style="height: 60px;">
            <div class="yusi-logo" style="font-size: 40px;margin-top:15px;">
                <a href="/"><?php echo $this->getConfigValue('sys_site_name')?></a>
            </div>
            <div class="ban-r">
            	<?php echo $this->getConfigValue('sys_site_description')?>
            </div>
        </div>

        <div id="nav-header" class="navbar">
            <ul class="nav">
                <li id="menu-item-2333" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2333"><a href=".">首页</a></li>
            	<?php echo Menu::getMenuHtml('main', 0)?>
            	<li id="menu-item-yiifans" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-yiifans"><a href="http://www.yiifans.com" target="_blank">Yii交流社区</a></li>
            </ul>
        </div>
    </header>
    <section class="container" style="padding-top: 10px;height:100%;">
   