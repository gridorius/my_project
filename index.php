<?php
include_once 'Modules/PageView/BasePageView.php';
include_once 'Modules/PageView/PageView.php';
include_once 'Helpers/Path.php';

use Modules\PageView\PageView;

$view = new PageView('test');
$view->send(['title' => 'test']);