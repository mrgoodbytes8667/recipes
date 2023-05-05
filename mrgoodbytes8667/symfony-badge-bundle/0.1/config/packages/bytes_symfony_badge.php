<?php

use Symfony\Config\BytesSymfonyBadgeConfig;

return static function (BytesSymfonyBadgeConfig $config) {
    $config->cachePath('%env(SYMFONY_BADGE_CACHE_PATH)%');
};
