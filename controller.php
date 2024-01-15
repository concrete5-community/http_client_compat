<?php

namespace Concrete\Package\HttpClientCompat;

use Concrete\Core\Database\EntityManager\Provider\ProviderInterface;
use Concrete\Core\Package\Package;
use CHttpClient\ServiceProvider;

defined('C5_EXECUTE') or die('Access denied.');

class Controller extends Package implements ProviderInterface
{
    /**
     * The package handle.
     *
     * @var string
     */
    protected $pkgHandle = 'http_client_compat';

    /**
     * The package version.
     *
     * @var string
     */
    protected $pkgVersion = '1.0.0';

    /**
     * The minimum concrete5 version.
     *
     * @var string
     */
    protected $appVersionRequired = '8.5.0';

    /**
     * Map folders to PHP namespaces, for automatic class autoloading.
     *
     * @var array
     */
    protected $pkgAutoloaderRegistries = [
        'src' => 'CHttpClient',
    ];

    /**
     * {@inheritdoc}
     */
    public function getPackageName()
    {
        return t('HTTP Client Compat');
    }

    /**
     * {@inheritdoc}
     */
    public function getPackageDescription()
    {
        return t('A package that makes it easy to perform HTTP requests both for concrete5 v8 and ConcreteCMS v9+.');
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Database\EntityManager\Provider\ProviderInterface::getDrivers()
     */
    public function getDrivers()
    {
        return [];
    }

    public function on_start()
    {
        $this->app->make(ServiceProvider::class)->register();
    }
}
