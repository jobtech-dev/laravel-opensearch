<?php

namespace Jobtech\Support\Opensearch;

use OpenSearch\Client;
use OpenSearch\ClientBuilder;
use Jobtech\Support\Opensearch\Config\Config;
use Jobtech\Support\Opensearch\Contracts\Index;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as Provider;
use Jobtech\Support\Opensearch\Helpers\PrefixHelper;
use Jobtech\Support\Opensearch\Enums\OpensearchConfig;
use Jobtech\Support\Opensearch\Managers\SearchManager;
use Jobtech\Support\Opensearch\Managers\IndicesManager;
use Jobtech\Support\Opensearch\Managers\DocumentManager;
use Jobtech\Support\Opensearch\Config\Contracts\Config as ConfigContract;
use Jobtech\Support\Opensearch\Helpers\Contracts\PrefixHelper as PrefixHelperContract;
use Jobtech\Support\Opensearch\Managers\Contracts\SearchManager as SearchManagerContract;
use Jobtech\Support\Opensearch\Managers\Contracts\IndicesManager as IndicesManagerContract;
use Jobtech\Support\Opensearch\Managers\Contracts\DocumentManager as DocumentManagerContract;

class JtOpensearchServiceProvider extends Provider
{
    private array $bindingManagers = [
        DocumentManagerContract::class => DocumentManager::class,
        IndicesManagerContract::class => IndicesManager::class,
        SearchManagerContract::class => SearchManager::class,
    ];

    private array $bindingHelpers = [
        PrefixHelperContract::class => PrefixHelper::class,
    ];

    private array $bindingConfigs = [
        ConfigContract::class => Config::class,
    ];

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'./../config/config.php', 'opensearch');

        $this->registerManagerBindings();

        $this->registerHelperBindings();

        $this->registerConfigBindings();

        $this->validateIndices();

        $this->app->singleton(Client::class, fn (Application $app) => ClientBuilder::fromConfig($app['config']->get('opensearch.client')));
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/. /config/config.php' => config_path('opensearch.php'),
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

    private function validateIndices(): void
    {
        foreach (config(OpensearchConfig::INDICES_KEY->value, []) as $index) {
            if (!(class_implements($index)[Index::class] ?? false)) {
                throw new InvalidArgumentException(sprintf('Please provide valid opensearch index implementation for %s', $index));
            }

            $this->app->bind(OpensearchConfig::INDICES_KEY->value.$index, $index);
        }
    }
}
