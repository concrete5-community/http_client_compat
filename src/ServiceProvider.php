<?php

namespace CHttpClient;

use Concrete\Core\Application\Application;
use Concrete\Core\Config\Repository\Repository;
use RuntimeException;

final class ServiceProvider
{
    /**
     * @var \Concrete\Core\Application\Application
     */
    private $app;

    /**
     * @var string
     */
    private $coreVersion = '';

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return $this
     */
    public function register()
    {
        $this->app->bind(Client::class, function() {
            return $this->getClient();
        });

        return $this;
    }

    /**
     * @return \CHttpClient\Client
     */
    public function getClient()
    {
        $coreVersion = $this->getCoreVersion();
        if (version_compare($coreVersion, '9') >= 0) {
            return $this->app->make(Client\V9::class);
        }
        if (version_compare($coreVersion, '8') >= 0) {
            return $this->app->make(Client\V8::class);
        }
        throw new RuntimeException(t('Unsupported Concrete version (%s)', $coreVersion));
    }

    /**
     * @return string
     */
    public function getCoreVersion()
    {
        if ($this->coreVersion === '') {
            $this->coreVersion = $this->detectCoreVersion();
        }

        return $this->coreVersion;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setCoreVersion($value)
    {
        $this->coreVersion === (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    private function detectCoreVersion()
    {
        $config = $this->app->make(Repository::class);
        $version = $config->get('concrete.version');
        if (!is_string($version) || !preg_match('/^\d+\.\d+/', $version)) {
            throw new RuntimeException(t('Failed to detect the Concrete version'));
        }

        return $version;
    }
}
