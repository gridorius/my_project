<?php

namespace Modules\PageView;

use mysql_xdevapi\Exception;

class PageView extends BasePageView
{

    public function send($data)
    {
        foreach ($data as $key => $val)
            ${$key} = $val;

        if (is_file($this->cachePath)) {
            if ($this->is_updated())
                $this->cache();
        } else if (is_file($this->templatePath)) {
            $this->cache();
        } else
            throw new Exception("Template {$this->templatePath} not found");

        include_once($this->cachePath);
    }
}