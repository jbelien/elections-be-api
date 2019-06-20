<?php

declare (strict_types = 1);

namespace App;

class Cache
{
    const ENABLE_CACHE = 'data_cache_enabled';

    public $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function get()
    {
        if (file_exists($this->path) && is_readable($this->path)) {
            return json_decode(file_get_contents($this->path));
        }

        return null;
    }

    public function set($data)
    {
        $directory = dirname($this->path);
        if (!file_exists($directory) || !is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $json = json_encode($data);

        file_put_contents($this->path, $json);

        return $json;
    }

    public static function path(string $route, array $params = []): string
    {
        if (count($params) === 0) {
            return sprintf('data/cache/api/%s.json', $route);
        }

        return sprintf('data/cache/api/%s/%s.json', str_replace('.', '/', $route), implode('/', array_values($params)));
    }
}
