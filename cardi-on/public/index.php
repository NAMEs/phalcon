<?php

error_reporting(E_ALL);

try {

    /**
     * Read the configuration
     */
    $config = include __DIR__ . "/../app/config/config.php";

    /**
     * Read auto-loader
     */
    include __DIR__ . "/../app/config/loader.php";

    /**
     * Read services
     */
    include __DIR__ . "/../app/config/services.php";

    
    //$di = new \Phalcon\DI\FactoryDefault();
    
    $di->set('dispatcher', function() use ($di) {
        $eventsManager = $di->getShared('eventsManager');
        $security = new Security($di);
        $eventsManager->attach('dispatch', $security);
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    });

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();
} catch (\Exception $e) {
    echo $e->getMessage();
} 