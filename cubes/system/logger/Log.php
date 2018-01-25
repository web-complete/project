<?php

namespace cubes\system\logger;

use WebComplete\core\utils\logger\LoggerService;

class Log
{
    /**
     * @var LoggerService
     */
    protected static $service;
    protected static $context = [];

    /**
     * @param string $message
     * @param string|array $category
     */
    public static function info(string $message, $category = 'app')
    {
        $categories = (array)$category;
        $categories[] = '*';

        foreach ($categories as $name) {
            self::getService()->get($name)->info($message, self::$context);
        }
    }

    /**
     * @param string $message
     * @param string|array $category
     */
    public static function warning(string $message, $category = 'app')
    {
        $categories = (array)$category;
        $categories[] = '*';

        foreach ($categories as $name) {
            self::getService()->get($name)->warning($message, self::$context);
        }
    }

    /**
     * @param string $message
     * @param string|array $category
     */
    public static function error(string $message, $category = 'app')
    {
        $categories = (array)$category;
        $categories[] = '*';

        foreach ($categories as $name) {
            self::getService()->get($name)->error($message, self::$context);
        }
    }

    /**
     * @param \Exception $exception
     * @param string $category
     */
    public static function exception($exception, $category = 'app')
    {
        $categories = (array)$category;
        $categories[] = '*';

        $message = $exception->getMessage() . "\n";
        $message .= $exception->getTraceAsString();

        foreach ($categories as $name) {
            self::getService()->get($name)->emergency($message, self::$context);
        }
    }

    /**
     * @param array $context
     */
    public static function setContext(array $context)
    {
        self::$context = $context;
    }

    /**
     * @param LoggerService $service
     */
    public static function setService(LoggerService $service)
    {
        self::$service = $service;
    }

    /**
     * @return LoggerService
     */
    protected static function getService(): LoggerService
    {
        if (!self::$service) {
            global $application;
            self::$service = $application->getContainer()->get(LoggerService::class);
        }
        return self::$service;
    }
}
