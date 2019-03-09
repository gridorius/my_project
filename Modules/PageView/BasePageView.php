<?php

namespace Modules\PageView;

use Helpers\Path;

abstract class BasePageView
{
    protected $templatePath;
    protected $cachePath;

    abstract public function send($data);

    public function __construct($template)
    {
        $template = preg_replace('/\./', '/', $template);
        $this->templatePath = Path::root("Views/{$template}.php");
        $this->cachePath = Path::root('Cache/' . base64_encode($this->templatePath) . '.php');
    }

    public function cache()
    {
        $template = file_get_contents($this->templatePath);

        $template = preg_replace('/([^@]){{(.+?)}}/', '$1<?= $2 ?>', $template);
        $template = preg_replace('/@{{(.+?)}}/', '{{$1}}', $template);

        file_put_contents($this->cachePath, $template);

        return $template;
    }

    public function is_updated(){
        return filemtime($this->cachePath) < filemtime($this->templatePath);
    }
}