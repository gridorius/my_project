<?php

namespace Modules\PageView;

class PageView extends PartialView
{
    protected static $sections = [];

    public static function addSection($name, $output){
        static::$sections[$name] = $output;
    }

    public static function showSection($name){
        static::$sections[$name]();
    }

    public function send()
    {
        ob_start();
        parent::send();
        $content = ob_get_contents();
        ob_clean();

        $this->data['_page_content'] = $content;

        $layout = new PartialView(static::$layout);
        $layout->assign($this->data)->send();
    }
}
