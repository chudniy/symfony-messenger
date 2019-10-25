<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'messenger.middleware.send_message' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/messenger/Middleware/MiddlewareInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/messenger/Middleware/SendMessageMiddleware.php';
include_once $this->targetDirs[3].'/vendor/symfony/messenger/Transport/Sender/SendersLocatorInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/messenger/Transport/Sender/SendersLocator.php';

$this->privates['messenger.middleware.send_message'] = $instance = new \Symfony\Component\Messenger\Middleware\SendMessageMiddleware(new \Symfony\Component\Messenger\Transport\Sender\SendersLocator(['App\\Message\\AddPonkaToImage' => [0 => 'async'], 'App\\Message\\DeletePhotoFile' => [0 => 'async']], new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'async' => ['privates', 'messenger.transport.async', 'getMessenger_Transport_AsyncService.php', true],
], [
    'async' => '?',
])));

$instance->setLogger(($this->privates['monolog.logger.messenger'] ?? $this->load('getMonolog_Logger_MessengerService.php')));

return $instance;
