<?php

class Builder
{
    public static function buildFolder($path)
    {
        $all = glob($path . '/*');
        $files = [];

        foreach ($all as $item)
            if (is_file($item))
                $files[] = $item;

        return $files;
    }

    public static function buildFolderRecursively($path, &$cached = [])
    {
        $all = glob($path . '/*');

        $files = [];
        $namespace = '';
        $context = '';
        $uses = [];

        foreach ($all as $item) {
            if (is_file($item))
                $files[] = $item;
        }

        foreach ($all as $item) {
            if (is_dir($item))
                static::buildFolderRecursively($item, $cached);
        }

        foreach ($files as $file) {
            foreach (file($file) as $line) {
                if (preg_match('/<\?php/', $line)) {

                } else if (preg_match('/namespace .+?;/', $line)) {
                    $namespace = $line;
                } else if (preg_match('/use .+?;/', $line)) {
                    $uses[$line] = $line;
                } else {
                    $context .= $line;
                }
            }
        }

        if ($context)
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/Cache/' . base64_encode($path) . '.php',
                "<?php \n" . implode('', [$namespace, implode("\n", $uses), $context]));

        return $cached;
    }
}