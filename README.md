# Jobtech Opensearch Support

## Install
Install the package in your application using composer

```shell
composer require jobtech/jt-opensearch-support
```

Publish vendor

```shell
php artisan jt-opensearch:install
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
Che cosa deve fare il mio package Laravel?

# Index
    - creazione indice
    - eliminazione indice
    - apertura indice
    - chiusura indice
    - verifica esistenza indice
    - aggiornamento `mappings` indice
    - aggiornamento `settings` indice

# Document
    - creazione documento
    - aggiornamento documento
    - upsert documento
    - eliminazione del documento
    - count dei documenti
    - ricerca senza paginazione
    - ricerca con paginazione
