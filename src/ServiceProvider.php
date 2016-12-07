<?php

namespace jschreuder\MailCampToolbox;

use Guzzle\Http\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['mailcamp.httpClient'] = function (Container $container) {
            return new Client($container['mailcamp.apiEndpoint']);
        };

        $container['mailcamp.client'] = function (Container $container) {
            return new MailCampClient(
                $container['mailcamp.httpClient'],
                $container['mailcamp.username'],
                $container['mailcamp.token']
            );
        };
    }
}