<?php

namespace KEIII\YamlConfigServiceProviderTests;

use KEIII\YamlConfigServiceProvider\YamlConfigServiceProvider;
use Silex\Application;
use Silex\WebTestCase;

/**
 * Yaml Config Service Provider Test.
 */
class YamlConfigServiceProviderTest extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    public function createApplication()
    {
        $app = new Application();
        $app->register(new YamlConfigServiceProvider(), [
            'config.path' => __DIR__.'/fixtures',
        ]);

        return $app;
    }

    public function testRegister()
    {
        $app = $this->createApplication();

        self::assertEquals(['key' => 'value'], $app['config']);
    }
}
