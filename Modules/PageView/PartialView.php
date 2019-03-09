<?php

namespace Modules\PageView;

class PartialView extends BasePageView
{
    public function send()
    {
        foreach ($this->data as $key => $val)
            ${$key} = $val;

        $this->prepare();

        include_once($this->cachePath);
    }
}