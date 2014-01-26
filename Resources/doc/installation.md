Installation
============

## Prerequisites ##

This bundle requires Symfony 2.1+.

You need a database configured for Doctrine ORM.


## Installation ##

### Step 1: Download using Composer ##

Add this bundle via Composer:

```bash
php composer.phar require scheb/stock-panel-bundle
```

When being asked for the version use dev-master or any different version you want.

Alternatively you can also add the bundle directly to composer.json:

```js
{
    "require": {
        "scheb/scheb/stock-panel-bundle": "dev-master"
    }
}
```

and then tell Composer to install the bundle:

```bash
php composer.phar update scheb/scheb/stock-panel-bundle
```

### Step 2: Enable the bundle ###

Enable this bundle in your app/AppKernel.php:

```php
<?php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Scheb\StockPanelBundle\SchebStockPanelBundle(),
    );
}
```

### Step 3: Configuration ###

Extend the configuration in config.yml as follows:

```yaml
assetic:
    bundles: [ SchebStockPanelBundle ] # Add the bunde
    filters:
        lessphp: # Enable lessphp
            file: %kernel.root_dir%/../vendor/leafo/lessphp/lessc.inc.php
            apply_to: "\.(less|css)$"
        cssrewrite: ~

braincrafted_bootstrap:
    jquery_path: %kernel.root_dir%/../vendor/components/jquery/jquery.js
    less_filter: lessphp
```

Add the bundle to your routing.yml:
```yaml
scheb_stock_panel:
    resource: "@SchebStockPanelBundle/Controller/"
    type:     annotation
    prefix:   /
```


### Step 4: Install assets ###

Install assets:
```bash
php app/console assets:install
```

Run Assetic:
```bash
php app/console assetic:dump --env=prod
```

### Step 5: Create database ###

Create the datebase tables with Doctrine command:

```bash
php app/console doctrine:schema:update --force
```
