<?php
// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/setup.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__ . '/../app/autoload.php';

if (php_sapi_name() === 'cli') {
    function getOptions()
    {
        $options = [];
        foreach ($_SERVER['argv'] as $arg) {
            preg_match('/\-\-(\w*)\=?(.+)?/', $arg, $value);
            if (!empty($value[1])) {
                $options[$value[1]] = empty($value[2]) ? '' : $value[2];
            }
        }
        return $options;
    }
    $options = getOptions();
    $debug = $options['env'] === 'prod' ? false : true;
} else {
    $debug = getenv('SYMFONY_DEBUG') === 'true' || getenv('SYMFONY_ENV') === 'dev';
}
if ($debug === false) {
    include_once __DIR__ . '/../var/bootstrap.php.cache';
}

$kernel = new AppKernel(($debug === true ? 'dev' : 'prod'), $debug);
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
