<?php

namespace CrystalCode\Php\Common\Injectors;

use CrystalCode\Php\Common\ExceptionBase;
use Exception;

final class InjectorException extends ExceptionBase
{

    /**
     * 
     * @param string $name
     * @return string
     */
    public static function getParameterInjectionFailedMessage($name)
    {
        return sprintf('Failed to inject parameter `%s`', (string) $name);
    }

    /**
     * 
     * @param string $className
     * @return string
     */
    public static function getDefinitionInjectionFailedMessage($className)
    {
        return sprintf('Failed to inject definition `%s`', (string) $className);
    }

    /**
     * 
     * @param type $message
     * @param type $code
     * @param Exception $innerException
     * @return void
     */
    public function __construct($message = null, $code = null, Exception $innerException = null)
    {
        if ($message === null) {
            $message = 'Failed to inject';
        }
        parent::__construct($message, $code, $innerException);
    }

}
