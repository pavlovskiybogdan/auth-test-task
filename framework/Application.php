<?php

namespace Framework;

use Framework\Routing\Router;
use Framework\Localization\Localization;
use Framework\Helpers\Request;
use Framework\Helpers\Mailer;

class Application
{
    /**
     * Dependencies
     * @var \stdClass
     */
    public static $app;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        self::$app = new \stdClass();
        $this->setDependencies();
    }

    /**
     * Start the application
     */
    public function start() : void
    {
        $localization = new Localization();
        $localization->localize();

        Router::startRouting();
    }

    /**
     * Set default dependencies
     */
    public function setDependencies()
    {
        self::$app->request = new Request();
        self::$app->mailer = new Mailer();
    }
}