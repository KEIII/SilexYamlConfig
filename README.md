Provides symfony like config style for silex application.

## Installation

```bash
composer require keiii/silex-yaml-config
```

## Usage

```php
<?php
$app->register(new \KEIII\YamlConfigServiceProvider\YamlConfigServiceProvider(), [
    'config.path' => __DIR__.'/config',
    // 'config.cache_path' => '/var/tmp',
    // 'config.replacements' => ['root_path' => __DIR__],
    // 'config.env' => 'dev',
    // 'config.index' => 'config.yml',
    // 'config.loader' => LoaderInterface,
]);
$app['config']['key']; // value;
```
