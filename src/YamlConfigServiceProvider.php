<?php

namespace KEIII\YamlConfigServiceProvider;

use KEIII\YamlConfig\Factory;
use Silex\ServiceProviderInterface;
use Silex\Application as Container;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Provides YAML config.
 */
class YamlConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['config.cache_path'] = false;

        $pimple['config.replacements'] = [];

        $pimple['config.env'] = $pimple::share(function (Container $pimple) {
            return $pimple->offsetExists('env') ? $pimple['env'] : 'dev';
        });

        $pimple['config.index'] = $pimple::share(function (Container $pimple) {
            return sprintf('config.%s.yml', $pimple['config.env']);
        });

        $pimple['config.loader'] = $pimple::share(function (Container $pimple) {
            return Factory::create(
                $pimple['config.path'],
                array_replace([
                    'env' => $pimple['config.env'],
                ], $pimple['config.replacements']),
                $pimple['config.cache_path']
            );
        });

        $pimple['config'] = $pimple::share(function (Container $pimple) {
            /** @var LoaderInterface $loader */
            $loader = $pimple['config.loader'];

            return $loader->load($pimple['config.index']);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Container $app)
    {
        // required by interface
    }
}
