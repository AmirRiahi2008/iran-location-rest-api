<?php

namespace App\Utilities;
use App\Utilities\Response;
class Cache
{
    protected static $cacheFile;
    protected static $cacheEnabled = ENABLE_CACHE;
    const EXPIRE_TIME = 3600;
    public static function init()
    {
        self::$cacheFile = CACHE_DIR . md5($_SERVER["REQUEST_URI"]) . ".json";
        if ($_SERVER["REQUEST_METHOD"] !== "GET")
            self::$cacheEnabled = 0;
    }

    public static function cacheExists()
    {
        return (file_exists(self::$cacheFile) && (time() - self::EXPIRE_TIME) < fileatime(self::$cacheFile));
    }
    public static function start()
    {
        self::init();
        if (!self::$cacheEnabled)
            return;
        if (self::cacheExists()) {
            Response::setHeaders();
            readfile(self::$cacheFile);
            exit;
        }
        ob_start();
    }
    public static function end()
    {
        if (!self::$cacheEnabled)
            return;
        $cachedFile = fopen(self::$cacheFile, "w");
        fwrite($cachedFile, ob_get_contents());
        fclose($cachedFile);
        ob_end_flush();
    }
    public static function flush()
    {
        $files = glob(CACHE_DIR . "*");
        foreach ($files as $item) {
            if (is_file($item))
                unlink($item);
        }
    }
}