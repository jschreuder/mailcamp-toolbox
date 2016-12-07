#!/usr/bin/php
<?php

require __DIR__ . '/vendor/autoload.php';

$app = new \Symfony\Component\Console\Application();
$container = new \Pimple\Container();
$container->register(new \jschreuder\MailCampToolbox\ServiceProvider(), require __DIR__ . '/config/main.php');

$app->add(new \jschreuder\MailCampToolbox\Command\CompareTxtToListCommand($container['mailcamp.client']));
$app->add(new \jschreuder\MailCampToolbox\Command\FindActiveListSubscribersCommand($container['mailcamp.client']));
$app->add(new \jschreuder\MailCampToolbox\Command\FindActiveSubscriptionsCommand($container['mailcamp.client']));
$app->add(new \jschreuder\MailCampToolbox\Command\GetListsCommand($container['mailcamp.client']));
$app->add(new \jschreuder\MailCampToolbox\Command\UnsubscribeSubscriberCommand($container['mailcamp.client']));

$app->run();
