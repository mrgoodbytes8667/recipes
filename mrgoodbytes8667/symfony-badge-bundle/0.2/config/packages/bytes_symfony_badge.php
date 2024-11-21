<?php

use Symfony\Config\BytesSymfonyBadgeConfig;

return static function (BytesSymfonyBadgeConfig $config) {
    $config->cachePath('%kernel.project_dir%/var/cache/%kernel.environment%/bytes_symfony_badge');
};
