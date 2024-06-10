<?php

namespace Jobtech\Support\OpenSearch;

use OpenSearch\Client;
use OpenSearch\ClientBuilder;
use Jobtech\Support\OpenSearch\Config\Config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as Provider;
use Jobtech\Support\OpenSearch\Helpers\PrefixHelper;
use Jobtech\Support\OpenSearch\Managers\IndexManager;
use Jobtech\Support\OpenSearch\Enums\OpenSearchConfig;
use Jobtech\Support\OpenSearch\Managers\SearchManager;
use Jobtech\Support\OpenSearch\Managers\DocumentManager;
use Jobtech\Support\OpenSearch\Contracts\Index as IndexContract;
use Jobtech\Support\OpenSearch\Config\Contracts\Config as ConfigContract;
use Jobtech\Support\OpenSearch\Helpers\Contracts\PrefixHelper as PrefixHelperContract;
use Jobtech\Support\OpenSearch\Managers\Contracts\IndexManager as IndexManagerContract;
use Jobtech\Support\OpenSearch\Managers\Contracts\SearchManager as SearchManagerContract;
use Jobtech\Support\OpenSearch\Managers\Contracts\DocumentManager as DocumentManagerContract;

class JtOpenSearchServiceProvider extends Provider
{
    private array $bindingManagers = [
        DocumentManagerContract::class => DocumentManager::class,
        IndexManagerContract::class => IndexManager::class,
        SearchManagerContract::class => SearchManager::class,
    ];

    private array $bindingHelpers = [
        PrefixHelperContract::class => PrefixHelper::class,
    ];

    private array $bindingConfigs = [
        ConfigContract::class => Config::class,
    ];

    private array $bindingFacades = [
        'open-search-document-manager' => DocumentManagerContract::class,
        'open-search-index-manager' => IndexManagerContract::class,
        'open-search-search-manager' => SearchManagerContract::class,
    ];

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'./../config/config.php', 'opensearch');

        $this->registerManagerBindings();

        $this->registerHelperBindings();

        $this->registerConfigBindings();

        $this->validateIndices();

        $this->registerFacades();

        $this->app->singleton(Client::class, fn (Application $app) => ClientBuilder::fromConfig($app['config']->get('opensearch.client')));
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/. /config/config.php' => config_path('IndexManager.php'),
        ], 'jt-opensearch-config');
    }

    private function registerManagerBindings(): void
    {
        foreach ($this->bindingManagers as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    private function registerHelperBindings(): void
    {
        foreach ($this->bindingHelpers as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    private function registerConfigBindings(): void
    {
        foreach ($this->bindingConfigs as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    private function registerFacades(): void
    {
        foreach ($this->bindingFacades as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    private function validateIndices(): void
    {
        foreach (config(OpenSearchConfig::INDICES_KEY->value, []) as $index) {
            if (!(class_implements($index)[IndexContract::class] ?? false)) {
                throw new \InvalidArgumentException(sprintf('Please provide valid opensearch index implementation for %s', $index));
            }

            $this->app->bind(OpenSearchConfig::INDICES_KEY->value.$index, $index);
        }
    }
}
