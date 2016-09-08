<?php

namespace KEIII\YamlConfigServiceProvider;

use KEIII\YamlConfig\Factory;
use KEIII\YamlConfig\SimpleLoaderInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

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

        $pimple['config.debug'] = function (Container $pimple) {
            return $pimple->offsetExists('debug') ? $pimple['debug'] : false;
        };

        $pimple['config.env'] = function (Container $pimple) {
            return $pimple->offsetExists('env') ? $pimple['env'] : 'dev';
        };

        $pimple['config.index'] = function (Container $pimple) {
            return sprintf('config_%s.yml', $pimple['config.env']);
        };

        $pimple['config.loader'] = function (Container $pimple) {
            return Factory::create(
                $pimple['config.path'],
                array_replace([
                    'env' => $pimple['config.env'],
                ], $pimple['config.replacements']),
                $pimple['config.cache_path'],
                $pimple['config.debug']
            );
        };

        $pimple['config'] = function (Container $pimple) {
            /** @var SimpleLoaderInterface $loader */
            $loader = $pimple['config.loader'];

            return $loader->load($pimple['config.index']);
        };
    }
}
