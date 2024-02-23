# Jobtech Opensearch Support

## Install
Install the package in your application using composer

```shell
composer require jobtech/laravel-opensearch
```

Publish vendor

```shell
php artisan laravel-opensearch:install
```

## Usage
Create own index that implements
```php
\Jobtech\Support\Opensearch\Contracts\Index
```

Declare in opensearch.php file your index

```php
'indices' => [
],
```

---
Which endpoints have been implemented:

# Index
    - create index
    - delete index
    - open index
    - close index
    - index existence check
    - update (put) `mappings` index
    - update (put) `settings` index

# Document
    - create document
    - update document
    - upsert document
    - delete document
    - count document
    - search without pagination
    - search with pagination
