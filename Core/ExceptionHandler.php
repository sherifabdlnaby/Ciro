<?php

namespace App\Core;


class ExceptionHandler
{
    /**
     * Enable Exception Handler
     */
    public static function enableExceptionHandler()
    {
        set_exception_handler(array(ExceptionHandler::class, 'exceptionHandler'));
        set_error_handler(array(ExceptionHandler::class, 'errorHandler'));
    }

    /**
     * @param $exception
     * @throws \Exception
     */
    public static function exceptionHandler($exception)
    {
        if (Config::get('log_exceptions_errors') == true)
            self::logException($exception);

        //Throw Exception again to show details for Developer if error reporting is ON. also will stop script execution.
        throw $exception;
    }

    /**
     * @param $errorLevel
     * @param $errorMessage
     * @param $errorFile
     * @param $errorLine
     * @throws \ErrorException
     */
    public static function errorHandler($errorLevel, $errorMessage, $errorFile, $errorLine)
    {
        /* throw exception for all error types except NOTICE & STRICT */
        if ($errorLevel !== E_NOTICE && $errorLevel !== E_STRICT) {
            throw new \ErrorException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
        }
    }

    /**
     * @param \Exception $exception
     */
    private static function logException($exception)
    {
        error_log($exception . PHP_EOL , 3, Config::get('exception_handler_log_destination'));
    }
}