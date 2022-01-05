<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * Override the cache folder if in a Vagrant VM or the environment variable USE_SHARED_CACHE_DIR is set
     * With USE_SHARED_CACHE_DIR, SHARED_CACHE_DIR can also be set to explicitly set the path
     * {@inheritdoc}
     */
    public function getCacheDir(): string
    {
        if (static::getSharedEnvBool('USE_SHARED_CACHE_DIR') && isset($_ENV['SHARED_CACHE_DIR'])) {
            return $_ENV['SHARED_CACHE_DIR'] . '/cache/' . $this->environment;
        } elseif ($this->isVagrant() || static::getSharedEnvBool('USE_SHARED_CACHE_DIR')) {
            return $this->getNonSharedVarDir() . '/cache/' . $this->environment;
        } else {
            return parent::getCacheDir();
        }
    }

    /**
     * @param string $tag
     * @return false
     */
    private static function getSharedEnvBool(string $tag): bool
    {
        if (!isset($_ENV[$tag])) {
            return false;
        }
        return filter_var($_ENV[$tag], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    /**
     * @return bool
     */
    protected function isVagrant()
    {
        return (strpos($this->getProjectDir(), 'vagrant') !== false);
    }

    /**
     * @return string
     */
    protected function getNonSharedVarDir()
    {
        return $this->getParentDir() . '/var/' . $this->getProjectName();
    }

    /**
     * @return string
     */
    protected function getParentDir()
    {
        return dirname($this->getProjectDir());
    }

    /**
     * @return string
     */
    protected function getProjectName()
    {
        return basename($this->getProjectDir());
    }

    /**
     * Override the cache folder if in a Vagrant VM or the environment variable USE_SHARED_LOG_DIR is set
     * With USE_SHARED_LOG_DIR, SHARED_LOG_DIR can also be set to explicitly set the path
     * {@inheritdoc}
     */
    public function getLogDir(): string
    {
        if (static::getSharedEnvBool('USE_SHARED_LOG_DIR') && isset($_ENV['SHARED_LOG_DIR'])) {
            return $_ENV['SHARED_LOG_DIR'] . '/log/' . $this->environment;
        } elseif ($this->isVagrant() || static::getSharedEnvBool('USE_SHARED_LOG_DIR')) {
            return $this->getNonSharedVarDir() . '/log';
        } else {
            return parent::getLogDir();
        }
    }
}