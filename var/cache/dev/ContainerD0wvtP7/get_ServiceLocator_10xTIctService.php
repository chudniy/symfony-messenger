<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.10xTIct' shared service.

return $this->privates['.service_locator.10xTIct'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'imagePost' => ['privates', '.errored..service_locator.10xTIct.App\\Entity\\ImagePost', NULL, 'Cannot autowire service "debug.traced.messenger.bus.default.inner": it references class "App\\Entity\\ImagePost" but no such service exists.'],
    'messageBus' => ['services', 'message_bus', 'getMessageBusService', false],
], [
    'imagePost' => 'App\\Entity\\ImagePost',
    'messageBus' => '?',
]);
