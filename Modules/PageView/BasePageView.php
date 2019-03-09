<?php

namespace Modules\PageView;

use Helpers\Path;

abstract class BasePageView
{
    protected $template;
    protected $templatePath;
    protected $cachePath;
    protected $data = [];
    protected static $directives = [];

    protected static $layout;

    abstract public function send();

    public function __construct($template)
    {
        $this->template = $template = preg_replace('/\./', '/', $template);
        $this->templatePath = Path::views("{$template}.php");
        $this->cachePath = Path::cache(base64_encode($this->templatePath) . '.php');
    }

    public static function addDirective($name, $replacement)
    {
        static::$directives[$name] = $replacement;
    }

    public function assign($data)
    {
        $this->data = $data;
        return $this;
    }

    public static function setLayout($template)
    {
        static::$layout = $template;
    }

    public function prepare()
    {
        if (is_file($this->cachePath)) {
            if ($this->is_updated())
                $this->cache();
        } else if (is_file($this->templatePath)) {
            $this->cache();
        } else
            throw new Exception("Template {$this->templatePath} not found");
    }

    public function cache()
    {
        $template = file_get_contents($this->templatePath);

        $template = preg_replace('/([^@]){{(.+?)}}/', '$1<?= $2 ?>', $template);
        $template = preg_replace('/@{{(.+?)}}/', '{{$1}}', $template);
        if (static::$directives)
            $template = preg_replace_callback("/@(" . implode('|', array_keys(static::$directives)) . ")\(?([^)]*)?\)?/", function ($matches) {
                return '<?php ' . preg_replace('/\?/', $matches[2], self::$directives[$matches[1]]) . ' ?>';
            }, $template);

        file_put_contents($this->cachePath, $template);
    }

    public function is_updated()
    {
        return filemtime($this->cachePath) < filemtime($this->templatePath);
    }
}