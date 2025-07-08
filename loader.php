<?php
define("BASE_PATH", __DIR__);
define('PAGE_SIZE', 10);
define("ENABLE_CACHE" , true);
define("CACHE_DIR" , BASE_PATH . "/App/cache/");
define("JWT_TOKEN" , "34wehregherhlgherlihverlihfeer");
include BASE_PATH . "/vendor/autoload.php";
include BASE_PATH . "/App/iran.php";
spl_autoload_register(function ($class) {
    $classFile = BASE_PATH . "/" . $class . ".php";
    if (!(file_exists($classFile) || is_readable($classFile))) {
        die("$classFile is not exists");
    }
    include $classFile;
});