<?php
require_once 'Builder.php';
require_once 'Helpers/Path.php';

$modules = Builder::buildFolderRecursively(\Helpers\Path::root('Modules'));

foreach ($modules as $module)
    require_once($module);

require_once 'Modules/PageView/BasePageView.php';
require_once 'Modules/PageView/PartialView.php';
require_once 'Modules/PageView/PageView.php';
require_once 'Helpers/Path.php';

use Modules\PageView\PageView;

PageView::setLayout('layout.test');
PageView::addDirective('for', 'for(?):');
PageView::addDirective('endfor', 'endfor');
PageView::addDirective('showSection', 'PageView::showSection(?)');
PageView::addDirective('section', 'PageView::addSection(?, function(){');
PageView::addDirective('endsection', '})require');
PageView::addDirective('content', 'echo $_page_content');

$view = new PageView('test');
$viewl = new \Modules\PageView\PartialView('layout.test');
$view->cache();
$viewl->cache();
$view->assign(['title' => 'worked?'])->send();