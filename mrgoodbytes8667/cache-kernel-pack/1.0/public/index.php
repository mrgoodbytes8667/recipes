<?php

use App\CacheKernel;
use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

/**
 * @param array $context
 * @return CacheKernel|Kernel
 */
return function (array $context) {
    $kernel = new Kernel($context['APP_ENV'], (bool)$context['APP_DEBUG']);
    if ($kernel->getEnvironment() === 'prod') {
        $kernel = new CacheKernel($kernel);
    }
    return $kernel;
};
