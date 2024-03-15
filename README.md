<p align="center">
<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://banners.beyondco.de/Jobtech%20OpenSearch%20Support.png?theme=dark&packageManager=composer+require&packageName=jobtech%2Fjt-opensearch-support&pattern=architect&style=style_1&description=OpenSearch+wrapper&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg">
  <source media="(prefers-color-scheme: light)" srcset="https://banners.beyondco.de/Jobtech%20OpenSearch%20Support.png?theme=light&packageManager=composer+require&packageName=jobtech%2Fjt-opensearch-support&pattern=architect&style=style_1&description=OpenSearch+wrapper&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg">
  <img src="https://banners.beyondco.de/Jobtech%20OpenSearch%20Support.png?theme=light&packageManager=composer+require&packageName=jobtech%2Fjt-opensearch-support&pattern=architect&style=style_1&description=OpenSearch+wrapper&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg" alt="Social Card of Laravel Markable">
</picture>
</p>

# Jobtech OpenSearch Support
This package makes it easy to communicate with OpenSearch

## Installation
Install the package in your application using composer

```shell
composer require jobtech/laravel-opensearch
```

Publish vendor

```shell
php artisan laravel-opensearch:install --tag="jt-opensearch-config"
```

This is the content of the published config file:

```php

return [
    /*
    |--------------------------------------------------------------------------
    | Client config
    |--------------------------------------------------------------------------
    |
    | This is where client configurations are set up
    |
    */
    'client' => [
        'hosts' => [
            'host' => env('OPENSEARCH_HOST'),
        ],
        'basicAuthentication' => [env('OPENSEARCH_USER'), env('OPENSEARCH_SECRET')],
    ],

    /*
    |--------------------------------------------------------------------------
    | Indices config
    |--------------------------------------------------------------------------
    |
    | Put OpenSearch indices here
    |
    */
    'indices' => [],

    /*
    |--------------------------------------------------------------------------
    | Indices prefix
    |--------------------------------------------------------------------------
    |
    | Enter the OpenSearch prefix if you want indexes to have a specific prefix
    |
    */
    'prefix' => env('OPENSEARCH_PREFIX'),
];
```

## Usage
Create own index that implements
```php
\Jobtech\Support\OpenSearch\Contracts\Index
```

Declare in opensearch.php file your indices

```php
'indices' => [
    //your index
],
```

Configure the connection parameters to OpenSearch, as host and basicAuthentication.

```php
'client' => [
    'hosts' => [],
    'basicAuthentication' => [],
]
```

There is the possibility of adding a prefix to the indexes that are created with this package.
The prefix is then handled automatically by the package.

```php
'prefix' => [
    //your prefix
]
```

## API

### existsIndex
Returns whether or not an index already exists.
```php
$bool = IndexManager::existsIndex($index) // return OpenSearch response
```

### getIndex
This operation returns information on an index.
```php
$array = IndexManager::getIndex($index) // return OpenSearch response
```

### createIndex
An empty index can be created for later use.
When creating an index, it is possible to specify its mappings, settings and aliases.
```php
$array = IndexManager::createIndex($index) // return OpenSearch response
```

### putIndexSettings
Index-level settings can be updated. Dynamic index settings can be changed at any time, whereas static settings cannot be changed after the index has been created.
```php
$array = IndexManager::putIndexSettings($index) // return OpenSearch response
```

### putIndexMappings
It is possible to create or add mappings and fields to an index.
This operation cannot be used to update mappings that already correspond to existing data in the index.
```php
$array = IndexManager::putIndexMappings($index) // return OpenSearch response
```

### deleteIndex
This operation delete an index.
```php
$array = IndexManager::deleteIndex($index) // return OpenSearch response
```

### openIndex
A closed index can be opened, allowing data to be added or searched within the index.
```php
$array = IndexManager::openIndex($index) // return OpenSearch response
```

### closeIndex
This operation closes an index. Once an index is closed, it is no longer possible to add data to it or search for data within the index.
```php
$array = IndexManager::closeIndex($index) // return OpenSearch response
```

### retrieveDocument
This api permit to retrieve a document with information and data, from index with specified id.
```php
$document = DocumentManager::retrieveDocument('index', 'id') // return OpenSearch response
```

### createDocument
It allows a document to be created with its data and a specific id.
```php
$array = DocumentManager::createDocument('index', 'id', ['']) // return OpenSearch response
```

### createDocumentWithoutId
It allows a document to be created with its data and without a specific id.
```php
$array = DocumentManager::createDocumentWithoutId('index', ['']) // return OpenSearch response
```

### createDocumentFrom
Allows you to create a document from an array of specific parameters.,
```php
$array = DocumentManager::createDocumentFrom([
    'index' => 'index',
    'id' => 'id',
    'body' => [''],
    'refresh' => true
]) // return OpenSearch response
```

### updateDocument
It is possible to update the fields of a document in a specific index. Is it possible specify new data to be included in the index.
```php
$array = DocumentManager::updateDocument('index', 'id', ['']) // return OpenSearch response
```

### upsertDocument
Upsert is an operation that conditionally either updates an existing document or inserts a new one based on information in the object.
```php
$array = DocumentManager::upsertDocument('index', 'id', ['']) // return OpenSearch response
```

### deleteDocument
This operation delete a document.
```php
$array = DocumentManager::deleteDocument('index', 'id') // return OpenSearch response
```

### countDocument
Returns how many document there are in the index.
```php
$count = DocumentManager::countDocument('index') // return OpenSearch response
```

### search
Allows a search request to be made to search for data in the cluster according to the required parameters.
```php
$search = SearchManager::search('index') // return OpenSearch response
```

### searchWithPagination
Allows a search request to be made to search for data in the cluster according to the required parameters.
Everything is returned with a pagination.
```php
$search = SearchManager::searchWithPagination('index', 1, 10) // return OpenSearch response
```

## Testing
```bash
composer test
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities
Please review [SECURITY](SECURITY.md) on how to report security vulnerabilities.

## Credits
- [Alessandro Romano](https://github.com/Dasheel)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.