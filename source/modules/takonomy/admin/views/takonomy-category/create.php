<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model source\models\TakonomyCategory */

$this->title = '新建分类';
$this->addBreadcrumbs([
		['分类管理',['/takonomy']],
		$this->title,
		]);


?>
 <?= $this->render('_form', [
        'model' => $model,
    ]) ?>